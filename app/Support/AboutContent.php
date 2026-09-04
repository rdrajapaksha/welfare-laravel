<?php

namespace App\Support;

class AboutContent
{
    /**
     * @return array{en: string, si: string, ta: string}
     */
    public static function vision(): array
    {
        return [
            'en' => 'A Sri Lanka where no family faces illness, bereavement or disaster without a community standing beside them.',
            'si' => 'රෝගීභාවය, මරණය හෝ ආපදාවකදී කිසිදු පවුලක් ප්‍රජාවක සහායෙන් තොරව තනි නොවන ශ්‍රී ලංකාවක්.',
            'ta' => 'நோய், மரணம் அல்லது பேரிடரில் எந்தக் குடும்பமும் ஒரு சமூகத்தின் ஆதரவின்றி தனியாக நில்லாத இலங்கை.',
        ];
    }

    /**
     * @return array{en: string, si: string, ta: string}
     */
    public static function mission(): array
    {
        return [
            'en' => 'To organise members and neighbours into a transparent, well-governed welfare association that delivers emergency relief, lasting welfare schemes and community development — and accounts for every rupee in public.',
            'si' => 'සාමාජිකයින් සහ අසල්වැසියන් විනිවිද පෙනෙන, හොඳින් පාලනය වන සුබසාධක සමිතියක් ලෙස සංවිධානය කර, හදිසි සහන, දිගුකාලීන සුබසාධක යෝජනා සහ ප්‍රජා සංවර්ධනය ලබා දී, සෑම රුපියලක්ම ප්‍රසිද්ධියේ ගිණුම්ගත කිරීම.',
            'ta' => 'உறுப்பினர்களையும் அண்டை வீட்டினரையும் வெளிப்படையான, நல்லாட்சி கொண்ட நலன்புரி சங்கமாக ஒழுங்கமைத்து, அவசர நிவாரணம், நீடித்த நலத்திட்டங்கள், சமூக அபிவிருத்தி ஆகியவற்றை வழங்கி, ஒவ்வொரு ரூபாயையும் பொதுவில் கணக்குக் காட்டுதல்.',
        ];
    }

    /**
     * @return list<array{title: array{en: string, si: string, ta: string}, text: array{en: string, si: string, ta: string}}>
     */
    public static function values(): array
    {
        return [
            [
                'title' => ['en' => 'Transparency', 'si' => 'විනිවිදභාවය', 'ta' => 'வெளிப்படைத்தன்மை'],
                'text' => [
                    'en' => 'Audited accounts, published annual reports and a public spending ledger. Members may inspect the books.',
                    'si' => 'විගණනය කළ ගිණුම්, ප්‍රකාශිත වාර්ෂික වාර්තා සහ ප්‍රසිද්ධ වියදම් ලේඛනය. සාමාජිකයින්ට පොත් පරීක්ෂා කළ හැක.',
                    'ta' => 'தணிக்கை செய்யப்பட்ட கணக்குகள், வெளியிடப்பட்ட வருடாந்த அறிக்கைகள், பொதுச் செலவுப் பேரேடு. உறுப்பினர்கள் புத்தகங்களைப் பரிசீலிக்கலாம்.',
                ],
            ],
            [
                'title' => ['en' => 'Dignity', 'si' => 'ගෞරවය', 'ta' => 'கண்ணியம்'],
                'text' => [
                    'en' => 'Welfare is a right of membership, not a favour. Claims are decided by a committee, never by a single office-bearer.',
                    'si' => 'සුබසාධනය සාමාජිකත්වයේ අයිතියකි, උපකාරයක් නොවේ. ඉල්ලීම් තනි නිලධාරියෙකු විසින් නොව කමිටුවක් විසින් තීරණය කෙරේ.',
                    'ta' => 'நலன் உறுப்புரிமையின் உரிமை, தயவு அல்ல. கோரிக்கைகள் ஒரு அலுவலரால் அல்ல, குழுவால் தீர்மானிக்கப்படும்.',
                ],
            ],
            [
                'title' => ['en' => 'Proximity', 'si' => 'ළඟින් සිටීම', 'ta' => 'அருகில் இருத்தல்'],
                'text' => [
                    'en' => 'We work in the districts we live in. Relief is delivered by neighbours, not posted from a distant office.',
                    'si' => 'අපි ජීවත් වන දිස්ත්‍රික්කවලම කටයුතු කරමු. සහනය දුරස්ථ කාර්යාලයකින් නොව අසල්වැසියන් විසින් බාර දෙනු ලැබේ.',
                    'ta' => 'நாம் வாழும் மாவட்டங்களிலேயே செயற்படுகிறோம். நிவாரணம் தொலை அலுவலகத்திலிருந்து அல்ல, அண்டை வீட்டினரால் வழங்கப்படுகிறது.',
                ],
            ],
            [
                'title' => ['en' => 'Stewardship', 'si' => 'භාරකාරත්වය', 'ta' => 'பொறுப்பாண்மை'],
                'text' => [
                    'en' => 'Donations are ring-fenced by purpose. Administration is capped. Unused balances are reported, never quietly absorbed.',
                    'si' => 'පරිත්‍යාග අරමුණ අනුව වෙන් කෙරේ. පරිපාලනයට සීමාවක් ඇත. භාවිත නොකළ ශේෂයන් වාර්තා කෙරේ, නිහඬව අවශෝෂණය නොවේ.',
                    'ta' => 'நன்கொடைகள் நோக்கத்திற்கு ஏற்ப தனியே வைக்கப்படும். நிர்வாகத்திற்கு உச்ச வரம்புண்டு. பயன்படுத்தாத மீதிகள் அறிக்கையிடப்படும், அமைதியாக உள்வாங்கப்படாது.',
                ],
            ],
        ];
    }

