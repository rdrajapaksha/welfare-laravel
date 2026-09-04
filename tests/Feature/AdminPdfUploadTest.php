<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminPdfUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_members_cannot_upload_a_document_pdf(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        Member::factory()->forUser($user)->create();

        $this->actingAs($user)
            ->post(route('admin.documents.store'), [
                'title_en' => 'Donation receipt guide',
                'category' => 'GUIDE',
                'file' => $this->pdf('guide.pdf'),
            ])
            ->assertForbidden();

        $this->assertSame(0, Document::query()->count());
    }

    public function test_document_form_rejects_a_missing_pdf(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->from(route('admin.documents.index'))
            ->post(route('admin.documents.store'), [
                'title_en' => 'Donation receipt guide',
                'category' => 'GUIDE',
            ])
            ->assertRedirect(route('admin.documents.index'))
            ->assertSessionHasErrors('file');

        $this->assertSame(0, Document::query()->count());
    }

    public function test_document_form_rejects_a_non_pdf_upload(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->from(route('admin.documents.index'))
            ->post(route('admin.documents.store'), [
                'title_en' => 'Donation receipt guide',
                'category' => 'GUIDE',
                'file' => UploadedFile::fake()->image('not-a-pdf.jpg', 400, 300),
            ])
            ->assertRedirect(route('admin.documents.index'))
            ->assertSessionHasErrors('file');

        $this->assertSame(0, Document::query()->count());
    }

    public function test_admin_can_publish_a_document_pdf_for_download(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post(route('admin.documents.store'), [
                'title_en' => 'Donation receipt guide',
                'category' => 'GUIDE',
                'file' => $this->pdf('guide.pdf'),
            ])
            ->assertRedirect();

        $document = Document::query()->where('title_en', 'Donation receipt guide')->first();

        $this->assertNotNull($document);
        Storage::disk('public')->assertExists($document->file_url);

        $this->get('/en/documents')
            ->assertSee('Donation receipt guide', false)
            ->assertSee(media_url($document->file_url), false);
    }

    private function pdf(string $name): UploadedFile
    {
        return UploadedFile::fake()->createWithContent(
            $name,
            "%PDF-1.4\n1 0 obj\n<< /Type /Catalog >>\nendobj\ntrailer\n<< /Root 1 0 R >>\n%%EOF\n",
        );
    }
}
