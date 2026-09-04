<?php

namespace App\Support;

class WhatsAppLink
{
    public static function href(?string $message = null): string
    {
        $site = SiteContent::identity();
        $digits = preg_replace('/\D+/', '', (string) ($site['contact']['hotline'] ?? '')) ?: '94768185377';

        if (str_starts_with($digits, '0')) {
            $digits = '94'.substr($digits, 1);
        }

        $url = 'https://wa.me/'.$digits;

        if (is_string($message) && $message !== '') {
            $url .= '?text='.rawurlencode($message);
        }

        return $url;
    }

    public static function display(): string
    {
        return (string) (SiteContent::identity()['contact']['hotline_display'] ?? '076 818 5377');
    }

    public static function donationSlipMessage(?string $reference = null, ?int $amount = null): string
    {
        $template = $reference
            ? (string) d('donations.slipWhatsAppThanksMessage')
            : (string) d('donations.slipWhatsAppMessage');

        return str_replace(
            [':reference', ':amount', ':phone'],
            [
                $reference ?? '',
                $amount !== null ? lkr($amount) : '',
                self::display(),
            ],
            $template,
        );
    }
}
