<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
    ];

    public static function get(string $key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function set(string $key, $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public static function getAllSettings(): array
    {
        $defaults = [
            // General Institute Settings
            'instituteName' => 'Saikat Computer & Training Jubo Songhoton',
            'currentSession' => 'January - June 2026',
            'helplinePhone' => '+880 1712-345678',
            'helplineEmail' => 'support@jubounnayon.com',
            'headquartersAddress' => 'Youth Bhaban Complex, Mirpur-2, Dhaka-1216, Bangladesh',
            'facebookUrl' => 'https://facebook.com',
            'youtubeUrl' => 'https://youtube.com',

            // Top Notice & Marquee
            'tickerText' => 'Batch 2026 Admissions Open for Certified Vocational & ICT Programs | Apply Online Today | QR-Verified Certificates Available',
            'urgentNoticeEnabled' => '1',
            'emergencyNoticeText' => 'Official Technical Training Diploma Certificates for Batch 2026 are now available for online verification and issuance.',
            'emergencyNoticeLink' => '/results',

            // 1. Hero Section Content & Background
            'heroBadge' => 'Government Accredited Technical Institute',
            'heroTitle' => 'Empowering National Youth Through Technical Mastery',
            'heroSubtitle' => 'Transforming potential into professional excellence with industry-aligned technical, engineering, and digital skills nationwide across all 64 districts.',
            'heroDuration' => 'Year-Round Admissions',
            'heroHighlight' => '100% Certified Diplomas',
            'heroPrimaryBtnText' => 'Explore Programs',
            'heroPrimaryBtnLink' => '/courses',
            'heroSecondaryBtnText' => 'Apply for Admission',
            'heroSecondaryBtnLink' => '/register',
            'heroBgImage' => 'https://images.unsplash.com/photo-1571260899304-425eee4c7efc?q=80&w=1600&auto=format&fit=crop',

            // 2. Impact Stats Section (4 Cards + Bottom Badge)
            'stat1Number' => '1,500+',
            'stat1Title' => 'Certified Trainees',
            'stat1Subtext' => 'Govt-recognized technical and ICT graduates',
            'stat1Badge' => 'Verified Diplomas',

            'stat2Number' => '150+',
            'stat2Title' => 'Industry Courses',
            'stat2Subtext' => 'Hands-on trades, engineering & digital programs',
            'stat2Badge' => 'Practical Syllabus',

            'stat3Number' => '64+',
            'stat3Title' => 'Regional Branches',
            'stat3Subtext' => 'Accredited training centers nationwide',
            'stat3Badge' => 'Across Bangladesh',

            'stat4Number' => '94.2%',
            'stat4Title' => 'Employment Rate',
            'stat4Subtext' => 'Active placement and startup support for youth',
            'stat4Badge' => 'Self-Reliance',

            'statBottomBadge' => 'National Youth Development Platform',

            // 3. About Section (Matches Image 4 Exactly)
            'aboutBadge' => 'About National Youth Development',
            'aboutTitle' => 'Bridging the Gap Between Technical Education & Real-World Careers',
            'aboutDescription' => 'The National Youth Development Technical Institute is dedicated to transforming ambitious youth into industry-ready professionals. Across 64 districts, we deliver standardized technical diplomas, ICT mastery, and self-employment initiatives.',
            'aboutImage' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=1200&auto=format&fit=crop',
            'aboutExpNumber' => '15+',
            'aboutExpBadge' => 'Years of Excellence',
            'aboutExpSub' => 'Technical Education',
            'aboutPillar1Title' => 'Government-Accredited Curriculum',
            'aboutPillar1Desc' => 'Nationally recognized diplomas and certificates valid for civil service, private sector, and overseas jobs.',
            'aboutPillar2Title' => '80% Practical Lab Workshops',
            'aboutPillar2Desc' => 'Real-world training in modern computer labs, electrical workshops, and industrial engineering suites.',
            'aboutPillar3Title' => 'Career Placement & Youth Loan Linkage',
            'aboutPillar3Desc' => 'Direct internship opportunities, freelance mentorship, and easy-term youth entrepreneurship loan guidance.',
            'aboutFooterLeft' => 'Registered Institute • Government Affiliated',
            'aboutFooterRightText' => 'Explore All Trade Programs',
            'aboutFooterRightLink' => '/courses',

            // 4. Chairman's Speech Section
            'chairmanBadge' => 'Executive Leadership & Academic Vision',
            'chairmanTitle' => "Chairman's Speech",
            'chairmanSubtitle' => 'Message from the Chairman & Academic Director of Saikat Computer and Training Jubo Songhoton',
            'chairmanName' => 'Shariyat Ullah Saikat',
            'chairmanDesignation' => 'Chairman & Academic Director',
            'chairmanOrg' => 'Saikat Computer & Training Jubo Songhoton',
            'chairmanQuote1' => 'Our paramount mission is to empower the young generation of Bangladesh with practical, industry-driven technical skills. In a rapidly transforming world, theoretical knowledge alone is never enough—every young student must master authentic hands-on competence in digital computing, modern engineering trades, and digital entrepreneurship.',
            'chairmanQuote2' => 'Through government subsidized training programs, state-of-the-art laboratory facilities, and dedicated mentors, Saikat Computer and Training Jubo Songhoton remains relentlessly devoted to building a self-reliant, skilled, and employed youth workforce for our beloved nation.',
            'chairmanImage' => '/images/Efra Khan.jpg',

            // 5. Popup Modal System
            'popupEnabled' => '0',
            'popupTitle' => 'Admissions Open - Batch 2026',
            'popupBadge' => 'Limited Seats Available',
            'popupMessage' => 'Govt-subsidized technical courses and vocational training programs are currently accepting applications. Register today to reserve your accredited trade diploma seat.',
            'popupImage' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=900&auto=format&fit=crop',
            'popupButtonText' => 'Apply For Admission',
            'popupButtonUrl' => '/register',

            // 6. Courses Page CMS
            'coursesPageBadge' => 'Government Accredited Trades',
            'coursesPageTitle' => 'All Vocational & Technical Courses',
            'coursesPageSubtitle' => 'Explore comprehensive training programs designed for immediate employment, freelancing competence, and career advancement across Bangladesh.',
            'coursesPageCtaTitle' => 'Need Guidance Choosing The Right Trade?',
            'coursesPageCtaSubtitle' => 'Our certified academic advisors are ready to counsel you based on your personal interests, prior schooling, and career goals.',
            'coursesPageCtaBtn' => 'Apply Online Now',

            // 7. Results Page CMS
            'resultsPageBadge' => 'Official Examination Directorate',
            'resultsPageTitle' => 'Certificate & Marksheet Verification Portal',
            'resultsPageSubtitle' => 'Instant online verification for government accredited technical diplomas, marksheet transcripts, and vocational credentials.',
            'resultsInstructionTitle' => 'How to Verify Your Academic Credential',
            'resultsInstructionText' => 'Enter your authentic Student Roll Number and Registration Number as printed on your admit card or certificate to check online validity and print authorized transcripts.',
            'resultsHelplineText' => 'Facing difficulty verifying your certificate? Contact our central verification desk directly at +880 1712-345678.',

            // 8. Gallery Page CMS
            'galleryPageBadge' => 'Visual Archives & Campus Life',
            'galleryPageTitle' => 'Life at National Youth Development Complex',
            'galleryPageSubtitle' => 'Moments from our hands-on workshops, state-of-the-art computer labs, graduation ceremonies, and technical training sessions.',

            // 9. Resources Page CMS
            'resourcesPageBadge' => 'Download Center & Public Notices',
            'resourcesPageTitle' => 'Official Resources, Notices & Circulars',
            'resourcesPageSubtitle' => 'Access official circulars, examination schedules, syllabus booklets, and application forms directly from our central repository.',

            // 10. Contact Page CMS
            'contactPageBadge' => 'Direct Communication',
            'contactPageTitle' => 'Get In Touch With Our Central Directorate',
            'contactPageSubtitle' => 'Have questions regarding admissions, trade selection, branch locations, or certificate verification? Our helpline team is here for you.',
            'contactOfficeHours' => 'Saturday - Thursday: 9:00 AM - 5:00 PM (Friday Closed)',
            'contactMapEmbedUrl' => 'https://maps.google.com',

            // 11. Header, Top Utility Bar & Brand Logo
            'showTopBar' => '1',
            'officeStatus' => 'open',
            'officeOpenLabel' => 'Open Today',
            'officeClosedLabel' => 'Closed Today',
            'officeOpeningTime' => '9:00 AM',
            'officeClosingTime' => '5:00 PM',
            'officeWeeklyDays' => 'Sun - Thu (Fri - Sat Closed)',
            'headerLogoImage' => '',
            'headerLogoText' => 'NYD',
            'headerTitleMain' => 'National Youth',
            'headerTitleHighlight' => 'Dev',
            'headerSubtitle' => 'Technical Institute',
            'instituteShortName' => 'National Youth Dev',

            // 12. Navigation & Action Button Labels
            'navHomeText' => 'Home',
            'navCoursesText' => 'Courses',
            'navResultsText' => 'Exam Result',
            'navGalleryText' => 'Gallery',
            'navResourcesText' => 'Resources',
            'navContactText' => 'Contact Us',
            'headerLoginText' => 'Login',
            'headerRegisterText' => 'Register',

            // 13. Footer Brand, Columns & Copyright
            'footerBrandTitle' => 'National Youth Development',
            'footerBrandSubtitle' => 'Technical Training Platform',
            'footerDescription' => 'A premier government-accredited technical institute dedicated to empowering youth through practical engineering, computer sciences, and vocational training across Bangladesh.',
            'footerAccreditationBadge' => 'Govt. Reg. Affiliated Technical Directorate',
            'footerSocialHeading' => 'Official Channels',
            'footerCol2Title' => 'Academic Programs',
            'footerCol3Title' => 'Portal Verification',
            'footerCol4Title' => 'Central Directorate',
            'footerCopyright' => 'National Youth Development Platform. All rights reserved.',
            'footerSupervisedLabel' => 'Supervised by',
            'footerSupervisedOrg' => 'Saikat Computer & Training Jubo Songhoton',

            // 14. Dynamic Social Media Links
            'socialLinks' => '',
        ];

        $saved = static::pluck('value', 'key')->toArray();
        $merged = array_merge($defaults, $saved);

        // Seed socialLinks from legacy facebookUrl/youtubeUrl if not yet customized
        if (empty($merged['socialLinks'])) {
            $defaultSocials = [
                [
                    'platform' => 'Facebook',
                    'icon' => 'fa-brands fa-facebook-f',
                    'url' => $merged['facebookUrl'] ?? 'https://facebook.com',
                    'color' => 'hover:bg-blue-600',
                ],
                [
                    'platform' => 'YouTube',
                    'icon' => 'fa-brands fa-youtube',
                    'url' => $merged['youtubeUrl'] ?? 'https://youtube.com',
                    'color' => 'hover:bg-red-600',
                ],
                [
                    'platform' => 'LinkedIn',
                    'icon' => 'fa-brands fa-linkedin-in',
                    'url' => 'https://linkedin.com',
                    'color' => 'hover:bg-sky-600',
                ],
            ];
            $merged['socialLinks'] = json_encode($defaultSocials);
        }

        $decodedSocials = json_decode($merged['socialLinks'], true);
        $merged['socialLinksArray'] = is_array($decodedSocials) ? $decodedSocials : [];

        // Convert boolean flags
        $merged['showTopBar'] = !empty($merged['showTopBar']) && $merged['showTopBar'] !== '0';
        $merged['urgentNoticeEnabled'] = !empty($merged['urgentNoticeEnabled']) && $merged['urgentNoticeEnabled'] !== '0';
        $merged['popupEnabled'] = !empty($merged['popupEnabled']) && $merged['popupEnabled'] !== '0';

        return $merged;
    }
}
