<?php

namespace App\Support;

class AboutContent
{
    /**
     * @return array{en: string, si: string, ta: string}
     */
    public static function intro(): array
    {
        return [
            'en' => "Heart Link Allianze is a welfare organisation established around the shared purpose in its motto, “Together for One Goal.”\n\nIts main aim is, through unity, cooperation and organised mutual support, to help those in need, contribute to community wellbeing, and promote social responsibility.",
            'si' => "හදවතේ යාළුවෝ යනු “එකම අරමුණක් සඳහා එකට” යන ආදර්ශ පාඨයේ ප්‍රකාශිත පොදු අරමුණින් පිහිටුවන ලද සුබසාධක සංවිධානයකි.\n\nමෙම සංවිධානයේ ප්‍රධාන අරමුණ වන්නේ එකමුතුකම, සහයෝගය සහ අන්‍යෝන්‍ය සංවිධානය හරහා අවශ්‍යතා ඇති අයට උපකාර කිරීම, ප්‍රජාවේ යහපැවැත්මට දායක වීම සහ සමාජ වගකීම ප්‍රවර්ධනය කිරීමයි.",
            'ta' => "Heart Link Allianze என்பது “Together for One Goal” என்ற குறிக்கோள் வாக்கியத்தில் வெளிப்படும் பொது நோக்கத்துடன் நிறுவப்பட்ட ஒரு நலன்புரி அமைப்பாகும்.\n\nஇதன் முதன்மை நோக்கம் ஒற்றுமை, ஒத்துழைப்பு மற்றும் பரஸ்பர அமைப்பு மூலம் தேவையுடையோருக்கு உதவி, சமூக நலனுக்குப் பங்களித்து, சமூகப் பொறுப்பை ஊக்குவிப்பதே.",
        ];
    }

    /**
     * @return array{en: string, si: string, ta: string}
     */
    public static function vision(): array
    {
        return [
            'en' => 'To build a compassionate, united and caring community that works together to improve the lives and wellbeing of people in need.',
            'si' => 'අවශ්‍යතා ඇති අයගේ ජීවිත හා යහපැවැත්ම උසස් කිරීමට එකට කටයුතු කරන කරුණාවන්ත, එකමුතු සහ හිතෛෂී ප්‍රජාවක් ගොඩනැගීම.',
            'ta' => 'தேவையுடையோரின் வாழ்வையும் நலனையும் மேம்படுத்த ஒன்றிணைந்து செயற்படும் இரக்கமுள்ள, ஒற்றுமையான, அக்கறையுள்ள சமூகத்தை உருவாக்குதல்.',
        ];
    }

    /**
     * @return array{en: string, si: string, ta: string}
     */
    public static function mission(): array
    {
        return [
            'en' => 'To bring people together under the principle of ‘Together for One Goal’ and implement sustainable welfare, social, educational, health, and community development programmes that positively impact the lives of individuals and communities.',
            'si' => '‘එකම අරමුණක් සඳහා එකට’ යන ප්‍රතිපත්තිය යටතේ ජනතාව එක්රැස් කර, පුද්ගලයන්ගේ හා ප්‍රජාවන්ගේ ජීවිතවලට ධනාත්මක බලපෑමක් ඇති කරන තිරසාර සුබසාධක, සමාජ, අධ්‍යාපනික, සෞඛ්‍ය හා ප්‍රජා සංවර්ධන වැඩසටහන් ක්‍රියාත්මක කිරීම.',
            'ta' => '‘ஒரே இலக்குக்காக ஒன்றாக’ என்ற கொள்கையின் கீழ் மக்களை ஒன்றிணைத்து, தனிநபர்களுக்கும் சமூகங்களுக்கும் நேர்மறையான தாக்கம் தரும் நீடித்த நலன்புரி, சமூக, கல்வி, சுகாதார மற்றும் சமூக அபிவிருத்தித் திட்டங்களைச் செயல்படுத்துதல்.',
        ];
    }

