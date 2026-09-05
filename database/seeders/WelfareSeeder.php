<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Announcement;
use App\Models\AnnualReport;
use App\Models\BenefitClaim;
use App\Models\CommitteeMember;
use App\Models\ContactMessage;
use App\Models\Document;
use App\Models\Donation;
use App\Models\Election;
use App\Models\Event;
use App\Models\Faq;
use App\Models\FundAllocation;
use App\Models\GalleryAlbum;
use App\Models\Member;
use App\Models\MembershipApplication;
use App\Models\MonthlyStat;
use App\Models\NewsPost;
use App\Models\Partner;
use App\Models\Payment;
use App\Models\Programme;
use App\Models\Project;
use App\Models\SiteSetting;
use App\Models\Subscriber;
use App\Models\Suggestion;
use App\Models\SupportTicket;
use App\Models\TicketMessage;
use App\Models\User;
use App\Models\VolunteerApplication;
use App\Support\AboutContent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class WelfareSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::query()->create([
            'name' => 'Nirmala Jayasuriya',
            'email' => 'admin@heartlinkallianz.lk',
            'password' => 'Admin@hla2026',
            'role' => UserRole::Admin,
            'locale' => 'en',
            'is_active' => true,
        ]);

        $memberUser = User::query()->create([
            'name' => 'Kamal Perera',
            'email' => 'member@heartlinkallianz.lk',
            'password' => 'Member@hla2026',
            'role' => UserRole::Member,
            'locale' => 'si',
            'is_active' => true,
        ]);

        $demoMember = Member::query()->create([
            'membership_no' => 'HLA-1001',
            'full_name' => 'Kamal Perera',
            'name_with_initials' => 'K. Perera',
            'nic' => '198512345678',
            'date_of_birth' => '1985-03-12',
            'gender' => 'MALE',
            'civil_status' => 'MARRIED',
            'occupation' => 'Teacher',
            'address_line1' => '42 Mahulpotha',
            'city' => 'Bandarawela',
            'district' => 'Badulla',
            'phone' => '0771234501',
            'whatsapp' => '0771234501',
            'email' => 'member@heartlinkallianz.lk',
            'blood_group' => 'O+',
            'membership_type' => 'ORDINARY',
            'status' => 'ACTIVE',
            'joined_at' => now()->subMonths(8),
            'emergency_name' => 'Sandya Perera',
            'emergency_phone' => '0771234599',
            'bio' => 'Member since 2018. Volunteers at medical camps in the Bandarawela area.',
            'photo_url' => '/media/officers/member.svg',
            'show_in_directory' => true,
            'user_id' => $memberUser->id,
        ]);

        $this->committee();
        $this->aboutSettings();
        $this->programmes();
        $this->call(CommunityWorkSeeder::class);
        $this->partners();
        $this->faqs();
        $this->documents();
        $this->reports();
        $extraMembers = $this->members($demoMember);
        $this->payments($demoMember, $extraMembers);
        $this->donations($demoMember, $extraMembers);
        $this->stats();
        $this->claims($demoMember);
        $this->news();
        $this->events();
        $this->gallery();
        $this->allocations(Project::query()->where('slug', 'relief-aid-bandarawela-2025')->first());
        $this->tickets($demoMember, $memberUser, $admin);
        $this->announcements();
        $this->applications();
        $this->election();
        $this->misc($demoMember);

        SiteSetting::query()->create([
            'key' => 'monthly_fee',
            'value_en' => '300',
            'value_si' => '300',
            'value_ta' => '300',
            'group' => 'fees',
        ]);
        SiteSetting::query()->create([
            'key' => 'registration_fee',
            'value_en' => '1000',
            'value_si' => '1000',
            'value_ta' => '1000',
            'group' => 'fees',
        ]);
    }

    /**
     * @return array<string, string>
     */
    private function t(string $field, string $en, string $si, string $ta): array
    {
        return [
            $field.'_en' => $en,
            $field.'_si' => $si,
            $field.'_ta' => $ta,
        ];
    }

    private function committee(): void
    {
        $rows = [
            [
                'H.M.C.P.K. Herath',
                'Hon. President',
                'ගරු සභාපති',
                'கௌரவத் தலைவர்',
                'No. 272, Kirimadugoda, Bandarawela.',
                'නො. 272, කිරිමඩුගොඩ, බණ්ඩාරවෙල.',
                'இல. 272, கிரிமடுகொட, பண்டாரவளை.',
                '076 818 5377',
                'EXECUTIVE',
                '/media/officers/president.svg',
            ],
            [
                'A.M. Ajith Rupasinghe',
                'Hon. Secretary',
                'ගරු ලේකම්',
                'கௌரவச் செயலாளர்',
                '72/3, North Kovilwela, Bandarawela.',
                '72/3, උතුරු කෝවිල්වෙල, බණ්ඩාරවෙල.',
                '72/3, வடக்கு கோவில்வெல, பண்டாரவளை.',
                '070 337 9955',
                'EXECUTIVE',
                '/media/officers/secretary.svg',
            ],
            [
                'M.S. Jayantha',
                'Hon. Treasurer',
                'ගරු භාණ්ඩාගාරික',
                'கௌரவப் பொருளாளர்',
                'No. 27, Galapitagedara, Bulathwela.',
                'නො. 27, ගලපිටගෙදර, බුලත්වෙල.',
                'இல. 27, கலபிட்டகெதர, புலத்வெல.',
                '077 296 5300',
                'EXECUTIVE',
                '/media/officers/treasurer.svg',
            ],
            [
                'I.P.P. Ratnayake',
                'Patron (Divisional Secretary, Bandarawela)',
                'අනුශාසක (ප්‍රාදේශීය ලේකම්, බණ්ඩාරවෙල)',
                'ஆதரவாளர் (பிரிவுச் செயலாளர், பண்டாரவளை)',
                'Divisional Secretariat, Bandarawela.',
                'ප්‍රාදේශීය ලේකම් කාර්යාලය, බණ්ඩාරවෙල.',
                'பிரிவுச் செயலகம், பண்டாரவளை.',
                '071 443 5277',
                'ADVISORY',
                '/media/officers/patron.svg',
            ],
        ];

        foreach ($rows as $i => $row) {
            CommitteeMember::query()->create([
                'name' => $row[0],
                ...$this->t('position', $row[1], $row[2], $row[3]),
                ...$this->t('bio', $row[4], $row[5], $row[6]),
                'phone' => $row[7],
                'board' => $row[8],
                'photo_url' => $row[9],
                'term_from' => 2024,
                'term_to' => 2026,
                'sort_order' => $i,
                'is_current' => true,
            ]);
        }
    }

    private function aboutSettings(): void
    {
        foreach ([
            'about_vision' => AboutContent::vision(),
            'about_mission' => AboutContent::mission(),
            'about_intro' => AboutContent::intro(),
            'about_objectives' => AboutContent::objectivesText(),
        ] as $key => $values) {
            SiteSetting::query()->updateOrCreate(
                ['key' => $key],
                [
                    'value_en' => $values['en'],
                    'value_si' => $values['si'],
                    'value_ta' => $values['ta'],
                    'group' => 'about',
                ],
            );
        }
    }

    private function programmes(): void
    {
        $items = [
            ['death-donation-scheme', 'WELFARE', 'HeartHandshake', '/media/dry-rations.svg', 150000, 'Death Donation Scheme', 'මරණ ආධාර යෝජනා ක්‍රමය', 'மரண நிவாரண திட்டம்', 'An immediate cash grant to the family of a deceased member, paid within 48 hours.'],
            ['medical-assistance-fund', 'WELFARE', 'Stethoscope', '/media/eye-clinic.svg', 75000, 'Medical Assistance Fund', 'වෛද්‍ය ආධාර අරමුදල', 'மருத்துவ உதவி நிதியம்', 'Support towards surgery, hospitalisation, dialysis and long-term medication.'],
            ['scholarship-programme', 'WELFARE', 'GraduationCap', '/media/scholarship-award.svg', 60000, 'Scholarship Programme', 'ශිෂ්‍යත්ව වැඩසටහන', 'கல்வி உதவித்தொகைத் திட்டம்', 'Pahana awards for children of members in good standing.'],
            ['disaster-relief', 'EMERGENCY', 'Heart', '/media/flood-relief.svg', null, 'Disaster Relief', 'ආපදා සහන', 'பேரிடர் நிவாரணம்', 'Rapid rations, shelter and rebuilding after floods and other disasters.'],
            ['emergency-hospital-transport', 'EMERGENCY', 'Heart', '/media/medical-camp.svg', null, 'Emergency Hospital Transport', 'හදිසි රෝහල් ප්‍රවාහනය', 'அவசர வைத்தியசாலை போக்குவரத்து', 'Ambulance and travel support from day one of membership.'],
        ];

        foreach ($items as $i => $item) {
            Programme::query()->create([
                'slug' => $item[0],
                'category' => $item[1],
                'icon' => $item[2],
                'cover_image' => $item[3],
                'benefit_amount' => $item[4],
                'sort_order' => $i + 1,
                ...$this->t('title', $item[5], $item[6], $item[7]),
                ...$this->t('summary', $item[8], $item[8], $item[8]),
                ...$this->t('body', '<p>'.$item[8].'</p>', '<p>'.$item[8].'</p>', '<p>'.$item[8].'</p>'),
                ...$this->t('eligibility', 'Members in good standing.', 'යාවත්කාලීන සාමාජිකයින්.', 'நிலுவையற்ற உறுப்பினர்கள்.'),
            ]);
        }
    }

    private function partners(): void
    {
        $items = [
            ['Ceylon Trust Bank', 'ceylon-trust-bank', '/partners/ceylon-trust-bank.svg', 'PLATINUM', 2019],
            ['Lanka Medicare', 'lanka-medicare', '/partners/lanka-medicare.svg', 'PLATINUM', 2020],
            ['Sunrise Pharma', 'sunrise-pharma', '/partners/sunrise-pharma.svg', 'GOLD', 2021],
            ['Metro Insurance', 'metro-insurance', '/partners/metro-insurance.svg', 'GOLD', 2018],
            ['Divisional Secretariat Bandarawela', 'divisional-secretariat', '/partners/divisional-secretariat.svg', 'GOVERNMENT', 2016],
        ];

        foreach ($items as $i => $item) {
            Partner::query()->create([
                'name' => $item[0],
                'slug' => $item[1],
                'logo_url' => $item[2],
                'website' => 'https://example.com',
                'tier' => $item[3],
                'since' => $item[4],
                'sort_order' => $i,
                ...$this->t('description', $item[0].' supports Heart Link Allianze programmes.', $item[0].' හදවතේ යාළුවෝ වැඩසටහන්වලට සහාය දෙයි.', $item[0].' ஹார்ட் லிங்க் அலையன்சே திட்டங்களுக்கு ஆதரவளிக்கிறது.'),
            ]);
        }
    }

    private function faqs(): void
    {
        $items = [
            ['MEMBERSHIP', 'Who can join the association?', 'සමිතියට එක්විය හැක්කේ කාටද?', 'சங்கத்தில் யார் இணையலாம்?', 'Any Sri Lankan aged 18 or over, or a junior member aged 12–17 with a parent or guardian.'],
            ['MEMBERSHIP', 'What are the membership fees?', 'සාමාජික ගාස්තු කීයද?', 'உறுப்பினர் கட்டணம் என்ன?', 'A one-time registration fee of Rs. 1,000, then Rs. 300 a month.'],
            ['DONATIONS', 'Can I donate without becoming a member?', 'සාමාජිකයෙකු නොවී පරිත්‍යාග කළ හැකිද?', 'உறுப்பினராகாமல் நன்கொடை அளிக்கலாமா?', 'Yes. Use the Donate Now form, make a bank transfer, or leave cash at the office against a receipt.'],
            ['WELFARE', 'How do I make a welfare claim?', 'සුබසාධක ඉල්ලීමක් කරන්නේ කෙසේද?', 'நலன் கோரிக்கையை எப்படிச் செய்வது?', 'Log in to the member dashboard and open a welfare claim, or download the claim form from the Document Center.'],
            ['GENERAL', 'Where is the office and when is it open?', 'කාර්යාලය කොහේද, විවෘත වන්නේ කවදාද?', 'அலுவலகம் எங்கே, எப்போது திறந்திருக்கும்?', 'No. 118, Bogahapelessa, Mahulpotha, Bandarawela. Monday to Friday 9.00 a.m. to 4.30 p.m., Saturday until noon.'],
        ];

        foreach ($items as $i => $item) {
            Faq::query()->create([
                'category' => $item[0],
                'sort_order' => $i,
                ...$this->t('question', $item[1], $item[2], $item[3]),
                ...$this->t('answer', $item[4], $item[4], $item[4]),
            ]);
        }
    }

    private function documents(): void
    {
        $items = [
            ['membership-application', 'APPLICATION_FORM', '/documents/membership-application-form.pdf', false, 'Membership application form', 'සාමාජික අයදුම්පත', 'உறுப்பினர் விண்ணப்பப் படிவம்'],
            ['constitution', 'CONSTITUTION', '/documents/constitution.pdf', false, 'Constitution of the Association', 'සමිතියේ ව්‍යවස්ථාව', 'சங்கத்தின் அரசியலமைப்பு'],
            ['welfare-claim-form', 'APPLICATION_FORM', '/documents/welfare-claim-form.pdf', false, 'Welfare claim form (HLA/W-04)', 'සුබසාධක ඉල්ලීම් පෝරමය', 'நலன் கோரிக்கைப் படிவம்'],
            ['circular-subscriptions', 'CIRCULAR', '/documents/circular-2026-01-subscriptions.pdf', true, 'Circular 2026/01 — Subscriptions', 'චක්‍රලේඛය 2026/01', 'சுற்றறிக்கை 2026/01'],
        ];

        foreach ($items as $item) {
            Document::query()->create([
                'slug' => $item[0],
                'category' => $item[1],
                'file_url' => $item[2],
                'file_type' => 'PDF',
                'file_size_kb' => 240,
                'version' => '2026.1',
                'members_only' => $item[3],
                'is_published' => true,
                'published_at' => now()->subDays(10),
                ...$this->t('title', $item[4], $item[5], $item[6]),
                ...$this->t('description', 'Downloadable association document.', 'බාගත කළ හැකි ලේඛනය.', 'பதிவிறக்க ஆவணம்.'),
            ]);
        }
    }

    private function reports(): void
    {
        foreach ([
            [2024, 18640000, 16820000, 10540000, 4620000, 1660000, 6570000, 1640],
            [2025, 22410000, 20180000, 12860000, 5910000, 1410000, 8800000, 1840],
        ] as $row) {
            AnnualReport::query()->create([
                'year' => $row[0],
                ...$this->t('title', 'Annual Report '.$row[0], 'වාර්ෂික වාර්තාව '.$row[0], 'வருடாந்த அறிக்கை '.$row[0]),
                ...$this->t('summary', 'Audited accounts for the year ended 31 December '.$row[0].'.', $row[0].' විගණිත ගිණුම්.', $row[0].' தணிக்கை கணக்குகள்.'),
                'file_url' => '/documents/annual-report-'.$row[0].'.pdf',
                'file_size_kb' => 5000,
                'audited_by' => 'Fernando, Perera & Co. Chartered Accountants',
                'total_income' => $row[1],
                'total_expenditure' => $row[2],
                'welfare_spend' => $row[3],
                'project_spend' => $row[4],
                'admin_spend' => $row[5],
                'reserve_balance' => $row[6],
                'members_at_year_end' => $row[7],
                'is_published' => true,
                'published_at' => Carbon::create($row[0] + 1, 3, 1),
            ]);
        }
    }

    /**
     * @return list<Member>
     */
    private function members(Member $demo): array
    {
        $names = [
            ['Sanduni Fernando', 'Badulla', 'Bandarawela'],
            ['Arun Thillainathan', 'Jaffna', 'Nallur'],
            ['Fathima Rizwan', 'Colombo', 'Dehiwala'],
            ['Gayan Wijesuriya', 'Galle', 'Galle'],
            ['Kavitha Nadarajah', 'Batticaloa', 'Batticaloa'],
            ['Iresha Madushani', 'Colombo', 'Maharagama'],
            ['Nimal Perera', 'Kandy', 'Kandy'],
            ['Shanthi Fernando', 'Gampaha', 'Negombo'],
        ];

        $created = [$demo];

        foreach ($names as $i => $row) {
            $created[] = Member::query()->create([
                'membership_no' => 'HLA-'.str_pad((string) (1002 + $i), 4, '0', STR_PAD_LEFT),
                'full_name' => $row[0],
                'name_with_initials' => $row[0],
                'nic' => '198'.str_pad((string) (200000000 + $i * 17), 9, '0', STR_PAD_LEFT),
                'date_of_birth' => '1980-06-01',
                'gender' => $i % 2 === 0 ? 'FEMALE' : 'MALE',
                'occupation' => 'Professional',
                'address_line1' => (20 + $i).' Mahulpotha Road',
                'city' => $row[2],
                'district' => $row[1],
                'phone' => '077'.str_pad((string) (1234502 + $i), 7, '0', STR_PAD_LEFT),
                'email' => 'member'.$i.'@example.lk',
                'membership_type' => $i === 3 ? 'JUNIOR' : 'ORDINARY',
                'status' => 'ACTIVE',
                'joined_at' => now()->subMonths(10 - $i),
                'show_in_directory' => $i !== 4,
            ]);
        }

        return $created;
    }

    /**
     * @param  list<Member>  $members
     */
    private function payments(Member $demo, array $members): void
    {
        $cursor = now()->subMonths(6)->startOfMonth();
        $end = now()->subMonths(2)->startOfMonth();
        $i = 0;

        while ($cursor->lte($end)) {
            Payment::query()->create([
                'receipt_no' => 'HLA-P-'.str_pad((string) (200 + $i), 4, '0', STR_PAD_LEFT),
                'member_id' => $demo->id,
                'amount' => 300,
                'type' => 'MEMBERSHIP_FEE',
                'period_year' => $cursor->year,
                'period_month' => $cursor->month,
                'method' => 'BANK_TRANSFER',
                'status' => 'PAID',
                'paid_at' => $cursor->copy()->addDays(5),
            ]);
            $cursor->addMonth();
            $i++;
        }

        Payment::query()->create([
            'receipt_no' => 'HLA-P-PEND01',
            'member_id' => $members[1]->id,
            'amount' => 300,
            'type' => 'MEMBERSHIP_FEE',
            'period_year' => now()->year,
            'period_month' => now()->month,
            'method' => 'BANK_TRANSFER',
            'status' => 'PENDING',
        ]);
    }

    /**
     * @param  list<Member>  $members
     */
    private function donations(Member $demo, array $members): void
    {
        $purposes = ['GENERAL', 'EMERGENCY', 'EDUCATION', 'MEDICAL', 'PROJECT'];
        $projectIds = Project::query()->pluck('id');

        for ($i = 0; $i < 12; $i++) {
            $confirmed = $i % 4 !== 0;
            $purpose = $purposes[$i % 5];
            Donation::query()->create([
                'reference' => 'HLA-D-'.str_pad((string) (1000 + $i), 4, '0', STR_PAD_LEFT),
                'donor_name' => $members[$i % count($members)]->full_name,
                'email' => 'donor'.$i.'@example.lk',
                'amount' => [2500, 5000, 10000, 25000][$i % 4],
                'method' => 'BANK_TRANSFER',
                'purpose' => $purpose,
                'project_id' => $purpose === 'PROJECT' && $projectIds->isNotEmpty()
                    ? $projectIds[$i % $projectIds->count()]
                    : null,
                'status' => $confirmed ? 'CONFIRMED' : 'PENDING',
                'confirmed_at' => $confirmed ? now()->subDays(3 + $i) : null,
                'member_id' => $i % 3 === 0 ? $demo->id : null,
                'is_anonymous' => $i === 2,
            ]);
        }
    }

    private function stats(): void
    {
        for ($i = 0; $i < 12; $i++) {
            $date = now()->subMonths(11 - $i)->startOfMonth();
            MonthlyStat::query()->create([
                'year' => $date->year,
                'month' => $date->month,
                'donation_total' => 980000 + ($i * 42000),
                'donation_count' => 38 + ($i * 2),
                'new_members' => 8 + ($i % 7),
                'welfare_paid' => 620000 + ($i * 28000),
                'claims_count' => 12 + ($i % 9),
                'events_held' => 1 + ($i % 3),
                'volunteers' => 18 + ($i % 12),
            ]);
        }
    }

    private function claims(Member $demo): void
    {
        $medical = Programme::query()->where('slug', 'medical-assistance-fund')->first();

        if ($medical === null) {
            return;
        }

        BenefitClaim::query()->create([
            'claim_no' => 'HLA-C-014',
            'member_id' => $demo->id,
            'programme_id' => $medical->id,
            'amount' => 45000,
            'reason' => 'Dialysis support for January–March.',
            'status' => 'PAID',
            'submitted_at' => now()->subDays(80),
            'decided_at' => now()->subDays(70),
            'paid_at' => now()->subDays(65),
        ]);
        BenefitClaim::query()->create([
            'claim_no' => 'HLA-C-041',
            'member_id' => $demo->id,
            'programme_id' => $medical->id,
            'amount' => 18000,
            'reason' => 'Chronic medication reimbursement.',
            'status' => 'UNDER_REVIEW',
            'submitted_at' => now()->subDays(9),
        ]);
    }

    private function news(): void
    {
        $items = [
            ['may-flood-response-2025', 'ACTIVITY_REPORT', '/media/flood-relief.svg', 110, true, 'How we responded to the May 2025 floods', '2025 මැයි ගංවතුරට අප ප්‍රතිචාර දැක්වූ ආකාරය', '2025 மே வெள்ளத்திற்கு நாம் பதிலளித்த விதம்'],
            ['scholarship-awards-2026', 'NEWS', '/media/scholarship-award.svg', 28, true, '96 Pahana scholarships awarded for 2026', '2026 සඳහා පහන ශිෂ්‍යත්ව 96ක්', '2026க்கு 96 பஹன உதவித்தொகைகள்'],
            ['agm-notice-2026', 'NEWS', '/media/general-meeting.svg', 12, false, 'Notice of the 2026 Annual General Meeting', '2026 වාර්ෂික මහා සභා රැස්වීමේ දැනුම්දීම', '2026 வருடாந்த பொதுக் கூட்ட அறிவிப்பு'],
            ['blood-donation-drive', 'NEWS', '/media/blood-donation.svg', 6, true, 'Blood donation drive collects 112 units', 'රුධිර පරිත්‍යාග කඳවුරින් ඒකක 112ක්', 'இரத்த தான முகாமில் 112 அலகுகள்'],
        ];

        foreach ($items as $item) {
            NewsPost::query()->create([
                'slug' => $item[0],
                'category' => $item[1],
                'cover_image' => $item[2],
                'is_featured' => $item[4],
                'is_published' => true,
                'published_at' => now()->subDays($item[3]),
                'tags' => 'welfare,community',
                'author' => 'Media Unit',
                ...$this->t('title', $item[5], $item[6], $item[7]),
                ...$this->t('excerpt', $item[5].'.', $item[6].'.', $item[7].'.'),
                ...$this->t('body', '<p>'.$item[5].'</p>', '<p>'.$item[6].'</p>', '<p>'.$item[7].'</p>'),
            ]);
        }
    }

    private function events(): void
    {
        $items = [
            ['mobile-medical-camp-kandy', 18, 'Peradeniya Maha Vidyalaya grounds', 'Kandy', '/media/medical-camp.svg', 'Mobile medical camp — Kandy', 'ජංගම වෛද්‍ය කඳවුර — මහනුවර', 'அலைமருத்துவ முகாம் — கண்டி'],
            ['agm-2026', 25, 'HLA Association Hall', 'Bandarawela', '/media/general-meeting.svg', 'Annual General Meeting 2026', 'වාර්ෂික මහා සභාව 2026', 'வருடாந்த பொதுக் கூட்டம் 2026'],
            ['volunteer-orientation-sep', 9, 'HLA Association Hall', 'Bandarawela', '/media/volunteer-training.svg', 'Volunteer orientation', 'ස්වේච්ඡා දිශානතිය', 'தொண்டர் அறிமுகம்'],
            ['elders-day-2026', -40, 'HLA Association Hall', 'Bandarawela', '/media/elders-day.svg', "Elders' Day celebration", 'වැඩිහිටි දින උත්සවය', 'முதியோர் நாள் விழா'],
        ];

        foreach ($items as $item) {
            $start = $item[1] >= 0 ? now()->addDays($item[1])->setTime(9, 0) : now()->subDays(abs($item[1]))->setTime(9, 0);
            $event = Event::query()->create([
                'slug' => $item[0],
                'venue' => $item[2],
                'city' => $item[3],
                'starts_at' => $start,
                'ends_at' => $start->copy()->addHours(5),
                'cover_image' => $item[4],
                'capacity' => 250,
                'registration_open' => $item[1] >= 0,
                'is_published' => true,
                'attendee_count' => $item[1] >= 0 ? 40 : 180,
                ...$this->t('title', $item[5], $item[6], $item[7]),
                ...$this->t('summary', $item[5], $item[6], $item[7]),
                ...$this->t('body', '<p>'.$item[5].'</p>', '<p>'.$item[6].'</p>', '<p>'.$item[7].'</p>'),
            ]);

            if (is_string($event->cover_image) && $event->cover_image !== '') {
                $event->photos()->create([
                    'path' => $event->cover_image,
                    'sort_order' => 0,
                ]);
            }

            if ($item[0] === 'mobile-medical-camp-kandy') {
                foreach (['/media/eye-clinic.svg', '/media/health-awareness.svg', '/media/food-distribution.svg', '/media/blood-donation.svg'] as $index => $path) {
                    $event->photos()->create([
                        'path' => $path,
                        'sort_order' => $index + 1,
                    ]);
                }
            }
        }
    }

    private function gallery(): void
    {
        $albums = [
            ['flood-relief-2025', 'COMMUNITY', '/media/flood-relief.svg', 'Flood relief, May 2025', 'ගංවතුර සහනය', 'வெள்ள நிவாரணம்'],
            ['medical-camp-gallery', 'EVENT', '/media/medical-camp.svg', 'Medical camps', 'වෛද්‍ය කඳවුරු', 'மருத்துவ முகாம்கள்'],
            ['scholarship-day', 'HIGHLIGHT', '/media/scholarship-award.svg', 'Scholarship awards', 'ශිෂ්‍යත්ව ප්‍රදාන', 'உதவித்தொகை விழா'],
        ];
        $media = ['/media/flood-relief.svg', '/media/medical-camp.svg', '/media/food-distribution.svg', '/media/scholarship-award.svg'];

        foreach ($albums as $i => $album) {
            $record = GalleryAlbum::query()->create([
                'slug' => $album[0],
                'category' => $album[1],
                'cover_image' => $album[2],
                'taken_at' => now()->subDays(30 + ($i * 40)),
                'is_published' => true,
                ...$this->t('title', $album[3], $album[4], $album[5]),
                ...$this->t('caption', 'Photographs from the field.', 'ක්ෂේත්‍ර ඡායාරූප.', 'களப் படங்கள்.'),
            ]);

            foreach ($media as $j => $url) {
                $record->items()->create([
                    'type' => 'PHOTO',
                    'url' => $url,
                    'thumbnail' => $url,
                    'sort_order' => $j,
                    ...$this->t('caption', 'Field photograph', 'ක්ෂේත්‍ර ඡායාරූපය', 'களப் படம்'),
                ]);
            }
        }
    }

    private function allocations(?Project $project): void
    {
        FundAllocation::query()->create([
            'project_id' => $project?->id,
            'amount' => 840000,
            'category' => 'INFRASTRUCTURE',
            'spent_at' => now()->subDays(60),
            ...$this->t('title', 'Relief packs — Bandarawela handover', 'සහන ඇසුරුම්', 'நிவாரணப் பொதிகள்'),
            ...$this->t('description', 'Paid to the supplier against delivery notes.', 'සැපයුම්කරුට ගෙවන ලදී.', 'வழங்குநருக்குச் செலுத்தப்பட்டது.'),
        ]);
        FundAllocation::query()->create([
            'amount' => 150000,
            'category' => 'WELFARE',
            'spent_at' => now()->subDays(37),
            ...$this->t('title', 'Death donation — HLA-1184', 'මරණ ආධාරය', 'மரண நிவாரணம்'),
            ...$this->t('description', 'Paid to the nominated next of kin.', 'ඥාතියාට ගෙවන ලදී.', 'உறவினருக்குச் செலுத்தப்பட்டது.'),
        ]);
    }

    private function tickets(Member $demo, User $memberUser, User $admin): void
    {
        $ticket = SupportTicket::query()->create([
            'ticket_no' => 'HLA-T-018',
            'member_id' => $demo->id,
            'contact_name' => $demo->full_name,
            'email' => $demo->email,
            'phone' => $demo->phone,
            'category' => 'WELFARE_CLAIM',
            'subject' => 'When will my medication claim be reviewed?',
            'description' => 'I submitted claim HLA-C-041 nine days ago.',
            'priority' => 'MEDIUM',
            'status' => 'IN_PROGRESS',
            'assigned_to' => $admin->name,
        ]);

        TicketMessage::query()->create([
            'support_ticket_id' => $ticket->id,
            'author_id' => $memberUser->id,
            'author_name' => $demo->full_name,
            'author_role' => 'MEMBER',
            'body' => 'I submitted claim HLA-C-041 nine days ago. Could you confirm it is in the next welfare meeting?',
        ]);
        TicketMessage::query()->create([
            'support_ticket_id' => $ticket->id,
            'author_id' => $admin->id,
            'author_name' => $admin->name,
            'author_role' => 'ADMIN',
            'body' => 'Confirmed — it is on the agenda for Thursday.',
        ]);
    }

    private function announcements(): void
    {
        Announcement::query()->create([
            'audience' => 'MEMBERS',
            'priority' => 'IMPORTANT',
            'is_pinned' => true,
            'is_published' => true,
            'published_at' => now()->subDay(),
            ...$this->t('title', 'AGM on 26 September', 'මහා සභාව සැප්තැම්බර් 26', 'பொதுக் கூட்டம் செப்டம்பர் 26'),
            ...$this->t('body', 'Please collect your membership card from the office. Only paid-up members may vote.', 'සාමාජික කාඩ්පත ලබා ගන්න.', 'உறுப்பினர் அட்டையைப் பெறுங்கள்.'),
        ]);
        Announcement::query()->create([
            'audience' => 'ALL',
            'priority' => 'NORMAL',
            'is_published' => true,
            'published_at' => now()->subDays(3),
            ...$this->t('title', 'Volunteer orientation next week', 'ඊළඟ සතියේ ස්වේච්ඡා දිශානතිය', 'அடுத்த வாரம் தொண்டர் அறிமுகம்'),
            ...$this->t('body', 'New volunteers: please register online.', 'නව ස්වේච්ඡා සේවකයින් ලියාපදිංචි වන්න.', 'புதிய தொண்டர்கள் பதிவு செய்யுங்கள்.'),
        ]);
    }

    private function applications(): void
    {
        MembershipApplication::query()->create([
            'application_no' => 'HLA-A-044',
            'full_name' => 'Iresha Madushani',
            'nic' => '199534567890',
            'date_of_birth' => '1995-06-02',
            'gender' => 'FEMALE',
            'occupation' => 'Nurse',
            'address_line1' => '12 Lake Road',
            'city' => 'Maharagama',
            'district' => 'Colombo',
            'phone' => '0775550101',
            'email' => 'iresha.m@example.lk',
            'membership_type' => 'ORDINARY',
            'motivation' => 'I want welfare cover for my parents.',
            'status' => 'PENDING',
        ]);

        VolunteerApplication::query()->create([
            'reference' => 'HLA-V-011',
            'full_name' => 'Kavitha Nadarajah',
            'email' => 'kavitha.n@example.lk',
            'phone' => '0775550201',
            'city' => 'Batticaloa',
            'district' => 'Batticaloa',
            'interests' => 'MEDICAL,EDUCATION',
            'skills' => 'Nursing diploma',
            'availability' => 'WEEKENDS',
            'hours_per_month' => 12,
            'motivation' => 'I can help at medical camps in the east.',
            'status' => 'NEW',
        ]);

        ContactMessage::query()->create([
            'name' => 'Priyantha Dias',
            'email' => 'priyantha@example.lk',
            'phone' => '0715550301',
            'subject' => 'Corporate sponsorship for scholarships',
            'message' => 'Our firm would like to endow a named scholarship.',
            'topic' => 'SPONSORSHIP',
            'status' => 'NEW',
        ]);

        Subscriber::query()->create([
            'email' => 'news@example.lk',
            'locale' => 'en',
            'is_confirmed' => true,
        ]);
    }

    private function election(): void
    {
        $election = Election::query()->create([
            'slug' => 'agm-2026-office-bearers',
            ...$this->t('title', 'AGM 2026 — Office Bearers', '2026 මහා සභාව — නිලධාරී මණ්ඩලය', 'AGM 2026 — அலுவலர் குழு'),
            ...$this->t('description', 'Confidential e-vote for the 2026–2028 committee. One vote per active member.', 'රහසිගත ඊ-ඡන්දය. ක්‍රියාකාරී සාමාජිකයෙකුට එක් ඡන්දයක්.', 'ரகசிய மின் வாக்களிப்பு.'),
            'status' => 'DRAFT',
            'opens_at' => now()->subDays(2),
            'closes_at' => now()->addDays(21),
        ]);

        $election->candidates()->create(['name' => 'Nimal Perera', 'position_en' => 'President', 'position_si' => 'සභාපති', 'position_ta' => 'தலைவர்', 'bio' => 'Committee member since 2018', 'sort_order' => 1]);
        $election->candidates()->create(['name' => 'Shanthi Fernando', 'position_en' => 'President', 'position_si' => 'සභාපති', 'position_ta' => 'தலைவர்', 'bio' => 'Welfare lead, Eastern Province', 'sort_order' => 2]);
        $election->candidates()->create(['name' => 'Ravi Jayasuriya', 'position_en' => 'Secretary', 'position_si' => 'ලේකම්', 'position_ta' => 'செயலாளர்', 'bio' => 'Former treasurer', 'sort_order' => 3]);
    }

    private function misc(Member $demo): void
    {
        Suggestion::query()->create([
            'reference' => 'HLA-S-001',
            'member_id' => $demo->id,
            'is_anonymous' => false,
            'category' => 'IDEA',
            'subject' => 'Evening welfare clinic once a month',
            'body' => 'Many working members cannot attend weekday morning clinics.',
            'status' => 'NEW',
        ]);
    }
}
