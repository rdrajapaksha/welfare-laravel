<?php

namespace App\Support;

class Nav
{
    /**
     * @param  array<string, mixed>  $d
     * @return list<array{label: string, href: string, children?: list<array{label: string, href: string}>}>
     */
    public static function main(array $d): array
    {
        $n = $d['nav'];

        return [
            ['label' => $n['home'], 'href' => '/'],
            [
                'label' => $n['about'],
                'href' => '/about',
                'children' => [
                    ['label' => $n['aboutAssociation'], 'href' => '/about'],
                    ['label' => $n['visionMission'], 'href' => '/about#vision'],
                    ['label' => $n['history'], 'href' => '/about#history'],
                    ['label' => $n['committee'], 'href' => '/about/committee'],
                    ['label' => $n['advisory'], 'href' => '/about/advisory'],
                    ['label' => $n['partners'], 'href' => '/partners'],
                ],
            ],
            [
                'label' => $n['services'],
                'href' => '/services',
                'children' => [
                    ['label' => $n['welfareProgrammes'], 'href' => '/services?category=WELFARE'],
                    ['label' => $n['emergencyAssistance'], 'href' => '/services?category=EMERGENCY'],
                    ['label' => $n['memberSupport'], 'href' => '/services?category=MEMBER_SUPPORT'],
                    ['label' => $n['communityProjects'], 'href' => '/projects'],
                ],
            ],
            [
                'label' => $n['news'],
                'href' => '/news',
                'children' => [
                    ['label' => $n['newsUpdates'], 'href' => '/news'],
                    ['label' => $n['activityReports'], 'href' => '/news?category=ACTIVITY_REPORT'],
                    ['label' => $n['upcomingEvents'], 'href' => '/events'],
                    ['label' => $n['pastEvents'], 'href' => '/events?filter=past'],
                ],
            ],
            [
                'label' => $n['members'],
                'href' => '/members',
                'children' => [
                    ['label' => $n['memberDirectory'], 'href' => '/members'],
                    ['label' => $n['join'], 'href' => '/join'],
                    ['label' => $n['volunteer'], 'href' => '/volunteer'],
                ],
            ],
            [
                'label' => $n['gallery'],
                'href' => '/gallery',
                'children' => [
                    ['label' => $n['photoGallery'], 'href' => '/gallery?type=PHOTO'],
                    ['label' => $n['videoGallery'], 'href' => '/gallery?type=VIDEO'],
                ],
            ],
            [
                'label' => $n['donations'],
                'href' => '/donations',
                'children' => [
                    ['label' => $n['donateNow'], 'href' => '/donations'],
                    ['label' => $n['bankDetails'], 'href' => '/donations#bank'],
                    ['label' => $n['donationUpdates'], 'href' => '/donations/updates'],
                    ['label' => $n['annualReports'], 'href' => '/transparency'],
                ],
            ],
            [
                'label' => $n['contact'],
                'href' => '/contact',
                'children' => [
                    ['label' => $n['faq'], 'href' => '/faq'],
                    ['label' => $n['documents'], 'href' => '/documents'],
                ],
            ],
        ];
    }

    /**
     * @param  array<string, mixed>  $d
     * @return list<array{title: string, links: list<array{label: string, href: string}>}>
     */
    public static function footer(array $d): array
    {
        $n = $d['nav'];
        $f = $d['footer'];

        return [
            [
                'title' => $f['quickLinks'],
                'links' => [
                    ['label' => $n['aboutAssociation'], 'href' => '/about'],
                    ['label' => $n['committee'], 'href' => '/about/committee'],
                    ['label' => $n['advisory'], 'href' => '/about/advisory'],
                    ['label' => $n['news'], 'href' => '/news'],
                    ['label' => $n['upcomingEvents'], 'href' => '/events'],
                    ['label' => $n['gallery'], 'href' => '/gallery'],
                    ['label' => $n['contact'], 'href' => '/contact'],
                ],
            ],
            [
                'title' => $f['ourWork'],
                'links' => [
                    ['label' => $n['welfareProgrammes'], 'href' => '/services?category=WELFARE'],
                    ['label' => $n['emergencyAssistance'], 'href' => '/services?category=EMERGENCY'],
                    ['label' => $n['memberSupport'], 'href' => '/services?category=MEMBER_SUPPORT'],
                    ['label' => $n['communityProjects'], 'href' => '/projects'],
                    ['label' => $n['donationUpdates'], 'href' => '/donations/updates'],
                ],
            ],
            [
                'title' => $f['getInvolved'],
                'links' => [
                    ['label' => $n['join'], 'href' => '/join'],
                    ['label' => $n['donateNow'], 'href' => '/donations'],
                    ['label' => $n['volunteer'], 'href' => '/volunteer'],
                    ['label' => $n['partners'], 'href' => '/partners'],
                    ['label' => $n['login'], 'href' => '/login'],
                ],
            ],
            [
                'title' => $f['resources'],
                'links' => [
                    ['label' => $n['annualReports'], 'href' => '/transparency'],
                    ['label' => $n['documents'], 'href' => '/documents'],
                    ['label' => $n['faq'], 'href' => '/faq'],
                    ['label' => $n['memberDirectory'], 'href' => '/members'],
                ],
            ],
        ];
    }

