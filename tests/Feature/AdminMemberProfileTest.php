<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminMemberProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_member_page_shows_full_contact_details(): void
    {
        $admin = User::factory()->admin()->create();
        $member = Member::factory()->create([
            'full_name' => 'Kamal Perera',
            'nic' => '198512345678',
            'phone' => '0771234501',
            'address_line1' => '42 Mahulpotha',
            'city' => 'Bandarawela',
            'occupation' => 'Teacher',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.members.show', $member))
            ->assertSee('Kamal Perera', false)
            ->assertSee('198512345678', false)
            ->assertSee('0771234501', false)
            ->assertSee('42 Mahulpotha', false)
            ->assertSee('Bandarawela', false)
            ->assertSee('Teacher', false);
    }

    public function test_admin_can_update_a_member_name_and_photo(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();
        $member = Member::factory()->create(['full_name' => 'Old Name']);

        $this->actingAs($admin)
            ->put(route('admin.members.update', $member), [
                'full_name' => 'New Name',
                'name_with_initials' => 'N. Name',
                'nic' => $member->nic,
                'address_line1' => $member->address_line1,
                'city' => $member->city,
                'phone' => $member->phone,
                'membership_type' => 'ORDINARY',
                'status' => 'ACTIVE',
                'photo' => UploadedFile::fake()->image('portrait.jpg', 200, 240),
            ])
            ->assertRedirect();

        $member->refresh();

        $this->assertSame('New Name', $member->full_name);
        $this->assertNotNull($member->photo_url);
        Storage::disk('public')->assertExists($member->photo_url);
    }

    public function test_members_cannot_update_another_member_profile(): void
    {
        $user = User::factory()->create();
        Member::factory()->forUser($user)->create();
        $other = Member::factory()->create();

        $this->actingAs($user)
            ->put(route('admin.members.update', $other), [
                'full_name' => 'Hacked',
                'nic' => $other->nic,
                'address_line1' => $other->address_line1,
                'city' => $other->city,
                'phone' => $other->phone,
                'membership_type' => 'ORDINARY',
                'status' => 'ACTIVE',
            ])
            ->assertForbidden();
    }
}
