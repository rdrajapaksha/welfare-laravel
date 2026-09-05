<?php

return [
    'name' => 'Heart Link Allianze Welfare Society',
    'short_name' => 'Heart Link Allianze',
    'registration_no' => 'BD/BW/SSW/01/149',
    'founded_year' => 2013,
    'locales' => ['en', 'si', 'ta'],
    'default_locale' => 'en',

    'contact' => [
        'phone' => env('HLA_PHONE', '+94703379955'),
        'phone_display' => '070 337 9955',
        'hotline' => env('HLA_HOTLINE', '+94768185377'),
        'hotline_display' => '076 818 5377',
        'email' => env('HLA_EMAIL', 'info@heartlinkallianz.lk'),
        'welfare_email' => 'welfare@heartlinkallianz.lk',
        'street' => 'No. 118, Bogahapelessa, Mahulpotha',
        'locality' => 'Bandarawela',
        'region' => 'Uva Province',
        'postal_code' => '90100',
        'country_name' => 'Sri Lanka',
        'map_embed' => 'https://www.google.com/maps?q=Bogahapelessa,+Mahulpotha,+Bandarawela,+Sri+Lanka&output=embed',
        'map_link' => 'https://www.google.com/maps/search/?api=1&query=Bogahapelessa+Mahulpotha+Bandarawela+Sri+Lanka',
    ],

    'bank' => [
        'bank_name' => 'Bank of Ceylon',
        'branch' => 'Bandarawela Branch',
        'account_name' => 'Heart Link Allianze Welfare Society',
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
        'projects' => 20,
        'volunteers' => 420,
    ],

    'social' => [
        ['key' => 'facebook', 'label' => 'Facebook', 'href' => 'https://facebook.com/heartlinkallianze'],
        ['key' => 'instagram', 'label' => 'Instagram', 'href' => 'https://instagram.com/heartlinkallianze'],
        ['key' => 'youtube', 'label' => 'YouTube', 'href' => 'https://youtube.com/@heartlinkallianze'],
        ['key' => 'whatsapp', 'label' => 'WhatsApp', 'href' => 'https://wa.me/94768185377'],
    ],

    'locale_meta' => [
        'en' => ['label' => 'English', 'short' => 'EN', 'html' => 'en-LK'],
        'si' => ['label' => 'සිංහල', 'short' => 'සි', 'html' => 'si-LK'],
        'ta' => ['label' => 'தமிழ்', 'short' => 'த', 'html' => 'ta-LK'],
    ],
];