    /**
     * @param  array<string, mixed>  $d
     * @return list<array{label: string, href: string, icon: string}>
     */
    public static function member(array $d, bool $hasOpenElection = false): array
    {
        $dash = $d['dashboard'];

        $links = [
            ['label' => $dash['overview'], 'href' => '/dashboard', 'icon' => 'layout'],
            ['label' => $dash['digitalId'], 'href' => '/dashboard/id', 'icon' => 'id'],
            ['label' => $dash['profile'], 'href' => '/dashboard/profile', 'icon' => 'user'],
            ['label' => $dash['benefits'], 'href' => '/dashboard/benefits', 'icon' => 'heart'],
            ['label' => $dash['payments'], 'href' => '/dashboard/payments', 'icon' => 'wallet'],
            ['label' => $dash['events'], 'href' => '/dashboard/events', 'icon' => 'calendar'],
        ];

        if ($hasOpenElection) {
            $links[] = ['label' => $dash['eVoting'], 'href' => '/dashboard/vote', 'icon' => 'vote'];
        }

        return [
            ...$links,
            ['label' => $dash['suggestions'], 'href' => '/dashboard/suggestions', 'icon' => 'message'],
            ['label' => $dash['announcements'], 'href' => '/dashboard/announcements', 'icon' => 'megaphone'],
            ['label' => $dash['tickets'], 'href' => '/dashboard/tickets', 'icon' => 'lifebuoy'],
            ['label' => $dash['documents'], 'href' => '/dashboard/documents', 'icon' => 'folder'],
        ];
    }

    /**
     * @param  array<string, mixed>  $d
     * @return list<array{label: string, href: string, icon: string}>
     */
    public static function admin(array $d): array
    {
        $admin = $d['admin'];

        return [
            ['label' => $admin['overview'], 'href' => '/admin', 'icon' => 'layout'],
            ['label' => $admin['analytics'], 'href' => '/admin/analytics', 'icon' => 'chart'],
            ['label' => $admin['members'], 'href' => '/admin/members', 'icon' => 'users'],
            ['label' => $admin['applications'], 'href' => '/admin/applications', 'icon' => 'file'],
            ['label' => $admin['donations'], 'href' => '/admin/donations', 'icon' => 'coins'],
            ['label' => $admin['fees'], 'href' => '/admin/fees', 'icon' => 'wallet'],
            ['label' => $admin['events'], 'href' => '/admin/events', 'icon' => 'calendar'],
            ['label' => $admin['elections'], 'href' => '/admin/elections', 'icon' => 'vote'],
            ['label' => $admin['news'], 'href' => '/admin/news', 'icon' => 'newspaper'],
            ['label' => $admin['gallery'], 'href' => '/admin/gallery', 'icon' => 'images'],
            ['label' => $admin['programmes'], 'href' => '/admin/programmes', 'icon' => 'heart'],
            ['label' => $admin['projects'], 'href' => '/admin/projects', 'icon' => 'flag'],
            ['label' => $admin['partnersPage'], 'href' => '/admin/partners', 'icon' => 'users'],
            ['label' => $admin['documents'], 'href' => '/admin/documents', 'icon' => 'folder'],
            ['label' => $admin['reports'], 'href' => '/admin/reports', 'icon' => 'folder'],
            ['label' => $admin['tickets'], 'href' => '/admin/tickets', 'icon' => 'lifebuoy'],
            ['label' => $admin['suggestions'], 'href' => '/admin/suggestions', 'icon' => 'message'],
            ['label' => $admin['volunteers'], 'href' => '/admin/volunteers', 'icon' => 'heart'],
            ['label' => $admin['messages'], 'href' => '/admin/messages', 'icon' => 'mail'],
            ['label' => $admin['announcements'], 'href' => '/admin/announcements', 'icon' => 'megaphone'],
            ['label' => $admin['committeePage'], 'href' => '/admin/committee', 'icon' => 'users'],
            ['label' => $admin['content'], 'href' => '/admin/content', 'icon' => 'settings'],
        ];
    }
}
