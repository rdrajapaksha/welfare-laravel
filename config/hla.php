<?php

return [
    'name' => 'Heart Link Allianz Welfare Society - Sri Lanka',
    'short_name' => 'Heart Link Allianz',
    'registration_no' => 'WA/2016/1187',
    'founded_year' => 2013,
    'locales' => ['en', 'si', 'ta'],
    'default_locale' => 'en',

    'contact' => [
        'phone' => env('HLA_PHONE', '+94112345678'),
        'phone_display' => '+94 11 234 5678',
        'hotline' => env('HLA_HOTLINE', '+94771234567'),
        'hotline_display' => '+94 77 123 4567',
        'email' => env('HLA_EMAIL', 'info@heartlinkallianz.lk'),
        'welfare_email' => 'welfare@heartlinkallianz.lk',
        'street' => 'No. 142, Temple Road',
        'locality' => 'Nugegoda',
        'region' => 'Western Province',
        'postal_code' => '10250',
        'country_name' => 'Sri Lanka',
        'map_embed' => 'https://www.google.com/maps?q=Nugegoda,+Sri+Lanka&output=embed',
        'map_link' => 'https://www.google.com/maps/search/?api=1&query=Nugegoda+Sri+Lanka',
    ],

    'bank' => [
        'bank_name' => 'Bank of Ceylon',
        'branch' => 'Nugegoda Branch',
        'account_name' => 'Heart Link Allianz Welfare Society - Sri Lanka',
        'account_no' => '0072 4451 8890',
        'swift' => 'BCEYLKLX',
    ],

    'fees' => [
        'registration' => 1000,
        'monthly' => 300,
    ],

    'impact' => [
        'members' => 1840,
        'families_assisted' => 6250,
        'welfare_disbursed' => 48600000,
        'projects' => 34,
        'volunteers' => 420,
    ],

    'social' => [
        ['key' => 'facebook', 'label' => 'Facebook', 'href' => 'https://facebook.com/heartlinkallianz'],
        ['key' => 'instagram', 'label' => 'Instagram', 'href' => 'https://instagram.com/heartlinkallianz'],
        ['key' => 'youtube', 'label' => 'YouTube', 'href' => 'https://youtube.com/@heartlinkallianz'],
        ['key' => 'whatsapp', 'label' => 'WhatsApp', 'href' => 'https://wa.me/94771234567'],
    ],

    'locale_meta' => [
        'en' => ['label' => 'English', 'short' => 'EN', 'html' => 'en-LK'],
        'si' => ['label' => 'සිංහල', 'short' => 'සි', 'html' => 'si-LK'],
        'ta' => ['label' => 'தமிழ்', 'short' => 'த', 'html' => 'ta-LK'],
    ],
];
