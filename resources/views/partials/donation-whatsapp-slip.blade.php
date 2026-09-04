@php
    $slipMessage = \App\Support\WhatsAppLink::donationSlipMessage($reference ?? null, $amount ?? null);
    $slipText = str_replace(':phone', \App\Support\WhatsAppLink::display(), (string) $d['donations']['slipWhatsAppText']);
@endphp
<div class="mt-6 rounded-2xl border border-ink-200 bg-ink-50 p-4">
    <p class="font-extrabold text-ink-900">{{ $d['donations']['slipWhatsAppTitle'] }}</p>
    <p class="mt-2 text-sm text-ink-600">{{ $slipText }}</p>
    <p class="mt-2 text-lg font-extrabold text-ink-900">{{ \App\Support\WhatsAppLink::display() }}</p>
    <a href="{{ whatsapp_url($slipMessage) }}" class="btn btn-brand mt-4" target="_blank" rel="noopener">{{ $d['donations']['slipWhatsAppCta'] }}</a>
</div>
