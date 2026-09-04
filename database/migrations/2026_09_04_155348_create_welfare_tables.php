<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('membership_no')->unique();
            $table->string('full_name');
            $table->string('name_with_initials');
            $table->string('nic')->unique();
            $table->date('date_of_birth');
            $table->string('gender');
            $table->string('civil_status')->default('SINGLE');
            $table->string('occupation')->nullable();
            $table->string('address_line1');
            $table->string('address_line2')->nullable();
            $table->string('city');
            $table->string('district');
            $table->string('phone');
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('photo_url')->nullable();
            $table->string('membership_type')->default('ORDINARY');
            $table->string('status')->default('ACTIVE');
            $table->timestamp('joined_at')->nullable();
            $table->string('emergency_name')->nullable();
            $table->string('emergency_phone')->nullable();
            $table->text('bio')->nullable();
            $table->boolean('show_in_directory')->default(true);
            $table->foreignId('user_id')->nullable()->unique()->constrained()->nullOnDelete();
            $table->timestamps();
            $table->index('status');
            $table->index('district');
            $table->index('membership_type');
        });

        Schema::create('committee_members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position_en');
            $table->string('position_si');
            $table->string('position_ta');
            $table->text('bio_en')->nullable();
            $table->text('bio_si')->nullable();
            $table->text('bio_ta')->nullable();
            $table->string('photo_url')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->unsignedSmallInteger('term_from');
            $table->unsignedSmallInteger('term_to')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_current')->default(true);
            $table->timestamps();
            $table->index(['is_current', 'sort_order']);
        });

        Schema::create('programmes', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('category');
            $table->string('title_en');
            $table->string('title_si');
            $table->string('title_ta');
            $table->text('summary_en');
            $table->text('summary_si');
            $table->text('summary_ta');
            $table->longText('body_en');
            $table->longText('body_si');
            $table->longText('body_ta');
            $table->string('icon')->default('heart');
            $table->string('cover_image')->nullable();
            $table->unsignedInteger('benefit_amount')->nullable();
            $table->text('eligibility_en')->nullable();
            $table->text('eligibility_si')->nullable();
            $table->text('eligibility_ta')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
            $table->index(['category', 'is_active']);
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title_en');
            $table->string('title_si');
            $table->string('title_ta');
            $table->text('summary_en');
            $table->text('summary_si');
            $table->text('summary_ta');
            $table->longText('body_en');
            $table->longText('body_si');
            $table->longText('body_ta');
            $table->string('location');
            $table->unsignedInteger('target_amount');
            $table->unsignedInteger('raised_amount')->default(0);
            $table->unsignedInteger('spent_amount')->default(0);
            $table->unsignedInteger('beneficiaries')->default(0);
            $table->string('status')->default('ONGOING');
            $table->timestamp('started_at');
            $table->timestamp('completed_at')->nullable();
            $table->string('cover_image')->nullable();
            $table->timestamps();
            $table->index('status');
        });

        Schema::create('news_posts', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('category')->default('NEWS');
            $table->string('title_en');
            $table->string('title_si');
            $table->string('title_ta');
            $table->text('excerpt_en');
            $table->text('excerpt_si');
            $table->text('excerpt_ta');
            $table->longText('body_en');
            $table->longText('body_si');
            $table->longText('body_ta');
            $table->string('cover_image')->nullable();
            $table->string('author')->default('Media Unit');
            $table->string('tags')->default('');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('views')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->index(['is_published', 'published_at']);
            $table->index('category');
        });

        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title_en');
            $table->string('title_si');
            $table->string('title_ta');
            $table->text('summary_en');
            $table->text('summary_si');
            $table->text('summary_ta');
            $table->longText('body_en');
            $table->longText('body_si');
            $table->longText('body_ta');
            $table->string('venue');
            $table->string('city');
            $table->timestamp('starts_at');
            $table->timestamp('ends_at')->nullable();
            $table->string('cover_image')->nullable();
            $table->unsignedInteger('capacity')->nullable();
            $table->boolean('registration_open')->default(true);
            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('attendee_count')->default(0);
            $table->timestamps();
            $table->index('starts_at');
        });

        Schema::create('event_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('member_id')->nullable()->constrained()->nullOnDelete();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->unsignedSmallInteger('guests')->default(0);
            $table->text('note')->nullable();
            $table->string('status')->default('CONFIRMED');
            $table->timestamps();
            $table->index('event_id');
        });

        Schema::create('gallery_albums', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('category')->default('EVENT');
            $table->string('title_en');
            $table->string('title_si');
            $table->string('title_ta');
            $table->text('caption_en')->nullable();
            $table->text('caption_si')->nullable();
            $table->text('caption_ta')->nullable();
            $table->string('cover_image');
            $table->timestamp('taken_at');
            $table->boolean('is_published')->default(true);
            $table->timestamps();
            $table->index(['category', 'taken_at']);
        });

        Schema::create('gallery_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gallery_album_id')->constrained()->cascadeOnDelete();
            $table->string('type')->default('PHOTO');
            $table->string('url');
            $table->string('thumbnail')->nullable();
            $table->string('caption_en')->nullable();
            $table->string('caption_si')->nullable();
            $table->string('caption_ta')->nullable();
            $table->unsignedInteger('width')->default(1600);
            $table->unsignedInteger('height')->default(1067);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->string('donor_name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->unsignedInteger('amount');
            $table->string('currency', 8)->default('LKR');
            $table->string('method')->default('BANK_TRANSFER');
            $table->string('purpose')->default('GENERAL');
            $table->text('message')->nullable();
            $table->boolean('is_anonymous')->default(false);
            $table->boolean('is_recurring')->default(false);
            $table->string('status')->default('PENDING');
            $table->foreignId('member_id')->nullable()->constrained()->nullOnDelete();
            $table->string('receipt_url')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();
            $table->index(['status', 'created_at']);
            $table->index('purpose');
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_no')->unique();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('amount');
            $table->string('type')->default('MEMBERSHIP_FEE');
            $table->unsignedSmallInteger('period_year');
            $table->unsignedTinyInteger('period_month')->nullable();
            $table->string('method')->default('BANK_TRANSFER');
            $table->string('status')->default('PAID');
            $table->timestamp('paid_at')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->index(['member_id', 'period_year']);
            $table->index('status');
        });

        Schema::create('annual_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('year')->unique();
            $table->string('title_en');
            $table->string('title_si');
            $table->string('title_ta');
            $table->text('summary_en');
            $table->text('summary_si');
            $table->text('summary_ta');
            $table->string('file_url');
            $table->unsignedInteger('file_size_kb')->default(0);
            $table->string('audited_by')->nullable();
            $table->unsignedInteger('total_income');
            $table->unsignedInteger('total_expenditure');
            $table->unsignedInteger('welfare_spend')->default(0);
            $table->unsignedInteger('project_spend')->default(0);
            $table->unsignedInteger('admin_spend')->default(0);
            $table->unsignedInteger('reserve_balance')->default(0);
            $table->unsignedInteger('members_at_year_end')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('fund_allocations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title_en');
            $table->string('title_si');
            $table->string('title_ta');
            $table->text('description_en');
            $table->text('description_si');
            $table->text('description_ta');
            $table->unsignedInteger('amount');
            $table->string('category');
            $table->timestamp('spent_at');
            $table->string('proof_url')->nullable();
            $table->timestamps();
            $table->index('spent_at');
            $table->index('category');
        });

        Schema::create('monthly_stats', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('year');
            $table->unsignedTinyInteger('month');
            $table->unsignedInteger('donation_total')->default(0);
            $table->unsignedInteger('donation_count')->default(0);
            $table->unsignedInteger('new_members')->default(0);
            $table->unsignedInteger('welfare_paid')->default(0);
            $table->unsignedInteger('claims_count')->default(0);
            $table->unsignedInteger('events_held')->default(0);
            $table->unsignedInteger('volunteers')->default(0);
            $table->timestamps();
            $table->unique(['year', 'month']);
        });

        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('logo_url');
            $table->string('website')->nullable();
            $table->string('tier')->default('PARTNER');
            $table->text('description_en')->nullable();
            $table->text('description_si')->nullable();
            $table->text('description_ta')->nullable();
            $table->unsignedSmallInteger('since')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->index(['tier', 'sort_order']);
        });

        Schema::create('benefit_claims', function (Blueprint $table) {
            $table->id();
            $table->string('claim_no')->unique();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('programme_id')->constrained()->restrictOnDelete();
            $table->unsignedInteger('amount');
            $table->text('reason');
            $table->string('status')->default('SUBMITTED');
            $table->string('document_url')->nullable();
            $table->text('review_note')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('decided_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            $table->index(['member_id', 'status']);
        });

        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_no')->unique();
            $table->foreignId('member_id')->nullable()->constrained()->nullOnDelete();
            $table->string('contact_name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('category');
            $table->string('subject');
            $table->text('description');
            $table->string('priority')->default('MEDIUM');
            $table->string('status')->default('OPEN');
            $table->string('assigned_to')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
            $table->index(['status', 'priority']);
        });

        Schema::create('ticket_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('support_ticket_id')->constrained()->cascadeOnDelete();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('author_name');
            $table->string('author_role')->default('MEMBER');
            $table->text('body');
            $table->boolean('is_internal')->default(false);
            $table->timestamps();
        });

        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('category');
            $table->string('title_en');
            $table->string('title_si');
            $table->string('title_ta');
            $table->text('description_en');
            $table->text('description_si');
            $table->text('description_ta');
            $table->string('file_url');
            $table->string('file_type')->default('PDF');
            $table->unsignedInteger('file_size_kb')->default(0);
            $table->string('version')->default('1.0');
            $table->boolean('members_only')->default(false);
            $table->unsignedInteger('download_count')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->index(['category', 'is_published']);
        });

        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title_en');
            $table->string('title_si');
            $table->string('title_ta');
            $table->text('body_en');
            $table->text('body_si');
            $table->text('body_ta');
            $table->string('audience')->default('ALL');
            $table->string('priority')->default('NORMAL');
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_published')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            $table->index(['audience', 'published_at']);
        });

        Schema::create('membership_applications', function (Blueprint $table) {
            $table->id();
            $table->string('application_no')->unique();
            $table->string('full_name');
            $table->string('nic');
            $table->date('date_of_birth');
            $table->string('gender');
            $table->string('occupation')->nullable();
            $table->string('address_line1');
            $table->string('city');
            $table->string('district');
            $table->string('phone');
            $table->string('email');
            $table->string('membership_type')->default('ORDINARY');
            $table->string('referred_by')->nullable();
            $table->text('motivation')->nullable();
            $table->string('status')->default('PENDING');
            $table->text('review_note')->nullable();
            $table->timestamp('decided_at')->nullable();
            $table->timestamps();
            $table->index(['status', 'created_at']);
        });

        Schema::create('volunteer_applications', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->string('nic')->nullable();
            $table->string('city');
            $table->string('district');
            $table->date('date_of_birth')->nullable();
            $table->string('interests');
            $table->text('skills')->nullable();
            $table->string('availability');
            $table->unsignedSmallInteger('hours_per_month')->default(8);
            $table->text('experience')->nullable();
            $table->text('motivation')->nullable();
            $table->string('status')->default('NEW');
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
            $table->index(['status', 'created_at']);
        });

        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('subject');
            $table->text('message');
            $table->string('topic')->default('GENERAL');
            $table->string('status')->default('NEW');
            $table->timestamps();
            $table->index(['status', 'created_at']);
        });

        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('category')->default('MEMBERSHIP');
            $table->string('question_en');
            $table->string('question_si');
            $table->string('question_ta');
            $table->text('answer_en');
            $table->text('answer_si');
            $table->text('answer_ta');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
            $table->index(['category', 'sort_order']);
        });

        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value_en');
            $table->text('value_si');
            $table->text('value_ta');
            $table->string('group')->default('general');
            $table->timestamps();
        });

        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('locale', 8)->default('en');
            $table->boolean('is_confirmed')->default(false);
            $table->timestamp('unsubscribed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('elections', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title_en');
            $table->string('title_si');
            $table->string('title_ta');
            $table->text('description_en')->nullable();
            $table->text('description_si')->nullable();
            $table->text('description_ta')->nullable();
            $table->string('status')->default('DRAFT');
            $table->timestamp('opens_at')->nullable();
            $table->timestamp('closes_at')->nullable();
            $table->timestamps();
            $table->index(['status', 'opens_at']);
        });

        Schema::create('election_candidates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('election_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('position_en');
            $table->string('position_si');
            $table->string('position_ta');
            $table->text('bio')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('election_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('election_id')->constrained()->cascadeOnDelete();
            $table->foreignId('election_candidate_id')->constrained()->cascadeOnDelete();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['election_id', 'member_id']);
        });

        Schema::create('suggestions', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->foreignId('member_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('is_anonymous')->default(false);
            $table->string('category')->default('SUGGESTION');
            $table->string('subject');
            $table->text('body');
            $table->string('status')->default('NEW');
            $table->text('admin_note')->nullable();
            $table->timestamps();
            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suggestions');
        Schema::dropIfExists('election_votes');
        Schema::dropIfExists('election_candidates');
        Schema::dropIfExists('elections');
        Schema::dropIfExists('subscribers');
        Schema::dropIfExists('site_settings');
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('volunteer_applications');
        Schema::dropIfExists('membership_applications');
        Schema::dropIfExists('announcements');
        Schema::dropIfExists('documents');
        Schema::dropIfExists('ticket_messages');
        Schema::dropIfExists('support_tickets');
        Schema::dropIfExists('benefit_claims');
        Schema::dropIfExists('partners');
        Schema::dropIfExists('monthly_stats');
        Schema::dropIfExists('fund_allocations');
        Schema::dropIfExists('annual_reports');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('donations');
        Schema::dropIfExists('gallery_items');
        Schema::dropIfExists('gallery_albums');
        Schema::dropIfExists('event_registrations');
        Schema::dropIfExists('events');
        Schema::dropIfExists('news_posts');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('programmes');
        Schema::dropIfExists('committee_members');
        Schema::dropIfExists('members');
    }
};