    /**
     * @return array{en: string, si: string, ta: string}
     */
    public static function objectivesText(): array
    {
        return [
            'en' => implode("\n", [
                'To support people facing economic and social difficulties.',
                'To assist patients who require financial or other support for medical treatment.',
                'To provide educational assistance to children from low-income families.',
                'To support and organise welfare programmes for elderly people.',
                'To promote environmental protection and conservation activities.',
                'To support religious, cultural and community development activities.',
                'To promote unity, friendship, cooperation and mutual support among members and the community.',
                'To identify community needs and organise appropriate social welfare programmes.',
                'To encourage voluntary service and social responsibility among members.',
                'To contribute towards building a healthier, happier and more compassionate society.',
            ]),
            'si' => implode("\n", [
                'ආර්ථික හා සමාජ දුෂ්කරතාවලට මුහුණ දෙන අයට සහාය දීම.',
                'වෛද්‍ය ප්‍රතිකාර සඳහා මූල්‍යමය හෝ වෙනත් උපකාර අවශ්‍ය රෝගීන්ට උපකාර කිරීම.',
                'අඩු ආදායම් පවුල්වල දරුවන්ට අධ්‍යාපන ආධාර ලබා දීම.',
                'වැඩිහිටියන් සඳහා සුබසාධක වැඩසටහන් සංවිධානය කිරීම හා සහාය දීම.',
                'පරිසර ආරක්ෂාව සහ සංරක්ෂණ කටයුතු ප්‍රවර්ධනය කිරීම.',
                'ආගමික, සංස්කෘතික සහ ප්‍රජා සංවර්ධන කටයුතුවලට සහාය දීම.',
                'සාමාජිකයින් හා ප්‍රජාව අතර එකමුතුකම, මිත්‍රත්වය, සහයෝගය සහ අන්‍යෝන්‍ය සහාය ප්‍රවර්ධනය කිරීම.',
                'ප්‍රජා අවශ්‍යතා හඳුනාගෙන ඒවාට ගැළපෙන සමාජ සුබසාධක වැඩසටහන් සංවිධානය කිරීම.',
                'සාමාජිකයින් අතර ස්වේච්ඡා සේවය සහ සමාජ වගකීම දිරිමත් කිරීම.',
                'වඩා සෞඛ්‍ය සම්පන්න, සතුටුදායක සහ කරුණාවන්ත සමාජයක් ගොඩනැගීමට දායක වීම.',
            ]),
            'ta' => implode("\n", [
                'பொருளாதார மற்றும் சமூக சிரமங்களை எதிர்கொள்பவர்களுக்கு ஆதரவளித்தல்.',
                'மருத்துவ சிகிச்சைக்கு நிதி அல்லது பிற உதவி தேவைப்படும் நோயாளிகளுக்கு உதவுதல்.',
                'குறைந்த வருமானக் குடும்பங்களைச் சேர்ந்த குழந்தைகளுக்கு கல்வி உதவி வழங்குதல்.',
                'முதியோருக்கான நலன்புரி நிகழ்ச்சிகளை ஆதரித்து ஒழுங்கமைத்தல்.',
                'சுற்றுச்சூழல் பாதுகாப்பு மற்றும் பேணுகை நடவடிக்கைகளை ஊக்குவித்தல்.',
                'சமய, பண்பாட்டு மற்றும் சமூக அபிவிருத்தி நடவடிக்கைகளுக்கு ஆதரவளித்தல்.',
                'உறுப்பினர்களுக்கும் சமூகத்திற்கும் இடையே ஒற்றுமை, நட்பு, ஒத்துழைப்பு மற்றும் பரஸ்பர ஆதரவை ஊக்குவித்தல்.',
                'சமூகத் தேவைகளை இனங்கண்டு பொருத்தமான சமூக நலத்திட்டங்களை ஒழுங்கமைத்தல்.',
                'உறுப்பினர்களிடையே தொண்டூழியம் மற்றும் சமூகப் பொறுப்பை ஊக்குவித்தல்.',
                'ஆரோக்கியமான, மகிழ்ச்சியான, இரக்கமுள்ள சமூகத்தை உருவாக்குவதற்குப் பங்களித்தல்.',
            ]),
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
                    'en' => 'Twelve families in Bandarawela started a weekly collection to cover funeral costs for neighbours who could not. The tin sat on a shop counter in Mahulpotha.',
                    'si' => 'බණ්ඩාරවෙලේ පවුල් දොළහක්, එයට නොහැකි අසල්වැසියන්ගේ අවමංගල්‍ය වියදම් ආවරණය කිරීමට සතිපතා එකතුවක් ආරම්භ කළහ.',
                    'ta' => 'பண்டாரவளையில் பன்னிரண்டு குடும்பங்கள், முடியாத அண்டை வீட்டினரின் இறுதிச் சடங்குச் செலவை ஈடுசெய்ய வாராந்திர சேகரிப்பைத் தொடங்கினர்.',
                ],
            ],
            [
                'year' => '2016',
                'title' => ['en' => 'Registered as a welfare association', 'si' => 'සුබසාධක සමිතියක් ලෙස ලියාපදිංචිය', 'ta' => 'நலன்புரி சங்கமாகப் பதிவு'],
                'text' => [
                    'en' => 'The group adopted a constitution, elected its first committee and registered as Heart Link Allianze (BD/BW/SSW/01/149).',
                    'si' => 'කණ්ඩායම ව්‍යවස්ථාවක් සම්මත කර, පළමු කමිටුව තෝරා හදවතේ යාළුවෝ සුබසාධක සංසදය ලෙස ලියාපදිංචි විය (BD/BW/SSW/01/149).',
                    'ta' => 'குழு அரசியலமைப்பை ஏற்று, முதல் குழுவைத் தேர்ந்தெடுத்து Heart Link Allianze ஆகப் பதிவு செய்தது (BD/BW/SSW/01/149).',
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
