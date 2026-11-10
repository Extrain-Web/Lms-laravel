<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use App\Models\StudentResult;
use App\Models\Admission;
use App\Models\ContactInquiry;
use App\Models\Resource;
use App\Models\GalleryItem;
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Users
        User::create([
            'name' => 'Super Administrator',
            'email' => 'admin@jubounnayon.com',
            'phone' => '01712-345678',
            'role' => 'admin',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Kamrul Ahsan',
            'email' => 'kamrul@jubounnayon.com',
            'phone' => '01712-998877',
            'role' => 'student',
            'student_roll' => 'NYD-2026-1042',
            'password' => Hash::make('password123'),
        ]);

        // 2. Courses
        $courses = [
            [
                'slug' => 'computer-office-application-graphic-design',
                'title' => 'Computer Office Application & Graphic Design',
                'category' => 'ICT & Digital Engineering',
                'category_slug' => 'ict-digital',
                'duration' => '3 Months (360 Hours)',
                'seats' => 30,
                'fee' => 'BDT 1,000 (Govt Subsidized)',
                'level' => 'Beginner to Advanced',
                'badge' => 'Most Popular',
                'featured' => true,
                'image' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?q=80&w=1200&auto=format&fit=crop',
                'overview' => 'Master word processing, advanced spreadsheets, digital presentations, database management, and foundational Adobe Photoshop & Illustrator. Designed for office executives and freelancers.',
                'prerequisites' => 'Minimum SSC or Equivalent (Any Group)',
                'certification' => 'Government Recognized Technical Diploma Certificate',
                'curriculum' => [
                    ['title' => 'Module 1: Computer Fundamentals & Fast Typing', 'topics' => ['Hardware architecture & Windows OS', 'Touch typing English (30+ WPM) & Bangla Bijoy/Avro (20+ WPM)', 'Cloud storage & security protocols']],
                    ['title' => 'Module 2: Advanced MS Office Productivity Suite', 'topics' => ['MS Word: Official letters, mail merge & tables', 'MS Excel: VLOOKUP, Pivot Tables & accounting formulas', 'MS Access: Database creation & query reports']],
                    ['title' => 'Module 3: Digital Graphic Design & Adobe Suite', 'topics' => ['Adobe Photoshop: Photo retouching & clipping path', 'Adobe Illustrator: Vector logos, banners & brochures', 'Color theory CMYK vs RGB for print & digital']],
                    ['title' => 'Module 4: Online Marketplace & Freelancing', 'topics' => ['Upwork & Fiverr profile setup', 'International payments & bank withdrawals']]
                ]
            ],
            [
                'slug' => 'electrical-house-wiring-industrial-automation',
                'title' => 'Electrical House Wiring & Industrial Automation',
                'category' => 'Electrical & Power Technology',
                'category_slug' => 'electrical-power',
                'duration' => '6 Months (720 Hours)',
                'seats' => 25,
                'fee' => 'Free (Govt Scholarship)',
                'level' => 'Practical Trade Course',
                'badge' => 'High Employment',
                'featured' => true,
                'image' => 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?q=80&w=1200&auto=format&fit=crop',
                'overview' => 'Hands-on domestic single & three-phase wiring, circuit breaker sizing, earthing systems, generator synchronization, and industrial motor control wiring.',
                'prerequisites' => 'Minimum Class 8 / JSC / SSC Pass',
                'certification' => 'BTEB & Directorate Certified Electrical License A/B/C Eligible',
                'curriculum' => [
                    ['title' => 'Module 1: Electrical Fundamentals & Workshop Safety', 'topics' => ['Ohms law & multimeter measurements', 'Personal Protective Equipment (PPE) & safety protocols']],
                    ['title' => 'Module 2: Residential House Wiring', 'topics' => ['Conduit pipe laying & DB board installation', 'Switch, socket, fan & energy meter connections']],
                    ['title' => 'Module 3: Industrial Motor & Magnetic Contactor', 'topics' => ['DOL starter, Star-Delta starter circuits', 'Overload thermal relays & reverse-forward wiring']],
                    ['title' => 'Module 4: Substation, Generator & Solar PV', 'topics' => ['Automatic Transfer Switch (ATS)', 'Solar panel inverter installation & earthing']]
                ]
            ],
            [
                'slug' => 'refrigeration-air-conditioning-servicing',
                'title' => 'Refrigeration & Air Conditioning (RAC / HVAC) Servicing',
                'category' => 'Mechanical & Climate Engineering',
                'category_slug' => 'mechanical-climate',
                'duration' => '3 Months (360 Hours)',
                'seats' => 20,
                'fee' => 'BDT 1,500',
                'level' => 'Technician Diploma',
                'badge' => 'Overseas Job Demand',
                'featured' => true,
                'image' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?q=80&w=1200&auto=format&fit=crop',
                'overview' => 'In-depth diagnostic training on domestic refrigerators, inverter split AC, gas charging (R32, R410A, R600a), brazing, vacuuming, and PCB card troubleshooting.',
                'prerequisites' => 'Minimum SSC or Technical Trade Pass',
                'certification' => 'National Skills Standard (NSS-2) RAC Technician Certificate',
                'curriculum' => [
                    ['title' => 'Module 1: Refrigeration Cycle & Thermodynamics', 'topics' => ['Compressor, Condenser, Capillary tube & Evaporator mechanics', 'Eco-friendly refrigerants and ozone safety']],
                    ['title' => 'Module 2: Copper Pipe Brazing & Flushing', 'topics' => ['Oxy-acetylene torch operation & copper tube bending', 'System nitrogen pressure testing and leak detection']],
                    ['title' => 'Module 3: Inverter Split AC Installation & Commissioning', 'topics' => ['Wall bracket mounting & flare nut connecting', 'Digital vacuum pump & electronic weighing scale charging']],
                    ['title' => 'Module 4: Inverter AC PCB & Electrical Fault Finding', 'topics' => ['BLDC fan motor test & temperature sensor calibration', 'Error code reading & circuit board replacement']]
                ]
            ],
            [
                'slug' => 'certified-electric-gas-welding-technology',
                'title' => 'Certified Electric Arc & Gas Welding Technology',
                'category' => 'Welding & Heavy Fabrication',
                'category_slug' => 'welding-fabrication',
                'duration' => '3 Months (360 Hours)',
                'seats' => 20,
                'fee' => 'Free (Stipend Provided)',
                'level' => 'Industrial Trade',
                'badge' => 'Export Industry Ready',
                'featured' => false,
                'image' => 'https://images.unsplash.com/photo-1504917599217-d4dc5ebe6122?q=80&w=1200&auto=format&fit=crop',
                'overview' => 'Shielded Metal Arc Welding (SMAW 1G to 4G), Oxy-Acetylene gas cutting, TIG/MIG fundamentals, metal joint preparation, and industrial safety compliance.',
                'prerequisites' => 'Minimum Class 8 / JSC Pass',
                'certification' => 'AWS Standard Structural Welder Certification',
                'curriculum' => [
                    ['title' => 'Module 1: Metallurgy & Joint Preparation', 'topics' => ['Metal properties, beveling & grinding techniques', 'Flame regulation (Neutral, Carburizing, Oxidizing)']],
                    ['title' => 'Module 2: SMAW Arc Welding Positions', 'topics' => ['1G Flat, 2G Horizontal, 3G Vertical-up root passes', 'Electrode selection E6013, E7018 & current setting']]
                ]
            ],
            [
                'slug' => 'professional-hotel-culinary-management',
                'title' => 'Professional Culinary Arts & Food Safety (F&B)',
                'category' => 'Hospitality & Tourism',
                'category_slug' => 'hospitality-tourism',
                'duration' => '3 Months (360 Hours)',
                'seats' => 25,
                'fee' => 'BDT 2,500',
                'level' => 'Vocational Diploma',
                'badge' => '5-Star Hotel Internship',
                'featured' => false,
                'image' => 'https://images.unsplash.com/photo-1556910103-1c02745aae4d?q=80&w=1200&auto=format&fit=crop',
                'overview' => 'Hygiene standards (HACCP), knife skills, Continental, Oriental, and traditional Bengali cuisine preparation, bakery fundamentals, and banquet service management.',
                'prerequisites' => 'Minimum SSC or Equivalent',
                'certification' => 'International Culinary & Hospitality Guild Certification',
                'curriculum' => [
                    ['title' => 'Module 1: Kitchen Hygiene & Knife Mastery', 'topics' => ['HACCP critical control points & cross-contamination', 'Julienne, Brunoise, Chiffonade precision knife cuts']],
                    ['title' => 'Module 2: Continental & Oriental Cuisine', 'topics' => ['Mother sauces, roasting, poaching & sauteing', 'Dim sum, fried rice, wok mastery & food presentation']]
                ]
            ],
            [
                'slug' => 'commercial-dairy-poultry-farm-entrepreneurship',
                'title' => 'Modern Dairy, Poultry & Agro-Farming Entrepreneurship',
                'category' => 'Agriculture & Livestock Development',
                'category_slug' => 'agriculture-livestock',
                'duration' => '2 Months (240 Hours)',
                'seats' => 30,
                'fee' => 'Free (Govt Seed Grant Eligible)',
                'level' => 'Self-Employment Course',
                'badge' => 'Youth Loan Eligible',
                'featured' => false,
                'image' => 'https://images.unsplash.com/photo-1500595046743-cd271d694d30?q=80&w=1200&auto=format&fit=crop',
                'overview' => 'Scientific cattle breed selection, balanced feed formulation, vaccination schedules, bio-secure shed construction, egg incubation, and agro-business bank loan documentation.',
                'prerequisites' => 'Open to All Literate Youths (Literacy Required)',
                'certification' => 'Department of Livestock & Youth Development Certificate',
                'curriculum' => [
                    ['title' => 'Module 1: Cattle & Poultry Breed Selection', 'topics' => ['Holstein Friesian, Sahiwal, Sonali & Broiler strains', 'Biosecurity shed ventilation & waste bio-gas utilization']],
                    ['title' => 'Module 2: Veterinary Care & Commercial Marketing', 'topics' => ['Vaccine administration & disease outbreak prevention', 'Milk chilling chain, egg packaging & direct market supply']]
                ]
            ],
        ];

        foreach ($courses as $c) {
            Course::create($c);
        }

        // 3. Student Results
        $results = [
            [
                'roll_no' => 'NYD-2026-1042',
                'reg_no' => 'REG-NYD-78901',
                'student_name' => 'Kamrul Ahsan',
                'father_name' => 'Md. Rafiqul Islam',
                'mother_name' => 'Rokeya Begum',
                'session' => 'January - June 2026',
                'trade' => 'Computer Office Application & Graphic Design',
                'center' => 'Regional Youth Development Complex, Mirpur, Dhaka',
                'institute_name' => 'Saikat Computer & Training Jubo Songhoton',
                'exam_year' => '2026',
                'issue_date' => '05 November 2026',
                'gpa' => 3.92,
                'grade' => 'A+',
                'verification_status' => 'VERIFIED & AUTHENTIC',
                'qr_url' => 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=NYD-2026-1042-VERIFIED-KAMRUL-AHSAN',
                'marks' => [
                    ['subject' => 'Computer Fundamentals & OS', 'fullMarks' => 100, 'obtained' => 92, 'grade' => 'A+'],
                    ['subject' => 'MS Office Applications (Word, Excel, Access)', 'fullMarks' => 100, 'obtained' => 95, 'grade' => 'A+'],
                    ['subject' => 'Digital Graphics (Photoshop & Illustrator)', 'fullMarks' => 100, 'obtained' => 88, 'grade' => 'A+'],
                    ['subject' => 'Speed Typing & Practical Viva Voce', 'fullMarks' => 100, 'obtained' => 90, 'grade' => 'A+'],
                    ['subject' => 'Industrial Project & Freelance Portfolio', 'fullMarks' => 100, 'obtained' => 89, 'grade' => 'A+'],
                ]
            ],
            [
                'roll_no' => 'NYD-2026-1088',
                'reg_no' => 'REG-NYD-78945',
                'student_name' => 'Nusrat Jahan Tanha',
                'father_name' => 'Abul Kashem',
                'mother_name' => 'Nasreen Sultana',
                'session' => 'January - June 2026',
                'trade' => 'Computer Office Application & Graphic Design',
                'center' => 'Chittagong Divisional Youth Training Center',
                'institute_name' => 'Saikat Computer & Training Jubo Songhoton',
                'exam_year' => '2026',
                'issue_date' => '05 November 2026',
                'gpa' => 4.00,
                'grade' => 'A+',
                'verification_status' => 'VERIFIED & AUTHENTIC',
                'qr_url' => 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=NYD-2026-1088-VERIFIED-NUSRAT-JAHAN',
                'marks' => [
                    ['subject' => 'Computer Fundamentals & OS', 'fullMarks' => 100, 'obtained' => 96, 'grade' => 'A+'],
                    ['subject' => 'MS Office Applications (Word, Excel, Access)', 'fullMarks' => 100, 'obtained' => 98, 'grade' => 'A+'],
                    ['subject' => 'Digital Graphics (Photoshop & Illustrator)', 'fullMarks' => 100, 'obtained' => 94, 'grade' => 'A+'],
                    ['subject' => 'Speed Typing & Practical Viva Voce', 'fullMarks' => 100, 'obtained' => 97, 'grade' => 'A+'],
                    ['subject' => 'Industrial Project & Freelance Portfolio', 'fullMarks' => 100, 'obtained' => 95, 'grade' => 'A+'],
                ]
            ],
            [
                'roll_no' => 'NYD-2026-1120',
                'reg_no' => 'REG-NYD-79012',
                'student_name' => 'Md. Shakil Hossain',
                'father_name' => 'Fazlur Rahman',
                'mother_name' => 'Shamsun Nahar',
                'session' => 'January - June 2026',
                'trade' => 'Electrical House Wiring & Industrial Automation',
                'center' => 'Rajshahi Technical Vocational Training Campus',
                'institute_name' => 'Saikat Computer & Training Jubo Songhoton',
                'exam_year' => '2026',
                'issue_date' => '05 November 2026',
                'gpa' => 3.85,
                'grade' => 'A',
                'verification_status' => 'VERIFIED & AUTHENTIC',
                'qr_url' => 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=NYD-2026-1120-VERIFIED-MD-SHAKIL',
                'marks' => [
                    ['subject' => 'Electrical Principles & Circuit Theory', 'fullMarks' => 100, 'obtained' => 86, 'grade' => 'A'],
                    ['subject' => 'Domestic House Wiring & Earthing', 'fullMarks' => 100, 'obtained' => 92, 'grade' => 'A+'],
                    ['subject' => 'Industrial Motor Control & Starter Circuits', 'fullMarks' => 100, 'obtained' => 84, 'grade' => 'A'],
                    ['subject' => 'Safety, Tools Handling & Viva', 'fullMarks' => 100, 'obtained' => 90, 'grade' => 'A+'],
                ]
            ],
            [
                'roll_no' => 'NYD-2026-1155',
                'reg_no' => 'REG-NYD-79104',
                'student_name' => 'Tanvir Ahmed Shanto',
                'father_name' => 'Zillur Rahman',
                'mother_name' => 'Farida Yasmin',
                'session' => 'January - June 2026',
                'trade' => 'Refrigeration & Air Conditioning Servicing',
                'center' => 'Khulna Vocational Workshop Complex',
                'institute_name' => 'Saikat Computer & Training Jubo Songhoton',
                'exam_year' => '2026',
                'issue_date' => '05 November 2026',
                'gpa' => 3.78,
                'grade' => 'A',
                'verification_status' => 'VERIFIED & AUTHENTIC',
                'qr_url' => 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=NYD-2026-1155-VERIFIED-TANVIR-AHMED',
                'marks' => [
                    ['subject' => 'Thermodynamics & Refrigeration Principles', 'fullMarks' => 100, 'obtained' => 82, 'grade' => 'A'],
                    ['subject' => 'Inverter Split AC Installation & Brazing', 'fullMarks' => 100, 'obtained' => 90, 'grade' => 'A+'],
                    ['subject' => 'Refrigerant Recovery, Leak Testing & Vacuuming', 'fullMarks' => 100, 'obtained' => 88, 'grade' => 'A+'],
                    ['subject' => 'PCB Diagnostic & Viva Voce', 'fullMarks' => 100, 'obtained' => 85, 'grade' => 'A'],
                ]
            ],
            [
                'roll_no' => 'NYD-2026-1210',
                'reg_no' => 'REG-NYD-79220',
                'student_name' => 'Sabina Yeasmin',
                'father_name' => 'Moksed Ali',
                'mother_name' => 'Hamida Khatun',
                'session' => 'January - June 2026',
                'trade' => 'Professional Culinary Arts & Food Safety (F&B)',
                'center' => 'Sylhet Hospitality & Tourism Skill Institute',
                'institute_name' => 'Saikat Computer & Training Jubo Songhoton',
                'exam_year' => '2026',
                'issue_date' => '05 November 2026',
                'gpa' => 3.95,
                'grade' => 'A+',
                'verification_status' => 'VERIFIED & AUTHENTIC',
                'qr_url' => 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=NYD-2026-1210-VERIFIED-SABINA-YEASMIN',
                'marks' => [
                    ['subject' => 'HACCP Food Safety & Kitchen Sanitation', 'fullMarks' => 100, 'obtained' => 96, 'grade' => 'A+'],
                    ['subject' => 'Continental & Oriental Culinary Preparation', 'fullMarks' => 100, 'obtained' => 94, 'grade' => 'A+'],
                    ['subject' => 'Pastry, Bakery & Beverage Management', 'fullMarks' => 100, 'obtained' => 92, 'grade' => 'A+'],
                    ['subject' => 'Food Plating, Service Etiquette & Viva', 'fullMarks' => 100, 'obtained' => 95, 'grade' => 'A+'],
                ]
            ],
        ];

        foreach ($results as $r) {
            StudentResult::create($r);
        }

        // 4. Resources
        $resources = [
            ['title' => 'Academic Session 2026 Final Examination Routine & Practical Guidelines', 'category' => 'Notices', 'file_size' => '1.4 MB', 'file_type' => 'PDF', 'download_url' => '#'],
            ['title' => 'Government Subsidized Technical Training Admission Circular (Session 2026-27)', 'category' => 'Notices', 'file_size' => '2.1 MB', 'file_type' => 'PDF', 'download_url' => '#'],
            ['title' => 'Computer Office Applications & Database Curriculum Syllabus (360 Hours)', 'category' => 'Syllabus', 'file_size' => '3.8 MB', 'file_type' => 'PDF', 'download_url' => '#'],
            ['title' => 'Professional Graphic Design & Multimedia Complete Learning Syllabus', 'category' => 'Syllabus', 'file_size' => '4.2 MB', 'file_type' => 'PDF', 'download_url' => '#'],
            ['title' => 'Electrical House Wiring & Industrial Motor Practical Workshop Manual', 'category' => 'Books', 'file_size' => '6.5 MB', 'file_type' => 'PDF', 'download_url' => '#'],
            ['title' => 'Refrigeration & Air Conditioning (RAC / HVAC) Diagnostic Handbook', 'category' => 'Books', 'file_size' => '5.9 MB', 'file_type' => 'PDF', 'download_url' => '#'],
            ['title' => 'Trainee Offline Admission & Identity Verification Form', 'category' => 'Forms', 'file_size' => '850 KB', 'file_type' => 'DOCX', 'download_url' => '#'],
            ['title' => 'Certificate & Marksheet Name / Information Correction Petition Form', 'category' => 'Forms', 'file_size' => '620 KB', 'file_type' => 'PDF', 'download_url' => '#'],
            ['title' => 'New Branch Center Affiliation & Lab Inspection Application Dossier', 'category' => 'Forms', 'file_size' => '1.1 MB', 'file_type' => 'PDF', 'download_url' => '#'],
            ['title' => 'Technical Trade Question Bank & Viva Prep Archive (2020-2025)', 'category' => 'Question Bank', 'file_size' => '7.8 MB', 'file_type' => 'ZIP', 'download_url' => '#'],
            ['title' => 'Global ICT Freelancing & Online Remittance Handbook', 'category' => 'Books', 'file_size' => '4.1 MB', 'file_type' => 'PDF', 'download_url' => '#'],
        ];

        foreach ($resources as $res) {
            Resource::create($res);
        }

        // 5. Gallery Items
        $gallery = [
            ['title' => 'Interactive Computer Lab & Database Workstations', 'category' => 'Lab', 'image_url' => '/images/gallery-1.jpg', 'caption' => 'High-performance computing lab with 50+ modern Core-i7 workstations and licensed design software.'],
            ['title' => 'Electrical House Wiring & Motor Installation Lab', 'category' => 'Lab', 'image_url' => '/images/gallery-2.jpg', 'caption' => 'Hands-on domestic single & three-phase wiring boards and motor control testing rigs.'],
            ['title' => 'Refrigeration, HVAC & Mechanical Workshop', 'category' => 'Lab', 'image_url' => '/images/gallery-4.jpg', 'caption' => 'Inverter AC vacuuming, gas charging, and pipe brazing practical session with certified instructors.'],
            ['title' => 'National Youth Skill Day Convocation & Certificate Ceremony', 'category' => 'Convocation', 'image_url' => '/images/gallery-5.jpg', 'caption' => 'Graduates receiving government certified technical diplomas at the annual youth festival.'],
            ['title' => 'Industrial Sewing, Tailoring & Women Empowerment Lab', 'category' => 'Class', 'image_url' => '/images/gallery-6.jpg', 'caption' => 'Vocational training batch for female trainees with modern computerized sewing machines.'],
            ['title' => 'Women in Tech: Digital Literacy & Freelancing Batch', 'category' => 'Events', 'image_url' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?q=80&w=1200&auto=format&fit=crop', 'caption' => 'Dedicated freelancing mentorship seminar connecting successful remote freelancers with new graduates.'],
        ];

        foreach ($gallery as $g) {
            GalleryItem::create($g);
        }

        // 6. Admissions
        $admissions = [
            [
                'full_name' => 'Kamrul Ahsan',
                'phone' => '01712-998877',
                'email' => 'kamrul@gmail.com',
                'trade' => 'Computer Office Application & Graphic Design',
                'district' => 'Dhaka',
                'status' => 'Approved',
                'assigned_roll' => 'NYD-2026-1042',
                'notes' => 'Admission fee paid and verified.'
            ],
            [
                'full_name' => 'Farhana Akter Rima',
                'phone' => '01819-334455',
                'email' => 'farhana.rima@yahoo.com',
                'trade' => 'Professional Culinary Arts & Food Safety (F&B)',
                'district' => 'Chattogram',
                'status' => 'Pending',
                'assigned_roll' => null,
                'notes' => 'Applied online. Awaiting document verification.'
            ],
            [
                'full_name' => 'Mehedi Hasan Sourav',
                'phone' => '01911-667788',
                'email' => 'mehedi.sourav@outlook.com',
                'trade' => 'Electrical House Wiring & Industrial Automation',
                'district' => 'Rajshahi',
                'status' => 'Approved',
                'assigned_roll' => 'NYD-2026-1120',
                'notes' => 'SSC Certificate verified.'
            ],
            [
                'full_name' => 'Sabbir Hossain',
                'phone' => '01622-445566',
                'email' => 'sabbir@gmail.com',
                'trade' => 'Refrigeration & Air Conditioning Servicing',
                'district' => 'Bogura',
                'status' => 'Pending',
                'assigned_roll' => null,
                'notes' => 'Awaiting photo verification.'
            ],
        ];

        foreach ($admissions as $adm) {
            Admission::create($adm);
        }

        // 7. Contact Inquiries
        $inquiries = [
            [
                'name' => 'Abdul Alim',
                'phone' => '01711-223344',
                'email' => 'abdul.alim@gmail.com',
                'district' => 'Gazipur',
                'inquiry_type' => 'Course Admission',
                'message' => 'I would like to enroll in the upcoming Electrical House Wiring weekend batch. Are seats still available?',
                'status' => 'New'
            ],
            [
                'name' => 'Sharmin Sultana',
                'phone' => '01822-556677',
                'email' => 'sharmin.s@yahoo.com',
                'district' => 'Narayanganj',
                'inquiry_type' => 'Certificate Verification',
                'message' => 'My certificate has a minor spelling error in my mother’s name. How can I apply for an official correction?',
                'status' => 'Replied'
            ],
            [
                'name' => 'Mohiuddin Bablu',
                'phone' => '01933-778899',
                'email' => 'bablu@outlook.com',
                'district' => 'Cumilla',
                'inquiry_type' => 'Center Affiliation',
                'message' => 'We operate a computer training center in Cumilla and wish to apply for national youth platform affiliation.',
                'status' => 'New'
            ],
        ];

        foreach ($inquiries as $inq) {
            ContactInquiry::create($inq);
        }

        // 8. Site Settings
        $settings = [
            'tickerText' => '২০২৬ সেশনের কারিগরি ও আইসিটি প্রশিক্ষণ কোর্সে ভর্তি চলছে | আবেদন জমা দেওয়ার শেষ তারিখ ১৫ ডিসেম্বর ২০২৬ | ফলাফল ও সনদ অনলাইনে যাচাই করা যাচ্ছে।',
            'urgentNoticeEnabled' => '1',
            'emergencyNoticeText' => 'জাতীয় যুব উন্নয়ন অধিদপ্তর ও কারিগরি শিক্ষা বোর্ড অনুমোদিত ডিপ্লোমা সনদ বিতরণ আগামী সপ্তাহে শুরু হবে।',
            'emergencyNoticeLink' => '/results',
            'helplinePhone' => '+880 1712-345678',
            'helplineEmail' => 'support@jubounnayon.com',
            'currentSession' => 'January - June 2026',
            'instituteName' => 'Saikat Computer & Training Jubo Songhoton',
            'platformTitle' => 'National Youth Development Training Platform',
        ];

        foreach ($settings as $key => $val) {
            SiteSetting::set($key, $val);
        }
    }
}