    /**
     * @return list<array{year: string, title: array{en: string, si: string, ta: string}, text: array{en: string, si: string, ta: string}}>
     */
    public static function history(): array
    {
        return [
            [
                'year' => '2013',
                'title' => ['en' => 'A neighbourhood collection tin', 'si' => 'අසල්වාසී එකතු කිරීමේ පෙට්ටිය', 'ta' => 'அண்டை வீட்டு நன்கொடைப் பெட்டி'],
                'text' => [
                    'en' => 'Twelve families in Nugegoda started a weekly collection to cover funeral costs for neighbours who could not. The tin sat on a shop counter on Temple Road.',
                    'si' => 'නුගේගොඩේ පවුල් දොළහක්, එයට නොහැකි අසල්වැසියන්ගේ අවමංගල්‍ය වියදම් ආවරණය කිරීමට සතිපතා එකතුවක් ආරම්භ කළහ.',
                    'ta' => 'நுகேகொடையில் பன்னிரண்டு குடும்பங்கள், முடியாத அண்டை வீட்டினரின் இறுதிச் சடங்குச் செலவை ஈடுசெய்ய வாராந்திர சேகரிப்பைத் தொடங்கினர்.',
                ],
            ],
            [
                'year' => '2016',
                'title' => ['en' => 'Registered as a welfare association', 'si' => 'සුබසාධක සමිතියක් ලෙස ලියාපදිංචිය', 'ta' => 'நலன்புரி சங்கமாகப் பதிவு'],
                'text' => [
                    'en' => 'The group adopted a constitution, elected its first committee and registered as Heart Link Allianz Welfare Society - Sri Lanka (WA/2016/1187).',
                    'si' => 'කණ්ඩායම ව්‍යවස්ථාවක් සම්මත කර, පළමු කමිටුව තෝරා ලියාපදිංචි විය (WA/2016/1187).',
                    'ta' => 'குழு அரசியலமைப்பை ஏற்று, முதல் குழுவைத் தேர்ந்தெடுத்து பதிவு செய்தது (WA/2016/1187).',
                ],
            ],
            [
                'year' => '2020',
                'title' => ['en' => 'Pandemic relief', 'si' => 'වසංගත සහනය', 'ta' => 'தொற்றுநோய் நிவாரணம்'],
                'text' => [
                    'en' => 'Dry-ration packs reached 1,860 households in 11 districts. Accounts for that year were published in full.',
                    'si' => 'දිස්ත්‍රික්ක 11 ක නිවෙස් 1,860 කට වියළි සැනකිලි ඇසුරුම් ළඟා විය.',
                    'ta' => '11 மாவட்டங்களில் 1,860 வீடுகளுக்கு உலர் உணவுப் பொதிகள் சென்றடைந்தன.',
                ],
            ],
            [
                'year' => '2025',
                'title' => ['en' => 'Flood response and housing', 'si' => 'ගංවතුර ප්‍රතිචාරය සහ නිවාස', 'ta' => 'வெள்ளப் பதிலும் வீடமைப்பும்'],
                'text' => [
                    'en' => 'The May floods triggered the largest single relief operation in our history, followed by the Sarana housing project.',
                    'si' => 'මැයි ගංවතුර අපගේ ඉතිහාසයේ විශාලතම තනි සහන මෙහෙයුම අවුලුවා සරණ නිවාස ව්‍යාපෘතිය ආරම්භ විය.',
                    'ta' => 'மே வெள்ளம் எமது வரலாற்றின் மிகப்பெரிய தனி நிவாரண நடவடிக்கையைத் தூண்டியது.',
                ],
            ],
        ];
    }

    public static function pick(array $record): string
    {
        $locale = app()->getLocale();

        return $record[$locale] ?? $record['en'];
    }
}
