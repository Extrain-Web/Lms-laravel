import { useState } from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, router, useForm } from "@inertiajs/react";
import {
    Inbox,
    Package,
    Home,
    LayoutTemplate,
    Sparkles,
    PhoneCall,
    Trash2,
    ExternalLink,
    Eye,
    EyeOff,
    Plus,
    Save,
    Image as ImageIcon,
    Info,
} from "lucide-react";

// ডিফল্ট FAQs
const defaultFaqs = [
    {
        question: "What makes Pure Sip drinks 100% natural and unique?",
        answer: "Our drinks are crafted directly from cold-extracted garden mint, raw fruits, ginger, and Ayurvedic spices like cumin and black pepper. We use zero artificial colors, synthetic flavors, or chemical preservatives.",
    },
    {
        question: "How should I store the pouches and what is the shelf life?",
        answer: "Pure Sip pouches are best enjoyed chilled. Keep them refrigerated (2°C - 5°C) to maintain maximum botanical freshness. Since we do not add harsh preservatives, consume within 10 to 14 days of manufacturing.",
    },
    {
        question: "Are these drinks safe for children and daily digestion?",
        answer: "Yes, absolutely. All ingredients—such as fresh lemon, cumin, and ginger—are traditional natural foods that support gut health, alleviate acidity after heavy meals, and keep the whole family hydrated.",
    },
    {
        question:
            "How is it possible to offer premium botanical drinks at only Tk 10?",
        answer: "By sourcing herbs directly from regional farmers and utilizing lightweight, food-grade eco-pouches instead of costly heavy glass bottles, we pass the cost savings directly to our consumers.",
    },
    {
        question:
            "How can I order in bulk for events or apply for wholesale dealership?",
        answer: "For retail supply, restaurant partnerships, or wedding/event bulk orders, please call our direct hotline at 01306-312372 / 018265-813373 or reach out via WhatsApp.",
    },
];

// ডিফল্ট টেস্টমোনিয়ালস
const defaultReviews = [
    {
        id: 1,
        name: "Tanvir Ahmed",
        location: "Dhanmondi, Dhaka",
        role: "Verified Sipper",
        drink: "Hozmi Cola (Digestive)",
        rating: 5,
        feedback:
            "Hozmi Cola is an absolute lifesaver after heavy biryani dinners! The real cumin and ginger blend relieves bloating within minutes. Unbeatable quality at just Tk 10.",
    },
    {
        id: 2,
        name: "Nusrat Jahan",
        location: "Sylhet Sadar",
        role: "Clinical Nutritionist",
        drink: "Pudina Drink (Cool Mint)",
        rating: 5,
        feedback:
            "The combination of fresh raw mango and crushed Sylhet mint gives an instant energy boost during intense summer heat. Love that there are zero artificial preservatives!",
    },
    {
        id: 3,
        name: "Farhan Kabir",
        location: "Chittagong",
        role: "Retail Partner",
        drink: "Assorted 6-Pack",
        rating: 5,
        feedback:
            "The chilled pouch packaging is extremely convenient and customers keep coming back for more every day. Authentic traditional taste in a modern, hygienic pack.",
    },
    {
        id: 4,
        name: "Sadia Rahman",
        location: "Gulshan, Dhaka",
        role: "University Student",
        drink: "Citrus Boost",
        rating: 5,
        feedback:
            "So refreshing! It replaced synthetic energy sodas for me during exam weeks. Natural citrus flavor without any excessive artificial sweetness.",
    },
];

export default function Dashboard({
    auth,
    inquiries = [],
    products = [],
    settings = {},
    stats = {},
}) {
    const [activeSection, setActiveSection] = useState("leads");
    const [homeTab, setHomeTab] = useState("hero");
    const [showAddProductModal, setShowAddProductModal] = useState(false);
    const [editingProduct, setEditingProduct] = useState(null);

    // ১. হেডার ও লোগো ফর্ম
    const headerForm = useForm({
        brand_name: settings.brand_name || "Pure Sip",
        header_phone: settings.header_phone || "01306-312372",
        logo_type: "url",
        logo_url: settings.logo || "",
        logo_file: null,
    });

    // ২. হোম পেজ: ব্যানার ফর্ম
    const bannerForm = useForm({
        banner_title:
            settings.banner_title || "100% Pure Botanical Refreshment",
        banner_subtitle:
            settings.banner_subtitle ||
            "Handcrafted digestive, cooling & immunity tonics brewed from authentic fruits and herbs.",
        banner_type: "url",
        banner_url: settings.banner_image || "",
        banner_file: null,
    });

    // ৩. হোম পেজ: ৩টি ফিচার কার্ডস স্টেট
    const [cards, setCards] = useState(
        settings.showcase_cards || [
            {
                image: "/images/hozmi-cola.jpeg",
                title: "Digestive Brew",
                hover_text:
                    "Infused with roasted cumin & rock salt for instant gut comfort.",
            },
            {
                image: "/images/pudina-drink.jpeg",
                title: "Cooling Mint",
                hover_text:
                    "Fresh garden mint & raw mango cooler to beat summer heat.",
            },
            {
                image: "/images/tetul-drinks.jpg",
                title: "Citrus Immunity",
                hover_text:
                    "High-potency Vitamin C with Kagoji lemons & ginger root.",
            },
        ],
    );

    // ৪. হোম পেজ: Why Choose Us ফর্ম স্টেট
    const [whyUs, setWhyUs] = useState(
        settings.why_choose_us || {
            badge: "THE PURITY STANDARD",
            title: "Crafted Botanicals.",
            highlight: "Zero Artificial Compromise.",
            subtitle:
                "Cold-extracted garden mint, raw fruits, and digestive spices brewed in small batches for pristine clarity and deep gut vitality.",
            story_title: "Real Botanical Roots for Natural Well-Being",
            story_desc:
                "At Pure Sip Beverage, we believe true refreshment comes directly from the earth. Our small-batch cold blends extract the purest essence of traditional herbs, raw fruits, and authentic spices—bringing you a pure experience without a single drop of chemical additives.",
            stat_1_val: "100%",
            stat_1_label: "Real Botanical Brew",
            stat_2_val: "0g",
            stat_2_label: "Harmful Preservatives",
            stat_3_val: "4.9★",
            stat_3_label: "Over 15,000 Sips",
            story_image: "/images/banner.jpeg",
            features: [
                {
                    title: "100% Botanical Extracts",
                    desc: "Crafted directly from farm-fresh mint, ginger, raw mango, and ancient Ayurvedic spices without synthetic pastes.",
                },
                {
                    title: "Zero Harmful Chemicals",
                    desc: "Strictly free from artificial food colors, toxic preservatives, and synthetic flavoring agents.",
                },
                {
                    title: "Digestive & Gut Vitality",
                    desc: "Formulated to soothe acidity, accelerate digestion after heavy meals, and maintain natural hydration.",
                },
                {
                    title: "Safe Pouch Packaging",
                    desc: "Food-grade, leak-proof, lightweight pouch packaging that locks freshness and is easy to carry anywhere.",
                },
            ],
        },
    );

    // ৫. হোম পেজ: FAQs স্টেট
    const [faqsList, setFaqsList] = useState(
        Array.isArray(settings.home_faqs) && settings.home_faqs.length > 0
            ? settings.home_faqs
            : defaultFaqs,
    );

    // ৬. হোম পেজ: Testimonials স্টেট
    const [reviewsList, setReviewsList] = useState(
        Array.isArray(settings.home_testimonials) &&
            settings.home_testimonials.length > 0
            ? settings.home_testimonials
            : defaultReviews,
    );

    // ৭. এবাউট পেজ স্টেট
    const [aboutData, setAboutData] = useState(
        settings.about_page || {
            badge: "THE PURE SIP STORY",
            title: "Reclaiming Real Taste.",
            highlight: "Born in Bangladesh.",
            desc_1: "For decades, the beverage shelves in our country have been dominated by ultra-processed sodas loaded with synthetic syrup, artificial flavors, and harmful chemicals.",
            desc_2: "Pure Sip Beverage was founded in Dhaka with a clear mission: reviving time-tested South Asian botanicals—from crushed Sylhet mint to roasted cumin and raw mango—into a crisp, hygienic, modern drink that heals the gut while instantly refreshing the body.",
            stat_1_val: "15K+",
            stat_1_label: "Sips Enjoyed",
            stat_2_val: "100%",
            stat_2_label: "Natural Botanical",
            stat_3_val: "Tk 10",
            stat_3_label: "Honest Price",
            hero_image: "/images/banner.jpeg",
            pillars: [
                {
                    title: "100% Native Botanicals",
                    desc: "We work directly with growers to source fragrant garden mint from Sylhet, sun-dried cumin, ginger, and wild raw mangoes.",
                },
                {
                    title: "Zero Chemical Compromise",
                    desc: "Strictly no synthetic food colorings, artificial carbonation syrups, or chemical preservatives. Just raw, living plants.",
                },
                {
                    title: "Radical Accessibility (Tk 10)",
                    desc: "Health should never be a luxury. By skipping costly heavy glass and distributor middlemen, we make pure organic wellness accessible to all.",
                },
                {
                    title: "Small-Batch Cold Craft",
                    desc: "Cold-extracted in controlled small batches in Dhaka to preserve vital enzymes, micronutrients, and delicate aromatic oils.",
                },
            ],
            timeline: [
                {
                    step: "01",
                    title: "Direct Regional Sourcing",
                    desc: "We pick fresh mint leaves, ginger roots, and seasonal green fruits at peak ripeness directly from local farmers.",
                },
                {
                    step: "02",
                    title: "Gentle Cold Infusion",
                    desc: "No heat destruction. Ingredients are cold-crushed and slow-steeped with Ayurvedic digestive spices to lock in aroma and health benefits.",
                },
                {
                    step: "03",
                    title: "Hygienic Cold Pouching",
                    desc: "Packaged inside sterile, multi-layer food-grade pouches that block UV light and lock in crisp chilled freshness.",
                },
                {
                    step: "04",
                    title: "Direct Cold-Chain Supply",
                    desc: "Dispatched chilled to local shops, eateries, and doorsteps across Dhaka within 24 hours of brewing.",
                },
            ],
        },
    );

    // ৮. Our Drinks পেজ স্টেট
    const [ourDrinksData, setOurDrinksData] = useState(
        settings.our_drinks_page || {
            badge: "100% BOTANICAL LINEUP",
            title: "Crafted for Taste.",
            highlight: "Brewed for Well-Being.",
            subtitle:
                "Explore our handcrafted lineup of cold-extracted botanical juices. Made with raw fruits, garden mint, and Ayurvedic spices—every pouch strictly priced at just Tk 10.",
            categories: [
                { id: "all", label: "All Drinks" },
                { id: "digestive", label: "Digestive & Gut" },
                { id: "refreshing", label: "Cooling & Tangy" },
                { id: "immunity", label: "Immunity Boost" },
            ],
        },
    );

    // Contact Us Page স্টেট (ব্যাকএন্ডের নামগুলোর সাথে মিল রেখে ঠিক করা হলো)
    const [contactPageData, setContactPageData] = useState(
        settings.contact_page || {
            badge: "LET'S CONNECT",
            title: "Get in Touch with",
            highlight: "Pure Sip Beverage",
            subtitle:
                "Have questions about our botanical formulas, want to stock our Tk 10 pouches at your shop, or planning bulk orders for events? We are here to help.",
            address_title: "Production & Office",
            email: "info@puresipbeverage.com",
            address_desc: "Pure Sip Beverage, Dhaka, Bangladesh",
            hours: "Saturday – Thursday: 9:00 AM – 8:00 PM",
            wholesale_banner_title: "Looking for Wholesale Supply in Dhaka?",
            wholesale_banner_desc:
                "We supply insulated, chilled batches directly to grocery stores, restaurants, and eateries within 24 hours.",
            primary_phone: "+8801873044692",
            dealership_phone: "018265-813373",
            whatsapp_phone: "+8801873044692",
        },
    );

    // ৯. কন্টাক্ট ও ফুটার ফর্ম
    const contactForm = useForm({
        phone_primary: settings.phone_primary ?? "01306-312372",
        phone_secondary: settings.phone_secondary ?? "",
        whatsapp_number: settings.whatsapp_number ?? "+8801306312372",
        email: settings.email ?? "info@puresipbeverage.com",
        address: settings.address ?? "Pure Sip Beverage, Dhaka, Bangladesh",
        footer_settings: {
            wholesale_badge:
                settings.footer_settings?.wholesale_badge ||
                "Wholesale & Instant Order",
            wholesale_title:
                settings.footer_settings?.wholesale_title ||
                "Scan or Call to Order in Bulk",
            wholesale_desc:
                settings.footer_settings?.wholesale_desc ||
                "Looking to stock our 10 Tk chilled botanical pouches at your shop or need bulk orders for events? Scan the QR code or call our direct helpline.",
            qr_image:
                settings.footer_settings?.qr_image || "/images/qr-code.jpeg",
            qr_badge: settings.footer_settings?.qr_badge || "BSTI Certified",
            qr_title: settings.footer_settings?.qr_title || "Scan to Verify",
            qr_desc:
                settings.footer_settings?.qr_desc ||
                "Official BSTI Approval & Lab Quality Certificate",
            bio:
                settings.footer_settings?.bio ||
                "Natural botanical drinks crafted from cold-extracted mint, ginger, raw mango, and ancient spices for pristine digestion and pure everyday vitality.",
            facebook_url: settings.footer_settings?.facebook_url || "",
            instagram_url: settings.footer_settings?.instagram_url || "",
            youtube_url: settings.footer_settings?.youtube_url || "",
            tiktok_url: settings.footer_settings?.tiktok_url || "",
            linkedin_url: settings.footer_settings?.linkedin_url || "",
            twitter_url: settings.footer_settings?.twitter_url || "",
            signature_blends: settings.footer_settings?.signature_blends || [
                { name: "Hozmi Cola (Digestive)", url: "/products/hozmi-cola" },
                {
                    name: "Pudina Drink (Cool Mint)",
                    url: "/products/pudina-drink",
                },
                {
                    name: "Citrus Boost (Vitamin C)",
                    url: "/products/citrus-boost",
                },
                { name: "Green Detox (Cleanse)", url: "/products/green-detox" },
            ],
        },
        qr_file: null,
    });

    // ১০. নতুন প্রোডাক্ট ফর্ম
    const productForm = useForm({
        name: "",
        tagline: "",
        price: "Tk 10",
        net_volume: "200ml",
        category: "digestive",
        ingredients: "",
        short_description: "",
        manufacturer: "Pure Sip Beverage",
        storage: "Keep in Refrigerator",
        helpline: "01306-312372",
        image_type: "url",
        image_url: "",
        image_file: null,
    });

    // ১১. প্রোডাক্ট এডিট ফর্ম
    const editProductForm = useForm({
        name: "",
        tagline: "",
        price: "Tk 10",
        net_volume: "200ml",
        category: "digestive",
        ingredients: "",
        short_description: "",
        manufacturer: "Pure Sip Beverage",
        storage: "Keep in Refrigerator",
        helpline: "01306-312372",
        image_type: "url",
        image_url: "",
        image_file: null,
    });

    const openEditModal = (prod) => {
        setEditingProduct(prod);
        const ingStr = Array.isArray(prod.ingredients)
            ? prod.ingredients
                  .map((i) => (typeof i === "string" ? i : i.name))
                  .join(", ")
            : "";

        editProductForm.setData({
            name: prod.name || "",
            tagline: prod.tagline || "",
            price: prod.price || "Tk 10",
            net_volume: prod.net_volume || "200ml",
            category: prod.category || "digestive",
            ingredients: ingStr,
            short_description: prod.short_description || "",
            manufacturer: prod.manufacturer || "Pure Sip Beverage",
            storage: prod.storage || "Keep in Refrigerator",
            helpline: prod.helpline || "01306-312372",
            image_type: "url",
            image_url: prod.image || "",
            image_file: null,
        });
    };

    const submitEditProduct = (e) => {
        e.preventDefault();
        editProductForm.post(`/admin/products/${editingProduct.id}`, {
            preserveScroll: true,
            forceFormData: true,
            onSuccess: () => {
                setEditingProduct(null);
                alert("Drink updated successfully!");
            },
        });
    };

    // সাবমিট হ্যান্ডলারসমূহ
    const submitHeader = (e) => {
        e.preventDefault();
        headerForm.post("/admin/settings", {
            preserveScroll: true,
            forceFormData: true,
            onSuccess: () => alert("Header & Logo updated successfully!"),
        });
    };

    const submitBanner = (e) => {
        e.preventDefault();
        bannerForm.post("/admin/settings", {
            preserveScroll: true,
            forceFormData: true,
            onSuccess: () => alert("Hero Banner updated successfully!"),
        });
    };

    const submitCards = (e) => {
        e.preventDefault();
        router.post(
            "/admin/settings",
            { showcase_cards: cards },
            {
                preserveScroll: true,
                onSuccess: () => alert("Feature Cards updated successfully!"),
            },
        );
    };

    const submitWhyUs = (e) => {
        e.preventDefault();
        router.post(
            "/admin/settings",
            { why_choose_us: whyUs },
            {
                preserveScroll: true,
                onSuccess: () =>
                    alert("Why Choose Us section updated successfully!"),
            },
        );
    };

    const submitFaqs = (e) => {
        e.preventDefault();
        router.post(
            "/admin/settings",
            { home_faqs: faqsList },
            {
                preserveScroll: true,
                onSuccess: () => alert("FAQs updated successfully!"),
            },
        );
    };

    const submitReviews = (e) => {
        e.preventDefault();
        router.post(
            "/admin/settings",
            { home_testimonials: reviewsList },
            {
                preserveScroll: true,
                onSuccess: () =>
                    alert("Community Reviews updated successfully!"),
            },
        );
    };

    const submitAbout = (e) => {
        e.preventDefault();
        router.post(
            "/admin/settings",
            { about_page: aboutData },
            {
                preserveScroll: true,
                onSuccess: () => alert("About Us page updated successfully!"),
            },
        );
    };

    const submitOurDrinks = (e) => {
        e.preventDefault();
        router.post(
            "/admin/settings",
            { our_drinks_page: ourDrinksData },
            {
                preserveScroll: true,
                onSuccess: () => alert("Our Drinks page updated successfully!"),
            },
        );
    };

    // Contact Us পেজ সাবমিট হ্যান্ডলার (নতুন যুক্ত করা হয়েছে)
    const submitContactPage = (e) => {
        e.preventDefault();

        // Inertia form use korle ba router.post use korle contact_page key er moddhe contactPageData pathate hobe
        router.post(
            route("admin.settings.update"),
            {
                contact_page: contactPageData,
            },
            {
                preserveScroll: true,
                onSuccess: () => {
                    alert("Contact page settings updated successfully!");
                },
            },
        );
    };

    const submitContact = (e) => {
        e.preventDefault();
        contactForm.post("/admin/settings", {
            preserveScroll: true,
            forceFormData: true,
            onSuccess: () =>
                alert("Footer & Contact lines updated successfully!"),
        });
    };

    const submitNewProduct = (e) => {
        e.preventDefault();
        productForm.post("/admin/products", {
            preserveScroll: true,
            forceFormData: true,
            onSuccess: () => {
                setShowAddProductModal(false);
                productForm.reset();
                alert("New drink added successfully!");
            },
        });
    };

    return (
        <AuthenticatedLayout
            header={
                <div className="flex items-center justify-between">
                    <div>
                        <h2 className="text-xl sm:text-2xl font-black text-[#112318] tracking-tight">
                            Pure Sip CMS Control Hub
                        </h2>
                        <p className="text-xs text-gray-500">
                            Easily update any website section live.
                        </p>
                    </div>
                    <a
                        href="/"
                        target="_blank"
                        rel="noreferrer"
                        className="inline-flex items-center gap-1.5 text-xs font-bold text-[#183928] bg-emerald-100/60 px-4 py-2 rounded-xl hover:bg-emerald-200 transition-all"
                    >
                        <span>Live View</span>
                        <ExternalLink className="w-3.5 h-3.5" />
                    </a>
                </div>
            }
        >
            <Head title="Admin CMS | Pure Sip" />

            <div className="py-8 bg-[#f4faf4] min-h-screen">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                        {/* ================= বামপাশের সাইডবার ================= */}
                        <div className="lg:col-span-3 bg-white rounded-3xl p-4 shadow-sm border border-emerald-900/5 space-y-1">
                            <span className="text-[10px] font-black text-gray-400 uppercase tracking-wider px-3 py-1 block">
                                Core Operations
                            </span>

                            <button
                                onClick={() => setActiveSection("leads")}
                                className={`w-full flex items-center justify-between px-3.5 py-3 rounded-2xl text-xs font-bold transition-all cursor-pointer ${
                                    activeSection === "leads"
                                        ? "bg-[#183928] text-white shadow-sm"
                                        : "text-gray-600 hover:bg-emerald-50 hover:text-[#183928]"
                                }`}
                            >
                                <div className="flex items-center gap-2.5">
                                    <Inbox className="w-4 h-4" />
                                    <span>Customer Leads</span>
                                </div>
                                <span
                                    className={`text-[10px] px-2 py-0.5 rounded-full font-black ${
                                        activeSection === "leads"
                                            ? "bg-white text-[#183928]"
                                            : "bg-emerald-100 text-[#183928]"
                                    }`}
                                >
                                    {inquiries.length}
                                </span>
                            </button>

                            <button
                                onClick={() => setActiveSection("drinks")}
                                className={`w-full flex items-center justify-between px-3.5 py-3 rounded-2xl text-xs font-bold transition-all cursor-pointer ${
                                    activeSection === "drinks"
                                        ? "bg-[#183928] text-white shadow-sm"
                                        : "text-gray-600 hover:bg-emerald-50 hover:text-[#183928]"
                                }`}
                            >
                                <div className="flex items-center gap-2.5">
                                    <Package className="w-4 h-4" />
                                    <span>Drinks Catalog</span>
                                </div>
                                <span
                                    className={`text-[10px] px-2 py-0.5 rounded-full font-black ${
                                        activeSection === "drinks"
                                            ? "bg-white text-[#183928]"
                                            : "bg-gray-100 text-gray-600"
                                    }`}
                                >
                                    {products.length}
                                </span>
                            </button>

                            <span className="text-[10px] font-black text-gray-400 uppercase tracking-wider px-3 pt-4 pb-1 block">
                                Website Pages CMS
                            </span>

                            <button
                                onClick={() => setActiveSection("home")}
                                className={`w-full flex items-center gap-2.5 px-3.5 py-3 rounded-2xl text-xs font-bold transition-all cursor-pointer ${
                                    activeSection === "home"
                                        ? "bg-[#183928] text-white shadow-sm"
                                        : "text-gray-600 hover:bg-emerald-50 hover:text-[#183928]"
                                }`}
                            >
                                <Home className="w-4 h-4" />
                                <span>Home Page</span>
                            </button>

                            <button
                                onClick={() => setActiveSection("our_drinks")}
                                className={`w-full flex items-center gap-2.5 px-3.5 py-3 rounded-2xl text-xs font-bold transition-all cursor-pointer ${
                                    activeSection === "our_drinks"
                                        ? "bg-[#183928] text-white shadow-sm"
                                        : "text-gray-600 hover:bg-emerald-50 hover:text-[#183928]"
                                }`}
                            >
                                <Package className="w-4 h-4" />
                                <span>Our Drinks Page</span>
                            </button>

                            <button
                                onClick={() => setActiveSection("about")}
                                className={`w-full flex items-center gap-2.5 px-3.5 py-3 rounded-2xl text-xs font-bold transition-all cursor-pointer ${
                                    activeSection === "about"
                                        ? "bg-[#183928] text-white shadow-sm"
                                        : "text-gray-600 hover:bg-emerald-50 hover:text-[#183928]"
                                }`}
                            >
                                <Info className="w-4 h-4" />
                                <span>About Us Page</span>
                            </button>

                            {/* Contact Us Page বাটন নতুন যুক্ত করা হলো */}
                            <button
                                onClick={() => setActiveSection("contact_page")}
                                className={`w-full flex items-center gap-2.5 px-3.5 py-3 rounded-2xl text-xs font-bold transition-all cursor-pointer ${
                                    activeSection === "contact_page"
                                        ? "bg-[#183928] text-white shadow-sm"
                                        : "text-gray-600 hover:bg-emerald-50 hover:text-[#183928]"
                                }`}
                            >
                                <PhoneCall className="w-4 h-4" />
                                <span>Contact Us Page</span>
                            </button>

                            <button
                                onClick={() => setActiveSection("header")}
                                className={`w-full flex items-center gap-2.5 px-3.5 py-3 rounded-2xl text-xs font-bold transition-all cursor-pointer ${
                                    activeSection === "header"
                                        ? "bg-[#183928] text-white shadow-sm"
                                        : "text-gray-600 hover:bg-emerald-50 hover:text-[#183928]"
                                }`}
                            >
                                <LayoutTemplate className="w-4 h-4" />
                                <span>Header & Logo</span>
                            </button>

                            <button
                                onClick={() => setActiveSection("contact")}
                                className={`w-full flex items-center gap-2.5 px-3.5 py-3 rounded-2xl text-xs font-bold transition-all cursor-pointer ${
                                    activeSection === "contact"
                                        ? "bg-[#183928] text-white shadow-sm"
                                        : "text-gray-600 hover:bg-emerald-50 hover:text-[#183928]"
                                }`}
                            >
                                <PhoneCall className="w-4 h-4" />
                                <span>Footer & Contacts</span>
                            </button>
                        </div>

                        {/* ================= ডানপাশের কনটেন্ট এরিয়া ================= */}
                        <div className="lg:col-span-9 space-y-6">
                            {/* ১. CUSTOMER LEADS SECTION */}
                            {activeSection === "leads" && (
                                <div className="bg-white rounded-3xl p-6 shadow-sm border border-emerald-900/5 space-y-4">
                                    <h3 className="text-base font-black text-[#112318]">
                                        Customer Inquiry Leads
                                    </h3>
                                    <div className="overflow-x-auto">
                                        <table className="w-full text-left text-xs">
                                            <thead>
                                                <tr className="bg-gray-50 text-gray-500 font-bold uppercase border-b">
                                                    <th className="p-3">
                                                        Customer
                                                    </th>
                                                    <th className="p-3">
                                                        Contact
                                                    </th>
                                                    <th className="p-3">
                                                        Reason
                                                    </th>
                                                    <th className="p-3">
                                                        Message
                                                    </th>
                                                    <th className="p-3">
                                                        Status
                                                    </th>
                                                    <th className="p-3 text-right">
                                                        Delete
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody className="divide-y font-medium">
                                                {inquiries.length === 0 ? (
                                                    <tr>
                                                        <td
                                                            colSpan={6}
                                                            className="text-center py-8 text-gray-400"
                                                        >
                                                            No leads submitted
                                                            yet.
                                                        </td>
                                                    </tr>
                                                ) : (
                                                    inquiries.map((inq) => (
                                                        <tr
                                                            key={inq.id}
                                                            className="hover:bg-emerald-50/30"
                                                        >
                                                            <td className="p-3 font-bold text-[#112318]">
                                                                {inq.name}
                                                            </td>
                                                            <td className="p-3">
                                                                <a
                                                                    href={`tel:${inq.phone}`}
                                                                    className="text-[#183928] font-bold flex items-center gap-1"
                                                                >
                                                                    <PhoneCall className="w-3.5 h-3.5" />
                                                                    {inq.phone}
                                                                </a>
                                                            </td>
                                                            <td className="p-3">
                                                                <span className="bg-[#eef7ef] text-[#183928] text-[10px] font-bold px-2 py-0.5 rounded">
                                                                    {
                                                                        inq.inquiry_type
                                                                    }
                                                                </span>
                                                            </td>
                                                            <td className="p-3 max-w-xs text-gray-600">
                                                                {inq.message}
                                                            </td>
                                                            <td className="p-3">
                                                                <select
                                                                    value={
                                                                        inq.status
                                                                    }
                                                                    onChange={(
                                                                        e,
                                                                    ) =>
                                                                        router.patch(
                                                                            `/admin/inquiries/${inq.id}/status`,
                                                                            {
                                                                                status: e
                                                                                    .target
                                                                                    .value,
                                                                            },
                                                                            {
                                                                                preserveScroll: true,
                                                                            },
                                                                        )
                                                                    }
                                                                    className="text-xs font-bold rounded-lg border-gray-200"
                                                                >
                                                                    <option value="pending">
                                                                        Pending
                                                                    </option>
                                                                    <option value="contacted">
                                                                        Contacted
                                                                    </option>
                                                                    <option value="resolved">
                                                                        Resolved
                                                                    </option>
                                                                </select>
                                                            </td>
                                                            <td className="p-3 text-right">
                                                                <button
                                                                    onClick={() => {
                                                                        if (
                                                                            confirm(
                                                                                "Delete inquiry?",
                                                                            )
                                                                        )
                                                                            router.delete(
                                                                                `/admin/inquiries/${inq.id}`,
                                                                                {
                                                                                    preserveScroll: true,
                                                                                },
                                                                            );
                                                                    }}
                                                                    className="p-1.5 text-red-500 hover:bg-red-50 rounded-lg cursor-pointer"
                                                                >
                                                                    <Trash2 className="w-4 h-4" />
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    ))
                                                )}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            )}

                            {/* ২. DRINKS CATALOG */}

                            {activeSection === "drinks" && (
                                <div className="bg-white rounded-3xl p-4 sm:p-6 shadow-sm border border-emerald-900/5 space-y-5">
                                    {/* Header */}
                                    <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                        <div>
                                            <h3 className="text-base font-black text-[#112318]">
                                                Drinks Catalog
                                            </h3>
                                            <p className="text-xs text-gray-500 mt-1">
                                                Add, publish or delete botanical
                                                drinks.
                                            </p>
                                        </div>

                                        <button
                                            onClick={() =>
                                                setShowAddProductModal(true)
                                            }
                                            className="bg-[#183928] text-white text-xs font-bold px-3 sm:px-4 py-2.5 rounded-xl flex items-center justify-center gap-1.5 cursor-pointer shadow w-full sm:w-auto"
                                        >
                                            <Plus className="w-4 h-4 shrink-0" />
                                            <span>Add New Drink</span>
                                        </button>
                                    </div>

                                    {/* Table */}
                                    <div className="overflow-x-auto -mx-1 px-1">
                                        <table className="w-full min-w-[750px] text-left text-xs">
                                            <thead>
                                                <tr className="bg-gray-50 text-gray-500 font-bold uppercase border-b">
                                                    <th className="p-3 whitespace-nowrap">
                                                        Drink
                                                    </th>
                                                    <th className="p-3 whitespace-nowrap">
                                                        Price
                                                    </th>
                                                    <th className="p-3 whitespace-nowrap">
                                                        Category
                                                    </th>
                                                    <th className="p-3 whitespace-nowrap">
                                                        Visibility
                                                    </th>
                                                    <th className="p-3 text-right whitespace-nowrap">
                                                        Action
                                                    </th>
                                                </tr>
                                            </thead>

                                            <tbody className="divide-y font-medium">
                                                {products.map((prod) => (
                                                    <tr
                                                        key={prod.id}
                                                        className="hover:bg-emerald-50/30 transition-colors"
                                                    >
                                                        {/* Drink */}
                                                        <td className="p-3">
                                                            <div className="flex items-center gap-3 min-w-[200px]">
                                                                <img
                                                                    src={
                                                                        prod.image
                                                                    }
                                                                    alt={
                                                                        prod.name
                                                                    }
                                                                    className="w-10 h-10 rounded-xl object-cover border shrink-0"
                                                                />

                                                                <div className="min-w-0">
                                                                    <p className="font-bold text-[#112318] truncate max-w-[180px]">
                                                                        {
                                                                            prod.name
                                                                        }
                                                                    </p>

                                                                    <p className="text-[10px] text-gray-400 whitespace-nowrap">
                                                                        {
                                                                            prod.net_volume
                                                                        }
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </td>

                                                        {/* Price */}
                                                        <td className="p-3 font-bold text-[#183928] whitespace-nowrap">
                                                            {prod.price}
                                                        </td>

                                                        {/* Category */}
                                                        <td className="p-3 uppercase text-[10px] text-gray-500 whitespace-nowrap">
                                                            {prod.category}
                                                        </td>

                                                        {/* Visibility */}
                                                        <td className="p-3">
                                                            <span
                                                                className={`inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold whitespace-nowrap ${
                                                                    prod.is_active
                                                                        ? "bg-emerald-100 text-emerald-800"
                                                                        : "bg-gray-100 text-gray-600"
                                                                }`}
                                                            >
                                                                {prod.is_active
                                                                    ? "Published"
                                                                    : "Hidden"}
                                                            </span>
                                                        </td>

                                                        {/* Actions */}
                                                        <td className="p-3">
                                                            <div className="flex items-center justify-end gap-1.5 whitespace-nowrap">
                                                                {/* Edit */}
                                                                <button
                                                                    onClick={() =>
                                                                        openEditModal(
                                                                            prod,
                                                                        )
                                                                    }
                                                                    className="p-1.5 border rounded-lg hover:bg-emerald-50 text-[#183928] cursor-pointer transition-colors"
                                                                    title="Edit Product Details"
                                                                >
                                                                    ✏️
                                                                </button>

                                                                {/* Toggle */}
                                                                <button
                                                                    onClick={() =>
                                                                        router.patch(
                                                                            `/admin/products/${prod.id}/toggle`,
                                                                            {},
                                                                            {
                                                                                preserveScroll: true,
                                                                            },
                                                                        )
                                                                    }
                                                                    className="p-1.5 border rounded-lg hover:bg-gray-50 cursor-pointer transition-colors"
                                                                    title="Toggle Visibility"
                                                                >
                                                                    {prod.is_active ? (
                                                                        <EyeOff className="w-3.5 h-3.5" />
                                                                    ) : (
                                                                        <Eye className="w-3.5 h-3.5" />
                                                                    )}
                                                                </button>

                                                                {/* Delete */}
                                                                <button
                                                                    onClick={() => {
                                                                        if (
                                                                            confirm(
                                                                                "Delete drink?",
                                                                            )
                                                                        ) {
                                                                            router.delete(
                                                                                `/admin/products/${prod.id}`,
                                                                                {
                                                                                    preserveScroll: true,
                                                                                },
                                                                            );
                                                                        }
                                                                    }}
                                                                    className="p-1.5 text-red-500 hover:bg-red-50 rounded-lg cursor-pointer transition-colors"
                                                                >
                                                                    <Trash2 className="w-3.5 h-3.5" />
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                ))}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            )}

                            {/* ৩. HOME PAGE CMS */}
                            {activeSection === "home" && (
                                <div className="space-y-6">
                                    <div className="bg-white rounded-3xl p-6 shadow-sm border border-emerald-900/5 space-y-4">
                                        <div>
                                            <h3 className="text-lg font-black text-[#112318]">
                                                Home Page CMS Manager
                                            </h3>
                                            <p className="text-xs text-gray-500">
                                                Edit any section appearing on
                                                your live homepage.
                                            </p>
                                        </div>

                                        <div className="flex flex-wrap gap-2 border-t pt-3">
                                            {[
                                                {
                                                    id: "hero",
                                                    label: "1. Hero Banner & Cards",
                                                },
                                                {
                                                    id: "why_us",
                                                    label: "2. Why Choose Us & Story",
                                                },
                                                {
                                                    id: "faqs",
                                                    label: "3. FAQ Questions",
                                                },
                                                {
                                                    id: "reviews",
                                                    label: "4. Testimonials",
                                                },
                                            ].map((tab) => (
                                                <button
                                                    key={tab.id}
                                                    onClick={() =>
                                                        setHomeTab(tab.id)
                                                    }
                                                    className={`px-4 py-2 rounded-xl text-xs font-bold transition-all cursor-pointer ${
                                                        homeTab === tab.id
                                                            ? "bg-[#183928] text-white shadow"
                                                            : "bg-gray-100 text-gray-600 hover:bg-emerald-50 hover:text-[#183928]"
                                                    }`}
                                                >
                                                    {tab.label}
                                                </button>
                                            ))}
                                        </div>
                                    </div>

                                    {/* সাব-ট্যাব ১: HERO BANNER & 3 CARDS */}
                                    {homeTab === "hero" && (
                                        <div className="space-y-6">
                                            <div className="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-emerald-900/5 space-y-5">
                                                <div className="flex items-center gap-2 border-b pb-3">
                                                    <ImageIcon className="w-5 h-5 text-[#183928]" />
                                                    <h4 className="text-sm font-black text-[#183928] uppercase tracking-wider">
                                                        Main Hero Banner
                                                    </h4>
                                                </div>

                                                <form
                                                    onSubmit={submitBanner}
                                                    className="space-y-4"
                                                >
                                                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                        <div>
                                                            <label className="text-xs font-bold text-gray-700 block mb-1">
                                                                Banner Title
                                                            </label>
                                                            <input
                                                                type="text"
                                                                value={
                                                                    bannerForm
                                                                        .data
                                                                        .banner_title
                                                                }
                                                                onChange={(e) =>
                                                                    bannerForm.setData(
                                                                        "banner_title",
                                                                        e.target
                                                                            .value,
                                                                    )
                                                                }
                                                                className="w-full text-xs rounded-xl border-gray-200 p-3"
                                                            />
                                                        </div>
                                                        <div>
                                                            <label className="text-xs font-bold text-gray-700 block mb-1">
                                                                Banner Subtitle
                                                            </label>
                                                            <input
                                                                type="text"
                                                                value={
                                                                    bannerForm
                                                                        .data
                                                                        .banner_subtitle
                                                                }
                                                                onChange={(e) =>
                                                                    bannerForm.setData(
                                                                        "banner_subtitle",
                                                                        e.target
                                                                            .value,
                                                                    )
                                                                }
                                                                className="w-full text-xs rounded-xl border-gray-200 p-3"
                                                            />
                                                        </div>
                                                    </div>

                                                    <div className="p-4 rounded-2xl bg-[#f4faf4] border border-emerald-900/10 space-y-3">
                                                        <label className="text-xs font-black text-[#183928] uppercase tracking-wider block">
                                                            Banner Background
                                                            Image
                                                        </label>

                                                        <div className="flex gap-4">
                                                            <label className="flex items-center gap-1.5 text-xs font-bold cursor-pointer">
                                                                <input
                                                                    type="radio"
                                                                    checked={
                                                                        bannerForm
                                                                            .data
                                                                            .banner_type ===
                                                                        "url"
                                                                    }
                                                                    onChange={() =>
                                                                        bannerForm.setData(
                                                                            "banner_type",
                                                                            "url",
                                                                        )
                                                                    }
                                                                />
                                                                <span>
                                                                    Image Link
                                                                    (URL)
                                                                </span>
                                                            </label>
                                                            <label className="flex items-center gap-1.5 text-xs font-bold cursor-pointer">
                                                                <input
                                                                    type="radio"
                                                                    checked={
                                                                        bannerForm
                                                                            .data
                                                                            .banner_type ===
                                                                        "file"
                                                                    }
                                                                    onChange={() =>
                                                                        bannerForm.setData(
                                                                            "banner_type",
                                                                            "file",
                                                                        )
                                                                    }
                                                                />
                                                                <span>
                                                                    Upload from
                                                                    Computer
                                                                </span>
                                                            </label>
                                                        </div>

                                                        {bannerForm.data
                                                            .banner_type ===
                                                        "url" ? (
                                                            <input
                                                                type="text"
                                                                placeholder="e.g. /images/banner.jpeg or https://..."
                                                                value={
                                                                    bannerForm
                                                                        .data
                                                                        .banner_url
                                                                }
                                                                onChange={(e) =>
                                                                    bannerForm.setData(
                                                                        "banner_url",
                                                                        e.target
                                                                            .value,
                                                                    )
                                                                }
                                                                className="w-full text-xs rounded-xl border-gray-200 p-3"
                                                            />
                                                        ) : (
                                                            <input
                                                                type="file"
                                                                accept="image/*"
                                                                onChange={(e) =>
                                                                    bannerForm.setData(
                                                                        "banner_file",
                                                                        e.target
                                                                            .files[0],
                                                                    )
                                                                }
                                                                className="w-full text-xs file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-[#183928] file:text-white cursor-pointer"
                                                            />
                                                        )}
                                                    </div>

                                                    <button
                                                        type="submit"
                                                        disabled={
                                                            bannerForm.processing
                                                        }
                                                        className="bg-[#183928] text-white text-xs font-bold px-5 py-2.5 rounded-xl shadow flex items-center gap-2 hover:bg-[#122c1f]"
                                                    >
                                                        <Save className="w-4 h-4" />
                                                        <span>
                                                            {bannerForm.processing
                                                                ? "Saving..."
                                                                : "Save Banner"}
                                                        </span>
                                                    </button>
                                                </form>
                                            </div>

                                            <div className="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-emerald-900/5 space-y-5">
                                                <div className="flex items-center gap-2 border-b pb-3">
                                                    <Sparkles className="w-5 h-5 text-[#183928]" />
                                                    <h4 className="text-sm font-black text-[#183928] uppercase tracking-wider">
                                                        Below-Banner 3 Feature
                                                        Cards
                                                    </h4>
                                                </div>

                                                <form
                                                    onSubmit={submitCards}
                                                    className="space-y-4"
                                                >
                                                    {cards.map((card, idx) => (
                                                        <div
                                                            key={idx}
                                                            className="p-4 rounded-2xl bg-[#f4faf4] border border-emerald-900/10 space-y-3"
                                                        >
                                                            <span className="text-xs font-black text-[#183928] block">
                                                                Card #{idx + 1}
                                                            </span>

                                                            <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                                <div>
                                                                    <label className="text-[11px] font-bold text-gray-600 block mb-1">
                                                                        Image
                                                                        URL /
                                                                        Path
                                                                    </label>
                                                                    <input
                                                                        type="text"
                                                                        value={
                                                                            card.image
                                                                        }
                                                                        onChange={(
                                                                            e,
                                                                        ) => {
                                                                            const next =
                                                                                [
                                                                                    ...cards,
                                                                                ];
                                                                            next[
                                                                                idx
                                                                            ].image =
                                                                                e.target.value;
                                                                            setCards(
                                                                                next,
                                                                            );
                                                                        }}
                                                                        className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                                                    />
                                                                </div>
                                                                <div>
                                                                    <label className="text-[11px] font-bold text-gray-600 block mb-1">
                                                                        Card
                                                                        Title
                                                                    </label>
                                                                    <input
                                                                        type="text"
                                                                        value={
                                                                            card.title
                                                                        }
                                                                        onChange={(
                                                                            e,
                                                                        ) => {
                                                                            const next =
                                                                                [
                                                                                    ...cards,
                                                                                ];
                                                                            next[
                                                                                idx
                                                                            ].title =
                                                                                e.target.value;
                                                                            setCards(
                                                                                next,
                                                                            );
                                                                        }}
                                                                        className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                                                    />
                                                                </div>
                                                            </div>

                                                            <div>
                                                                <label className="text-[11px] font-bold text-gray-600 block mb-1">
                                                                    Hover Text
                                                                    Details
                                                                </label>
                                                                <textarea
                                                                    rows={2}
                                                                    value={
                                                                        card.hover_text
                                                                    }
                                                                    onChange={(
                                                                        e,
                                                                    ) => {
                                                                        const next =
                                                                            [
                                                                                ...cards,
                                                                            ];
                                                                        next[
                                                                            idx
                                                                        ].hover_text =
                                                                            e.target.value;
                                                                        setCards(
                                                                            next,
                                                                        );
                                                                    }}
                                                                    className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                                                />
                                                            </div>
                                                        </div>
                                                    ))}

                                                    <button
                                                        type="submit"
                                                        className="bg-[#183928] text-white text-xs font-bold px-5 py-2.5 rounded-xl shadow flex items-center gap-2 hover:bg-[#122c1f]"
                                                    >
                                                        <Save className="w-4 h-4" />
                                                        <span>
                                                            Save All 3 Feature
                                                            Cards
                                                        </span>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    )}

                                    {/* সাব-ট্যাব ২: WHY CHOOSE US & STORY */}
                                    {homeTab === "why_us" && (
                                        <form
                                            onSubmit={submitWhyUs}
                                            className="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border space-y-6"
                                        >
                                            <h4 className="text-sm font-black text-[#183928] uppercase tracking-wider">
                                                Header Texts
                                            </h4>
                                            <div className="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                                <div>
                                                    <label className="text-xs font-bold block mb-1">
                                                        Badge Text
                                                    </label>
                                                    <input
                                                        type="text"
                                                        value={whyUs.badge}
                                                        onChange={(e) =>
                                                            setWhyUs({
                                                                ...whyUs,
                                                                badge: e.target
                                                                    .value,
                                                            })
                                                        }
                                                        className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                                    />
                                                </div>
                                                <div>
                                                    <label className="text-xs font-bold block mb-1">
                                                        Title Line
                                                    </label>
                                                    <input
                                                        type="text"
                                                        value={whyUs.title}
                                                        onChange={(e) =>
                                                            setWhyUs({
                                                                ...whyUs,
                                                                title: e.target
                                                                    .value,
                                                            })
                                                        }
                                                        className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                                    />
                                                </div>
                                                <div>
                                                    <label className="text-xs font-bold block mb-1">
                                                        Highlight Line
                                                    </label>
                                                    <input
                                                        type="text"
                                                        value={whyUs.highlight}
                                                        onChange={(e) =>
                                                            setWhyUs({
                                                                ...whyUs,
                                                                highlight:
                                                                    e.target
                                                                        .value,
                                                            })
                                                        }
                                                        className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                                    />
                                                </div>
                                            </div>

                                            <div>
                                                <label className="text-xs font-bold block mb-1">
                                                    Subtitle Description
                                                </label>
                                                <textarea
                                                    rows={2}
                                                    value={whyUs.subtitle}
                                                    onChange={(e) =>
                                                        setWhyUs({
                                                            ...whyUs,
                                                            subtitle:
                                                                e.target.value,
                                                        })
                                                    }
                                                    className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                                />
                                            </div>

                                            <h4 className="text-sm font-black text-[#183928] uppercase tracking-wider border-t pt-4">
                                                Story & Details
                                            </h4>
                                            <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                <div>
                                                    <label className="text-xs font-bold block mb-1">
                                                        Story Headline
                                                    </label>
                                                    <input
                                                        type="text"
                                                        value={
                                                            whyUs.story_title
                                                        }
                                                        onChange={(e) =>
                                                            setWhyUs({
                                                                ...whyUs,
                                                                story_title:
                                                                    e.target
                                                                        .value,
                                                            })
                                                        }
                                                        className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                                    />
                                                </div>
                                                <div>
                                                    <label className="text-xs font-bold block mb-1">
                                                        Story Image URL
                                                    </label>
                                                    <input
                                                        type="text"
                                                        value={
                                                            whyUs.story_image
                                                        }
                                                        onChange={(e) =>
                                                            setWhyUs({
                                                                ...whyUs,
                                                                story_image:
                                                                    e.target
                                                                        .value,
                                                            })
                                                        }
                                                        className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                                    />
                                                </div>
                                            </div>

                                            <div>
                                                <label className="text-xs font-bold block mb-1">
                                                    Story Paragraph
                                                </label>
                                                <textarea
                                                    rows={3}
                                                    value={whyUs.story_desc}
                                                    onChange={(e) =>
                                                        setWhyUs({
                                                            ...whyUs,
                                                            story_desc:
                                                                e.target.value,
                                                        })
                                                    }
                                                    className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                                />
                                            </div>

                                            <h4 className="text-sm font-black text-[#183928] uppercase tracking-wider border-t pt-4">
                                                3 Numeric Stats
                                            </h4>
                                            <div className="grid grid-cols-3 gap-4">
                                                <div>
                                                    <label className="text-xs font-bold block mb-1">
                                                        Stat 1
                                                    </label>
                                                    <input
                                                        type="text"
                                                        value={whyUs.stat_1_val}
                                                        onChange={(e) =>
                                                            setWhyUs({
                                                                ...whyUs,
                                                                stat_1_val:
                                                                    e.target
                                                                        .value,
                                                            })
                                                        }
                                                        className="w-full text-xs rounded-xl border-gray-200 p-2"
                                                    />
                                                    <input
                                                        type="text"
                                                        value={
                                                            whyUs.stat_1_label
                                                        }
                                                        onChange={(e) =>
                                                            setWhyUs({
                                                                ...whyUs,
                                                                stat_1_label:
                                                                    e.target
                                                                        .value,
                                                            })
                                                        }
                                                        className="w-full text-xs rounded-xl border-gray-200 p-2 mt-1"
                                                    />
                                                </div>
                                                <div>
                                                    <label className="text-xs font-bold block mb-1">
                                                        Stat 2
                                                    </label>
                                                    <input
                                                        type="text"
                                                        value={whyUs.stat_2_val}
                                                        onChange={(e) =>
                                                            setWhyUs({
                                                                ...whyUs,
                                                                stat_2_val:
                                                                    e.target
                                                                        .value,
                                                            })
                                                        }
                                                        className="w-full text-xs rounded-xl border-gray-200 p-2"
                                                    />
                                                    <input
                                                        type="text"
                                                        value={
                                                            whyUs.stat_2_label
                                                        }
                                                        onChange={(e) =>
                                                            setWhyUs({
                                                                ...whyUs,
                                                                stat_2_label:
                                                                    e.target
                                                                        .value,
                                                            })
                                                        }
                                                        className="w-full text-xs rounded-xl border-gray-200 p-2 mt-1"
                                                    />
                                                </div>
                                                <div>
                                                    <label className="text-xs font-bold block mb-1">
                                                        Stat 3
                                                    </label>
                                                    <input
                                                        type="text"
                                                        value={whyUs.stat_3_val}
                                                        onChange={(e) =>
                                                            setWhyUs({
                                                                ...whyUs,
                                                                stat_3_val:
                                                                    e.target
                                                                        .value,
                                                            })
                                                        }
                                                        className="w-full text-xs rounded-xl border-gray-200 p-2"
                                                    />
                                                    <input
                                                        type="text"
                                                        value={
                                                            whyUs.stat_3_label
                                                        }
                                                        onChange={(e) =>
                                                            setWhyUs({
                                                                ...whyUs,
                                                                stat_3_label:
                                                                    e.target
                                                                        .value,
                                                            })
                                                        }
                                                        className="w-full text-xs rounded-xl border-gray-200 p-2 mt-1"
                                                    />
                                                </div>
                                            </div>

                                            <h4 className="text-sm font-black text-[#183928] uppercase tracking-wider border-t pt-4">
                                                4 Feature Cards
                                            </h4>
                                            <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                {whyUs.features.map(
                                                    (feat, idx) => (
                                                        <div
                                                            key={idx}
                                                            className="p-4 bg-[#f4faf4] rounded-2xl border space-y-2"
                                                        >
                                                            <label className="text-xs font-bold block">
                                                                Feature #
                                                                {idx + 1}
                                                            </label>
                                                            <input
                                                                type="text"
                                                                value={
                                                                    feat.title
                                                                }
                                                                onChange={(
                                                                    e,
                                                                ) => {
                                                                    const next =
                                                                        [
                                                                            ...whyUs.features,
                                                                        ];
                                                                    next[
                                                                        idx
                                                                    ].title =
                                                                        e.target.value;
                                                                    setWhyUs({
                                                                        ...whyUs,
                                                                        features:
                                                                            next,
                                                                    });
                                                                }}
                                                                className="w-full text-xs rounded-xl border-gray-200 p-2 font-bold"
                                                            />
                                                            <textarea
                                                                rows={2}
                                                                value={
                                                                    feat.desc
                                                                }
                                                                onChange={(
                                                                    e,
                                                                ) => {
                                                                    const next =
                                                                        [
                                                                            ...whyUs.features,
                                                                        ];
                                                                    next[
                                                                        idx
                                                                    ].desc =
                                                                        e.target.value;
                                                                    setWhyUs({
                                                                        ...whyUs,
                                                                        features:
                                                                            next,
                                                                    });
                                                                }}
                                                                className="w-full text-xs rounded-xl border-gray-200 p-2"
                                                            />
                                                        </div>
                                                    ),
                                                )}
                                            </div>

                                            <button
                                                type="submit"
                                                className="bg-[#183928] text-white text-xs font-bold px-6 py-3 rounded-xl shadow flex items-center gap-2"
                                            >
                                                <Save className="w-4 h-4" />{" "}
                                                Save Why Choose Us
                                            </button>
                                        </form>
                                    )}

                                    {/* সাব-ট্যাব ৩: FAQ QUESTIONS */}
                                    {homeTab === "faqs" && (
                                        <form
                                            onSubmit={submitFaqs}
                                            className="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-emerald-900/5 space-y-5"
                                        >
                                            <div className="flex items-center justify-between border-b pb-4">
                                                <div>
                                                    <h4 className="text-sm font-black text-[#183928] uppercase tracking-wider">
                                                        Frequently Asked
                                                        Questions (
                                                        {faqsList.length})
                                                    </h4>
                                                    <p className="text-xs text-gray-500">
                                                        Edit existing questions
                                                        or add new ones to
                                                        display on the live FAQ
                                                        accordion.
                                                    </p>
                                                </div>
                                                <button
                                                    type="button"
                                                    onClick={() =>
                                                        setFaqsList([
                                                            ...faqsList,
                                                            {
                                                                question: "",
                                                                answer: "",
                                                            },
                                                        ])
                                                    }
                                                    className="text-xs bg-[#183928] text-white font-bold px-4 py-2 rounded-xl flex items-center gap-1.5 hover:bg-[#122c1f] transition-all cursor-pointer shadow-sm"
                                                >
                                                    <Plus className="w-3.5 h-3.5" />{" "}
                                                    Add Question
                                                </button>
                                            </div>

                                            <div className="space-y-4">
                                                {faqsList.map((faq, idx) => (
                                                    <div
                                                        key={idx}
                                                        className="p-5 bg-[#f4faf4] rounded-2xl border border-emerald-900/10 space-y-3 relative group"
                                                    >
                                                        <div className="flex items-center justify-between">
                                                            <span className="text-xs font-black text-[#183928] tracking-wider uppercase">
                                                                Question #
                                                                {idx + 1}
                                                            </span>
                                                            <button
                                                                type="button"
                                                                onClick={() => {
                                                                    if (
                                                                        confirm(
                                                                            `Delete Question #${idx + 1}?`,
                                                                        )
                                                                    ) {
                                                                        setFaqsList(
                                                                            faqsList.filter(
                                                                                (
                                                                                    _,
                                                                                    i,
                                                                                ) =>
                                                                                    i !==
                                                                                    idx,
                                                                            ),
                                                                        );
                                                                    }
                                                                }}
                                                                className="p-1.5 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors cursor-pointer"
                                                                title="Delete this question"
                                                            >
                                                                <Trash2 className="w-4 h-4" />
                                                            </button>
                                                        </div>
                                                        <div>
                                                            <label className="text-[11px] font-bold text-gray-600 block mb-1">
                                                                Question Title
                                                            </label>
                                                            <input
                                                                type="text"
                                                                required
                                                                placeholder="Write question here..."
                                                                value={
                                                                    faq.question
                                                                }
                                                                onChange={(
                                                                    e,
                                                                ) => {
                                                                    const next =
                                                                        [
                                                                            ...faqsList,
                                                                        ];
                                                                    next[
                                                                        idx
                                                                    ].question =
                                                                        e.target.value;
                                                                    setFaqsList(
                                                                        next,
                                                                    );
                                                                }}
                                                                className="w-full text-xs rounded-xl border-gray-200 p-2.5 font-bold focus:ring-[#183928] focus:border-[#183928]"
                                                            />
                                                        </div>
                                                        <div>
                                                            <label className="text-[11px] font-bold text-gray-600 block mb-1">
                                                                Answer
                                                            </label>
                                                            <textarea
                                                                rows={3}
                                                                required
                                                                placeholder="Write answer details here..."
                                                                value={
                                                                    faq.answer
                                                                }
                                                                onChange={(
                                                                    e,
                                                                ) => {
                                                                    const next =
                                                                        [
                                                                            ...faqsList,
                                                                        ];
                                                                    next[
                                                                        idx
                                                                    ].answer =
                                                                        e.target.value;
                                                                    setFaqsList(
                                                                        next,
                                                                    );
                                                                }}
                                                                className="w-full text-xs rounded-xl border-gray-200 p-2.5 leading-relaxed focus:ring-[#183928] focus:border-[#183928]"
                                                            />
                                                        </div>
                                                    </div>
                                                ))}
                                            </div>

                                            <div className="pt-2 border-t flex justify-end">
                                                <button
                                                    type="submit"
                                                    className="bg-[#183928] text-white text-xs font-bold px-6 py-3 rounded-xl shadow-md hover:bg-[#122c1f] flex items-center gap-2 cursor-pointer transition-all"
                                                >
                                                    <Save className="w-4 h-4" />
                                                    <span>Save All FAQs</span>
                                                </button>
                                            </div>
                                        </form>
                                    )}

                                    {/* সাব-ট্যাব ৪: TESTIMONIALS */}
                                    {homeTab === "reviews" && (
                                        <form
                                            onSubmit={submitReviews}
                                            className="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-emerald-900/5 space-y-5"
                                        >
                                            <div className="flex items-center justify-between border-b pb-4">
                                                <div>
                                                    <h4 className="text-sm font-black text-[#183928] uppercase tracking-wider">
                                                        Community Reviews (
                                                        {reviewsList.length})
                                                    </h4>
                                                    <p className="text-xs text-gray-500">
                                                        Edit existing feedback
                                                        or add new customer
                                                        testimonials.
                                                    </p>
                                                </div>
                                                <button
                                                    type="button"
                                                    onClick={() =>
                                                        setReviewsList([
                                                            ...reviewsList,
                                                            {
                                                                id: Date.now(),
                                                                name: "Customer Name",
                                                                location:
                                                                    "City",
                                                                role: "Verified Sipper",
                                                                drink: "Pudina Drink",
                                                                rating: 5,
                                                                feedback:
                                                                    "Great natural botanical refreshment!",
                                                            },
                                                        ])
                                                    }
                                                    className="text-xs bg-[#183928] text-white font-bold px-4 py-2 rounded-xl flex items-center gap-1.5 hover:bg-[#122c1f] transition-all cursor-pointer shadow-sm"
                                                >
                                                    <Plus className="w-3.5 h-3.5" />{" "}
                                                    Add Review
                                                </button>
                                            </div>

                                            <div className="space-y-4">
                                                {reviewsList.map((rev, idx) => (
                                                    <div
                                                        key={idx}
                                                        className="p-5 bg-[#f4faf4] rounded-2xl border border-emerald-900/10 space-y-3 relative group"
                                                    >
                                                        <div className="flex items-center justify-between">
                                                            <span className="text-xs font-black text-[#183928] tracking-wider uppercase">
                                                                Review #
                                                                {idx + 1}
                                                            </span>
                                                            <button
                                                                type="button"
                                                                onClick={() => {
                                                                    if (
                                                                        confirm(
                                                                            `Delete Review #${idx + 1}?`,
                                                                        )
                                                                    ) {
                                                                        setReviewsList(
                                                                            reviewsList.filter(
                                                                                (
                                                                                    _,
                                                                                    i,
                                                                                ) =>
                                                                                    i !==
                                                                                    idx,
                                                                            ),
                                                                        );
                                                                    }
                                                                }}
                                                                className="p-1.5 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors cursor-pointer"
                                                                title="Delete this review"
                                                            >
                                                                <Trash2 className="w-4 h-4" />
                                                            </button>
                                                        </div>
                                                        <div className="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                                            <div>
                                                                <label className="text-[11px] font-bold text-gray-500 block mb-1">
                                                                    Name
                                                                </label>
                                                                <input
                                                                    type="text"
                                                                    value={
                                                                        rev.name
                                                                    }
                                                                    onChange={(
                                                                        e,
                                                                    ) => {
                                                                        const next =
                                                                            [
                                                                                ...reviewsList,
                                                                            ];
                                                                        next[
                                                                            idx
                                                                        ].name =
                                                                            e.target.value;
                                                                        setReviewsList(
                                                                            next,
                                                                        );
                                                                    }}
                                                                    className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                                                />
                                                            </div>
                                                            <div>
                                                                <label className="text-[11px] font-bold text-gray-500 block mb-1">
                                                                    Location
                                                                </label>
                                                                <input
                                                                    type="text"
                                                                    value={
                                                                        rev.location
                                                                    }
                                                                    onChange={(
                                                                        e,
                                                                    ) => {
                                                                        const next =
                                                                            [
                                                                                ...reviewsList,
                                                                            ];
                                                                        next[
                                                                            idx
                                                                        ].location =
                                                                            e.target.value;
                                                                        setReviewsList(
                                                                            next,
                                                                        );
                                                                    }}
                                                                    className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                                                />
                                                            </div>
                                                            <div>
                                                                <label className="text-[11px] font-bold text-gray-500 block mb-1">
                                                                    Drink Flavor
                                                                </label>
                                                                <input
                                                                    type="text"
                                                                    value={
                                                                        rev.drink
                                                                    }
                                                                    onChange={(
                                                                        e,
                                                                    ) => {
                                                                        const next =
                                                                            [
                                                                                ...reviewsList,
                                                                            ];
                                                                        next[
                                                                            idx
                                                                        ].drink =
                                                                            e.target.value;
                                                                        setReviewsList(
                                                                            next,
                                                                        );
                                                                    }}
                                                                    className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                                                />
                                                            </div>
                                                            <div>
                                                                <label className="text-[11px] font-bold text-gray-500 block mb-1">
                                                                    Role / Badge
                                                                </label>
                                                                <input
                                                                    type="text"
                                                                    value={
                                                                        rev.role
                                                                    }
                                                                    onChange={(
                                                                        e,
                                                                    ) => {
                                                                        const next =
                                                                            [
                                                                                ...reviewsList,
                                                                            ];
                                                                        next[
                                                                            idx
                                                                        ].role =
                                                                            e.target.value;
                                                                        setReviewsList(
                                                                            next,
                                                                        );
                                                                    }}
                                                                    className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                                                />
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <label className="text-[11px] font-bold text-gray-500 block mb-1">
                                                                Review Feedback
                                                            </label>
                                                            <textarea
                                                                rows={2}
                                                                value={
                                                                    rev.feedback
                                                                }
                                                                onChange={(
                                                                    e,
                                                                ) => {
                                                                    const next =
                                                                        [
                                                                            ...reviewsList,
                                                                        ];
                                                                    next[
                                                                        idx
                                                                    ].feedback =
                                                                        e.target.value;
                                                                    setReviewsList(
                                                                        next,
                                                                    );
                                                                }}
                                                                className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                                            />
                                                        </div>
                                                    </div>
                                                ))}
                                            </div>

                                            <div className="pt-2 border-t flex justify-end">
                                                <button
                                                    type="submit"
                                                    className="bg-[#183928] text-white text-xs font-bold px-6 py-3 rounded-xl shadow flex items-center gap-2"
                                                >
                                                    <Save className="w-4 h-4" />{" "}
                                                    Save Testimonials
                                                </button>
                                            </div>
                                        </form>
                                    )}
                                </div>
                            )}

                            {/* OUR DRINKS PAGE CMS */}
                            {activeSection === "our_drinks" && (
                                <form
                                    onSubmit={submitOurDrinks}
                                    className="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-emerald-900/5 space-y-6"
                                >
                                    <div>
                                        <h3 className="text-lg font-black text-[#112318]">
                                            Our Drinks Page CMS Manager
                                        </h3>
                                        <p className="text-xs text-gray-500">
                                            Edit header texts, subtitle, and
                                            dynamic filter categories.
                                        </p>
                                    </div>

                                    <div className="space-y-4">
                                        <h4 className="text-xs font-black text-[#183928] uppercase tracking-wider border-b pb-2">
                                            1. Header & Subtitle
                                        </h4>
                                        <div className="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                            <div>
                                                <label className="text-xs font-bold text-gray-700 block mb-1">
                                                    Badge Text
                                                </label>
                                                <input
                                                    type="text"
                                                    value={ourDrinksData.badge}
                                                    onChange={(e) =>
                                                        setOurDrinksData({
                                                            ...ourDrinksData,
                                                            badge: e.target
                                                                .value,
                                                        })
                                                    }
                                                    className="w-full text-xs rounded-xl border-gray-200 p-3"
                                                />
                                            </div>
                                            <div>
                                                <label className="text-xs font-bold text-gray-700 block mb-1">
                                                    Title Line
                                                </label>
                                                <input
                                                    type="text"
                                                    value={ourDrinksData.title}
                                                    onChange={(e) =>
                                                        setOurDrinksData({
                                                            ...ourDrinksData,
                                                            title: e.target
                                                                .value,
                                                        })
                                                    }
                                                    className="w-full text-xs rounded-xl border-gray-200 p-3"
                                                />
                                            </div>
                                            <div>
                                                <label className="text-xs font-bold text-gray-700 block mb-1">
                                                    Highlight Line
                                                </label>
                                                <input
                                                    type="text"
                                                    value={
                                                        ourDrinksData.highlight
                                                    }
                                                    onChange={(e) =>
                                                        setOurDrinksData({
                                                            ...ourDrinksData,
                                                            highlight:
                                                                e.target.value,
                                                        })
                                                    }
                                                    className="w-full text-xs rounded-xl border-gray-200 p-3"
                                                />
                                            </div>
                                        </div>

                                        <div>
                                            <label className="text-xs font-bold text-gray-700 block mb-1">
                                                Page Subtitle Description
                                            </label>
                                            <textarea
                                                rows={2}
                                                value={ourDrinksData.subtitle}
                                                onChange={(e) =>
                                                    setOurDrinksData({
                                                        ...ourDrinksData,
                                                        subtitle:
                                                            e.target.value,
                                                    })
                                                }
                                                className="w-full text-xs rounded-xl border-gray-200 p-3"
                                            />
                                        </div>
                                    </div>

                                    {/* ক্যাটাগরি ম্যানেজমেন্ট */}
                                    <div className="space-y-4 border-t pt-4">
                                        <div className="flex items-center justify-between border-b pb-2">
                                            <div>
                                                <h4 className="text-xs font-black text-[#183928] uppercase tracking-wider">
                                                    2. Filter Categories
                                                </h4>
                                                <p className="text-[11px] text-gray-500">
                                                    Add, rename or delete
                                                    category filter buttons.
                                                </p>
                                            </div>
                                            <button
                                                type="button"
                                                onClick={() => {
                                                    const current =
                                                        ourDrinksData.categories ||
                                                        [];
                                                    setOurDrinksData({
                                                        ...ourDrinksData,
                                                        categories: [
                                                            ...current,
                                                            {
                                                                id: `cat_${Date.now()}`,
                                                                label: "New Category",
                                                            },
                                                        ],
                                                    });
                                                }}
                                                className="text-xs bg-emerald-100 text-[#183928] font-bold px-3 py-1.5 rounded-lg flex items-center gap-1 cursor-pointer hover:bg-emerald-200"
                                            >
                                                <Plus className="w-3.5 h-3.5" />{" "}
                                                Add Category
                                            </button>
                                        </div>

                                        <div className="space-y-3">
                                            {(
                                                ourDrinksData.categories || []
                                            ).map((cat, idx) => (
                                                <div
                                                    key={idx}
                                                    className="p-3 bg-[#f4faf4] rounded-xl border border-emerald-900/10 flex items-center gap-3"
                                                >
                                                    <div className="w-1/3">
                                                        <label className="text-[10px] font-bold text-gray-500 block mb-0.5">
                                                            ID (slug)
                                                        </label>
                                                        <input
                                                            type="text"
                                                            value={cat.id}
                                                            onChange={(e) => {
                                                                const next = [
                                                                    ...ourDrinksData.categories,
                                                                ];
                                                                next[idx].id =
                                                                    e.target.value;
                                                                setOurDrinksData(
                                                                    {
                                                                        ...ourDrinksData,
                                                                        categories:
                                                                            next,
                                                                    },
                                                                );
                                                            }}
                                                            className="w-full text-xs rounded-xl border-gray-200 p-2 font-bold"
                                                        />
                                                    </div>
                                                    <div className="flex-1">
                                                        <label className="text-[10px] font-bold text-gray-500 block mb-0.5">
                                                            Label Name
                                                        </label>
                                                        <input
                                                            type="text"
                                                            value={cat.label}
                                                            onChange={(e) => {
                                                                const next = [
                                                                    ...ourDrinksData.categories,
                                                                ];
                                                                next[
                                                                    idx
                                                                ].label =
                                                                    e.target.value;
                                                                setOurDrinksData(
                                                                    {
                                                                        ...ourDrinksData,
                                                                        categories:
                                                                            next,
                                                                    },
                                                                );
                                                            }}
                                                            className="w-full text-xs rounded-xl border-gray-200 p-2 font-bold"
                                                        />
                                                    </div>
                                                    <button
                                                        type="button"
                                                        onClick={() => {
                                                            const next =
                                                                ourDrinksData.categories.filter(
                                                                    (_, i) =>
                                                                        i !==
                                                                        idx,
                                                                );
                                                            setOurDrinksData({
                                                                ...ourDrinksData,
                                                                categories:
                                                                    next,
                                                            });
                                                        }}
                                                        className="p-1.5 text-red-500 hover:bg-red-50 rounded-lg cursor-pointer mt-4"
                                                    >
                                                        <Trash2 className="w-4 h-4" />
                                                    </button>
                                                </div>
                                            ))}
                                        </div>
                                    </div>

                                    <button
                                        type="submit"
                                        className="bg-[#183928] text-white text-xs font-bold px-6 py-3.5 rounded-xl hover:bg-[#122c1f] flex items-center gap-2 cursor-pointer shadow"
                                    >
                                        <Save className="w-4 h-4" />
                                        <span>
                                            Save Our Drinks Page Settings
                                        </span>
                                    </button>
                                </form>
                            )}

                            {/* ৪. CONTACT US PAGE CMS (নতুন যুক্ত করা হলো স্ক্রিনশট অনুযায়ী) */}
                            {/* ৪. CONTACT US PAGE CMS */}
                            {/* ৪. CONTACT US PAGE CMS */}
                            {/* ৪. CONTACT US PAGE CMS */}
                            {activeSection === "contact_page" && (
                                <form
                                    onSubmit={submitContactPage}
                                    className="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-emerald-900/5 space-y-6"
                                >
                                    <div>
                                        <h3 className="text-lg font-black text-[#112318]">
                                            Contact Us Page CMS Manager
                                        </h3>
                                        <p className="text-xs text-gray-500">
                                            Edit titles, office details,
                                            hotlines, and wholesale banner texts
                                            on the live Contact Us page.
                                        </p>
                                    </div>

                                    {/* সেকশন ১: HEADER TEXTS */}
                                    <div className="space-y-4">
                                        <h4 className="text-xs font-black text-[#183928] uppercase tracking-wider border-b pb-2">
                                            1. HEADER TEXTS
                                        </h4>
                                        <div className="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                            <div>
                                                <label className="text-xs font-bold text-gray-700 block mb-1">
                                                    Badge Text
                                                </label>
                                                <input
                                                    type="text"
                                                    value={
                                                        contactPageData.badge
                                                    }
                                                    onChange={(e) =>
                                                        setContactPageData({
                                                            ...contactPageData,
                                                            badge: e.target
                                                                .value,
                                                        })
                                                    }
                                                    className="w-full text-sm rounded-2xl border-gray-200 p-3.5"
                                                />
                                            </div>
                                            <div>
                                                <label className="text-xs font-bold text-gray-700 block mb-1">
                                                    Title Line
                                                </label>
                                                <input
                                                    type="text"
                                                    value={
                                                        contactPageData.title
                                                    }
                                                    onChange={(e) =>
                                                        setContactPageData({
                                                            ...contactPageData,
                                                            title: e.target
                                                                .value,
                                                        })
                                                    }
                                                    className="w-full text-sm rounded-2xl border-gray-200 p-3.5"
                                                />
                                            </div>
                                            <div>
                                                <label className="text-xs font-bold text-gray-700 block mb-1">
                                                    Highlight Line
                                                </label>
                                                <input
                                                    type="text"
                                                    value={
                                                        contactPageData.highlight
                                                    }
                                                    onChange={(e) =>
                                                        setContactPageData({
                                                            ...contactPageData,
                                                            highlight:
                                                                e.target.value,
                                                        })
                                                    }
                                                    className="w-full text-sm rounded-2xl border-gray-200 p-3.5"
                                                />
                                            </div>
                                        </div>

                                        <div>
                                            <label className="text-xs font-bold text-gray-700 block mb-1">
                                                Page Subtitle Description
                                            </label>
                                            <textarea
                                                rows={2}
                                                value={contactPageData.subtitle}
                                                onChange={(e) =>
                                                    setContactPageData({
                                                        ...contactPageData,
                                                        subtitle:
                                                            e.target.value,
                                                    })
                                                }
                                                className="w-full text-sm rounded-2xl border-gray-200 p-3.5"
                                            />
                                        </div>
                                    </div>

                                    {/* সেকশন ২: HOTLINES, OFFICE & OPERATIONAL INFO */}
                                    <div className="space-y-4 border-t pt-4">
                                        <h4 className="text-xs font-black text-[#183928] uppercase tracking-wider border-b pb-2">
                                            2. HOTLINES, OFFICE & OPERATIONAL
                                            INFO
                                        </h4>

                                        <div className="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                            <div>
                                                <label className="text-xs font-bold text-gray-700 block mb-1">
                                                    Primary Helpline
                                                </label>
                                                <input
                                                    type="text"
                                                    value={
                                                        contactPageData.primary_phone ||
                                                        ""
                                                    }
                                                    onChange={(e) =>
                                                        setContactPageData({
                                                            ...contactPageData,
                                                            primary_phone:
                                                                e.target.value,
                                                        })
                                                    }
                                                    className="w-full text-sm rounded-2xl border-gray-200 p-3.5"
                                                />
                                            </div>
                                            <div>
                                                <label className="text-xs font-bold text-gray-700 block mb-1">
                                                    Dealership & Distribution
                                                </label>
                                                <input
                                                    type="text"
                                                    value={
                                                        contactPageData.dealership_phone ||
                                                        ""
                                                    }
                                                    onChange={(e) =>
                                                        setContactPageData({
                                                            ...contactPageData,
                                                            dealership_phone:
                                                                e.target.value,
                                                        })
                                                    }
                                                    className="w-full text-sm rounded-2xl border-gray-200 p-3.5"
                                                />
                                            </div>
                                            <div>
                                                <label className="text-xs font-bold text-gray-700 block mb-1">
                                                    WhatsApp Inquiry Number
                                                </label>
                                                <input
                                                    type="text"
                                                    value={
                                                        contactPageData.whatsapp_phone ||
                                                        ""
                                                    }
                                                    onChange={(e) =>
                                                        setContactPageData({
                                                            ...contactPageData,
                                                            whatsapp_phone:
                                                                e.target.value,
                                                        })
                                                    }
                                                    className="w-full text-sm rounded-2xl border-gray-200 p-3.5"
                                                />
                                            </div>
                                        </div>

                                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <div>
                                                <label className="text-xs font-bold text-gray-700 block mb-1">
                                                    Address Title
                                                </label>
                                                <input
                                                    type="text"
                                                    value={
                                                        contactPageData.address_title
                                                    }
                                                    onChange={(e) =>
                                                        setContactPageData({
                                                            ...contactPageData,
                                                            address_title:
                                                                e.target.value,
                                                        })
                                                    }
                                                    className="w-full text-sm rounded-2xl border-gray-200 p-3.5"
                                                />
                                            </div>
                                            <div>
                                                <label className="text-xs font-bold text-gray-700 block mb-1">
                                                    Official Email
                                                </label>
                                                <input
                                                    type="email"
                                                    value={
                                                        contactPageData.email
                                                    }
                                                    onChange={(e) =>
                                                        setContactPageData({
                                                            ...contactPageData,
                                                            email: e.target
                                                                .value,
                                                        })
                                                    }
                                                    className="w-full text-sm rounded-2xl border-gray-200 p-3.5"
                                                />
                                            </div>
                                        </div>

                                        <div>
                                            <label className="text-xs font-bold text-gray-700 block mb-1">
                                                Full Address Description
                                            </label>
                                            <input
                                                type="text"
                                                value={
                                                    contactPageData.address_desc
                                                }
                                                onChange={(e) =>
                                                    setContactPageData({
                                                        ...contactPageData,
                                                        address_desc:
                                                            e.target.value,
                                                    })
                                                }
                                                className="w-full text-sm rounded-2xl border-gray-200 p-3.5"
                                            />
                                        </div>

                                        <div>
                                            <label className="text-xs font-bold text-gray-700 block mb-1">
                                                Operational Hours
                                            </label>
                                            <input
                                                type="text"
                                                value={contactPageData.hours}
                                                onChange={(e) =>
                                                    setContactPageData({
                                                        ...contactPageData,
                                                        hours: e.target.value,
                                                    })
                                                }
                                                className="w-full text-sm rounded-2xl border-gray-200 p-3.5"
                                            />
                                        </div>
                                    </div>

                                    {/* সেকশন ৩: BOTTOM WHOLESALE BANNER */}
                                    <div className="space-y-4 border-t pt-4">
                                        <h4 className="text-xs font-black text-[#183928] uppercase tracking-wider border-b pb-2">
                                            3. BOTTOM WHOLESALE BANNER
                                        </h4>
                                        <div>
                                            <label className="text-xs font-bold text-gray-700 block mb-1">
                                                Banner Headline
                                            </label>
                                            <input
                                                type="text"
                                                value={
                                                    contactPageData.wholesale_banner_title
                                                }
                                                onChange={(e) =>
                                                    setContactPageData({
                                                        ...contactPageData,
                                                        wholesale_banner_title:
                                                            e.target.value,
                                                    })
                                                }
                                                className="w-full text-sm rounded-2xl border-gray-200 p-3.5"
                                            />
                                        </div>

                                        <div>
                                            <label className="text-xs font-bold text-gray-700 block mb-1">
                                                Banner Description
                                            </label>
                                            <textarea
                                                rows={2}
                                                value={
                                                    contactPageData.wholesale_banner_desc
                                                }
                                                onChange={(e) =>
                                                    setContactPageData({
                                                        ...contactPageData,
                                                        wholesale_banner_desc:
                                                            e.target.value,
                                                    })
                                                }
                                                className="w-full text-sm rounded-2xl border-gray-200 p-3.5"
                                            />
                                        </div>
                                    </div>

                                    <button
                                        type="submit"
                                        className="w-full sm:w-auto bg-[#183928] text-white text-xs sm:text-sm md:font-bold px-3 sm:px-6 py-3.5 rounded-2xl hover:bg-[#122c1f] flex items-center justify-center gap-2 cursor-pointer shadow-md transition-colors"
                                    >
                                        <Save className="w-4 h-4 shrink-0" />

                                        <span className="whitespace-nowrap">
                                            Save Contact Us Page Settings
                                        </span>
                                    </button>
                                </form>
                            )}

                            {/* ৫. ABOUT US PAGE CMS */}
                            {activeSection === "about" && (
                                <form
                                    onSubmit={submitAbout}
                                    className="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-emerald-900/5 space-y-6"
                                >
                                    <div>
                                        <h3 className="text-lg font-black text-[#112318]">
                                            About Us Page CMS Manager
                                        </h3>
                                        <p className="text-xs text-gray-500">
                                            Edit hero texts, brand story,
                                            pillars, and timeline steps for the
                                            live About Us page.
                                        </p>
                                    </div>

                                    {/* হিরো টেক্সট */}
                                    <div className="space-y-4">
                                        <h4 className="text-xs font-black text-[#183928] uppercase tracking-wider border-b pb-2">
                                            1. Hero & Story Texts
                                        </h4>
                                        <div className="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                            <div>
                                                <label className="text-xs font-bold text-gray-700 block mb-1">
                                                    Badge Text
                                                </label>
                                                <input
                                                    type="text"
                                                    value={aboutData.badge}
                                                    onChange={(e) =>
                                                        setAboutData({
                                                            ...aboutData,
                                                            badge: e.target
                                                                .value,
                                                        })
                                                    }
                                                    className="w-full text-xs rounded-xl border-gray-200 p-3"
                                                />
                                            </div>
                                            <div>
                                                <label className="text-xs font-bold text-gray-700 block mb-1">
                                                    Title Line
                                                </label>
                                                <input
                                                    type="text"
                                                    value={aboutData.title}
                                                    onChange={(e) =>
                                                        setAboutData({
                                                            ...aboutData,
                                                            title: e.target
                                                                .value,
                                                        })
                                                    }
                                                    className="w-full text-xs rounded-xl border-gray-200 p-3"
                                                />
                                            </div>
                                            <div>
                                                <label className="text-xs font-bold text-gray-700 block mb-1">
                                                    Highlight Line
                                                </label>
                                                <input
                                                    type="text"
                                                    value={aboutData.highlight}
                                                    onChange={(e) =>
                                                        setAboutData({
                                                            ...aboutData,
                                                            highlight:
                                                                e.target.value,
                                                        })
                                                    }
                                                    className="w-full text-xs rounded-xl border-gray-200 p-3"
                                                />
                                            </div>
                                        </div>

                                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <div>
                                                <label className="text-xs font-bold text-gray-700 block mb-1">
                                                    Paragraph 1
                                                </label>
                                                <textarea
                                                    rows={3}
                                                    value={aboutData.desc_1}
                                                    onChange={(e) =>
                                                        setAboutData({
                                                            ...aboutData,
                                                            desc_1: e.target
                                                                .value,
                                                        })
                                                    }
                                                    className="w-full text-xs rounded-xl border-gray-200 p-3"
                                                />
                                            </div>
                                            <div>
                                                <label className="text-xs font-bold text-gray-700 block mb-1">
                                                    Paragraph 2
                                                </label>
                                                <textarea
                                                    rows={3}
                                                    value={aboutData.desc_2}
                                                    onChange={(e) =>
                                                        setAboutData({
                                                            ...aboutData,
                                                            desc_2: e.target
                                                                .value,
                                                        })
                                                    }
                                                    className="w-full text-xs rounded-xl border-gray-200 p-3"
                                                />
                                            </div>
                                        </div>

                                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <div>
                                                <label className="text-xs font-bold text-gray-700 block mb-1">
                                                    Hero Image URL
                                                </label>
                                                <input
                                                    type="text"
                                                    value={aboutData.hero_image}
                                                    onChange={(e) =>
                                                        setAboutData({
                                                            ...aboutData,
                                                            hero_image:
                                                                e.target.value,
                                                        })
                                                    }
                                                    className="w-full text-xs rounded-xl border-gray-200 p-3"
                                                />
                                            </div>
                                            <div>
                                                <label className="text-xs font-bold text-gray-700 block mb-1">
                                                    Or Upload Hero Image
                                                </label>
                                                <input
                                                    type="file"
                                                    accept="image/*"
                                                    onChange={(e) =>
                                                        router.post(
                                                            "/admin/settings",
                                                            {
                                                                about_page: {
                                                                    ...aboutData,
                                                                },
                                                                about_hero_file:
                                                                    e.target
                                                                        .files[0],
                                                            },
                                                            {
                                                                preserveScroll: true,
                                                                forceFormData: true,
                                                            },
                                                        )
                                                    }
                                                    className="w-full text-xs file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-[#183928] file:text-white cursor-pointer"
                                                />
                                            </div>
                                        </div>

                                        <div className="grid grid-cols-3 gap-4">
                                            <div>
                                                <label className="text-xs font-bold block mb-1">
                                                    Stat 1
                                                </label>
                                                <input
                                                    type="text"
                                                    value={aboutData.stat_1_val}
                                                    onChange={(e) =>
                                                        setAboutData({
                                                            ...aboutData,
                                                            stat_1_val:
                                                                e.target.value,
                                                        })
                                                    }
                                                    className="w-full text-xs rounded-xl border-gray-200 p-2"
                                                />
                                                <input
                                                    type="text"
                                                    value={
                                                        aboutData.stat_1_label
                                                    }
                                                    onChange={(e) =>
                                                        setAboutData({
                                                            ...aboutData,
                                                            stat_1_label:
                                                                e.target.value,
                                                        })
                                                    }
                                                    className="w-full text-xs rounded-xl border-gray-200 p-2 mt-1"
                                                />
                                            </div>
                                            <div>
                                                <label className="text-xs font-bold block mb-1">
                                                    Stat 2
                                                </label>
                                                <input
                                                    type="text"
                                                    value={aboutData.stat_2_val}
                                                    onChange={(e) =>
                                                        setAboutData({
                                                            ...aboutData,
                                                            stat_2_val:
                                                                e.target.value,
                                                        })
                                                    }
                                                    className="w-full text-xs rounded-xl border-gray-200 p-2"
                                                />
                                                <input
                                                    type="text"
                                                    value={
                                                        aboutData.stat_2_label
                                                    }
                                                    onChange={(e) =>
                                                        setAboutData({
                                                            ...aboutData,
                                                            stat_2_label:
                                                                e.target.value,
                                                        })
                                                    }
                                                    className="w-full text-xs rounded-xl border-gray-200 p-2 mt-1"
                                                />
                                            </div>
                                            <div>
                                                <label className="text-xs font-bold block mb-1">
                                                    Stat 3
                                                </label>
                                                <input
                                                    type="text"
                                                    value={aboutData.stat_3_val}
                                                    onChange={(e) =>
                                                        setAboutData({
                                                            ...aboutData,
                                                            stat_3_val:
                                                                e.target.value,
                                                        })
                                                    }
                                                    className="w-full text-xs rounded-xl border-gray-200 p-2"
                                                />
                                                <input
                                                    type="text"
                                                    value={
                                                        aboutData.stat_3_label
                                                    }
                                                    onChange={(e) =>
                                                        setAboutData({
                                                            ...aboutData,
                                                            stat_3_label:
                                                                e.target.value,
                                                        })
                                                    }
                                                    className="w-full text-xs rounded-xl border-gray-200 p-2 mt-1"
                                                />
                                            </div>
                                        </div>
                                    </div>

                                    {/* কোর পিলার্স */}
                                    <div className="space-y-4 border-t pt-4">
                                        <h4 className="text-xs font-black text-[#183928] uppercase tracking-wider border-b pb-2">
                                            2. Core Pillars (4 Cards)
                                        </h4>
                                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            {(aboutData.pillars || []).map(
                                                (pillar, idx) => (
                                                    <div
                                                        key={idx}
                                                        className="p-4 bg-[#f4faf4] rounded-2xl border space-y-2"
                                                    >
                                                        <label className="text-xs font-bold block">
                                                            Pillar #{idx + 1}
                                                        </label>
                                                        <input
                                                            type="text"
                                                            value={pillar.title}
                                                            onChange={(e) => {
                                                                const next = [
                                                                    ...aboutData.pillars,
                                                                ];
                                                                next[
                                                                    idx
                                                                ].title =
                                                                    e.target.value;
                                                                setAboutData({
                                                                    ...aboutData,
                                                                    pillars:
                                                                        next,
                                                                });
                                                            }}
                                                            className="w-full text-xs rounded-xl border-gray-200 p-2 font-bold"
                                                        />
                                                        <textarea
                                                            rows={2}
                                                            value={pillar.desc}
                                                            onChange={(e) => {
                                                                const next = [
                                                                    ...aboutData.pillars,
                                                                ];
                                                                next[idx].desc =
                                                                    e.target.value;
                                                                setAboutData({
                                                                    ...aboutData,
                                                                    pillars:
                                                                        next,
                                                                });
                                                            }}
                                                            className="w-full text-xs rounded-xl border-gray-200 p-2"
                                                        />
                                                    </div>
                                                ),
                                            )}
                                        </div>
                                    </div>

                                    {/* টাইমলাইন */}

                                    <div className="space-y-4 border-t pt-4">
                                        <h4 className="text-xs font-black text-[#183928] uppercase tracking-wider border-b pb-2">
                                            3. Brewing Process Timeline (4
                                            Steps)
                                        </h4>

                                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            {(aboutData.timeline || []).map(
                                                (step, idx) => (
                                                    <div
                                                        key={idx}
                                                        className="p-3 sm:p-4 bg-[#f4faf4] rounded-2xl border space-y-2"
                                                    >
                                                        {/* Step + Title */}
                                                        <div className="flex flex-col sm:flex-row gap-2">
                                                            {/* Step Number */}
                                                            <input
                                                                type="text"
                                                                value={
                                                                    step.step
                                                                }
                                                                onChange={(
                                                                    e,
                                                                ) => {
                                                                    const next =
                                                                        [
                                                                            ...aboutData.timeline,
                                                                        ];

                                                                    next[
                                                                        idx
                                                                    ].step =
                                                                        e.target.value;

                                                                    setAboutData(
                                                                        {
                                                                            ...aboutData,
                                                                            timeline:
                                                                                next,
                                                                        },
                                                                    );
                                                                }}
                                                                className="w-full sm:w-16 text-xs rounded-xl border-gray-200 p-2.5 font-black text-center"
                                                                placeholder="Step"
                                                            />

                                                            {/* Title */}
                                                            <input
                                                                type="text"
                                                                value={
                                                                    step.title
                                                                }
                                                                onChange={(
                                                                    e,
                                                                ) => {
                                                                    const next =
                                                                        [
                                                                            ...aboutData.timeline,
                                                                        ];

                                                                    next[
                                                                        idx
                                                                    ].title =
                                                                        e.target.value;

                                                                    setAboutData(
                                                                        {
                                                                            ...aboutData,
                                                                            timeline:
                                                                                next,
                                                                        },
                                                                    );
                                                                }}
                                                                className="w-full min-w-0 flex-1 text-xs rounded-xl border-gray-200 p-2.5 font-bold"
                                                                placeholder="Step title"
                                                            />
                                                        </div>

                                                        {/* Description */}
                                                        <textarea
                                                            rows={3}
                                                            value={step.desc}
                                                            onChange={(e) => {
                                                                const next = [
                                                                    ...aboutData.timeline,
                                                                ];

                                                                next[idx].desc =
                                                                    e.target.value;

                                                                setAboutData({
                                                                    ...aboutData,
                                                                    timeline:
                                                                        next,
                                                                });
                                                            }}
                                                            className="w-full min-w-0 text-xs rounded-xl border-gray-200 p-2.5 resize-none"
                                                            placeholder="Describe this brewing step..."
                                                        />
                                                    </div>
                                                ),
                                            )}
                                        </div>
                                    </div>

                                    <button
                                        type="submit"
                                        className="bg-[#183928] text-white text-xs md:font-bold px-6 py-3.5 rounded-xl hover:bg-[#122c1f] flex items-center md:gap-2 gap-1.5 cursor-pointer shadow"
                                    >
                                        <Save className="w-4 h-4" />
                                        <span>Save About Us Page Settings</span>
                                    </button>
                                </form>
                            )}

                            {/* ৬. HEADER & LOGO SECTION */}
                            {activeSection === "header" && (
                                <div className="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-emerald-900/5 space-y-6">
                                    <div>
                                        <h3 className="text-lg font-black text-[#112318]">
                                            Header & Branding Setup
                                        </h3>
                                        <p className="text-xs text-gray-500">
                                            Update logo, brand name and header
                                            hotline.
                                        </p>
                                    </div>

                                    <form
                                        onSubmit={submitHeader}
                                        className="space-y-4"
                                    >
                                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <div>
                                                <label className="text-xs font-bold text-gray-700 block mb-1">
                                                    Brand Name
                                                </label>
                                                <input
                                                    type="text"
                                                    value={
                                                        headerForm.data
                                                            .brand_name
                                                    }
                                                    onChange={(e) =>
                                                        headerForm.setData(
                                                            "brand_name",
                                                            e.target.value,
                                                        )
                                                    }
                                                    className="w-full text-xs rounded-xl border-gray-200 p-3"
                                                />
                                            </div>
                                            <div>
                                                <label className="text-xs font-bold text-gray-700 block mb-1">
                                                    Header Top Hotline
                                                </label>
                                                <input
                                                    type="text"
                                                    value={
                                                        headerForm.data
                                                            .header_phone
                                                    }
                                                    onChange={(e) =>
                                                        headerForm.setData(
                                                            "header_phone",
                                                            e.target.value,
                                                        )
                                                    }
                                                    className="w-full text-xs rounded-xl border-gray-200 p-3"
                                                />
                                            </div>
                                        </div>

                                        <div className="p-4 rounded-2xl bg-[#f4faf4] border border-emerald-900/10 space-y-3">
                                            <label className="text-xs font-black text-[#183928] uppercase tracking-wider block">
                                                Website Logo
                                            </label>
                                            <div className="flex gap-4">
                                                <label className="flex items-center gap-1.5 text-xs font-bold cursor-pointer">
                                                    <input
                                                        type="radio"
                                                        checked={
                                                            headerForm.data
                                                                .logo_type ===
                                                            "url"
                                                        }
                                                        onChange={() =>
                                                            headerForm.setData(
                                                                "logo_type",
                                                                "url",
                                                            )
                                                        }
                                                    />
                                                    <span>Logo Link (URL)</span>
                                                </label>
                                                <label className="flex items-center gap-1.5 text-xs font-bold cursor-pointer">
                                                    <input
                                                        type="radio"
                                                        checked={
                                                            headerForm.data
                                                                .logo_type ===
                                                            "file"
                                                        }
                                                        onChange={() =>
                                                            headerForm.setData(
                                                                "logo_type",
                                                                "file",
                                                            )
                                                        }
                                                    />
                                                    <span>Upload File</span>
                                                </label>
                                            </div>

                                            {headerForm.data.logo_type ===
                                            "url" ? (
                                                <input
                                                    type="text"
                                                    value={
                                                        headerForm.data.logo_url
                                                    }
                                                    onChange={(e) =>
                                                        headerForm.setData(
                                                            "logo_url",
                                                            e.target.value,
                                                        )
                                                    }
                                                    className="w-full text-xs rounded-xl border-gray-200 p-3"
                                                />
                                            ) : (
                                                <input
                                                    type="file"
                                                    accept="image/*"
                                                    onChange={(e) =>
                                                        headerForm.setData(
                                                            "logo_file",
                                                            e.target.files[0],
                                                        )
                                                    }
                                                    className="w-full text-xs file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-[#183928] file:text-white cursor-pointer"
                                                />
                                            )}
                                        </div>

                                        <button
                                            type="submit"
                                            disabled={headerForm.processing}
                                            className="bg-[#183928] text-white text-xs font-bold px-5 py-2.5 rounded-xl shadow flex items-center gap-2 hover:bg-[#122c1f]"
                                        >
                                            <Save className="w-4 h-4" />
                                            <span>
                                                {headerForm.processing
                                                    ? "Saving..."
                                                    : "Save Header Settings"}
                                            </span>
                                        </button>
                                    </form>
                                </div>
                            )}

                            {/* ৭. FOOTER & CONTACT LINES */}
                            {activeSection === "contact" && (
                                <div className="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-emerald-900/5 space-y-6">
                                    <div>
                                        <h3 className="text-lg font-black text-[#112318]">
                                            Footer & Contact Management
                                        </h3>
                                        <p className="text-xs text-gray-500">
                                            Manage contact numbers, social media
                                            links, wholesale banner, signature
                                            blends, and BSTI QR verification.
                                        </p>
                                    </div>

                                    <form
                                        onSubmit={submitContact}
                                        className="space-y-6"
                                    >
                                        {/* সেকশন ১: যোগাযোগ নম্বর ও অফিস */}
                                        <div className="space-y-4">
                                            <h4 className="text-xs font-black text-[#183928] uppercase tracking-wider border-b pb-2">
                                                1. Contact Hotlines & Location
                                            </h4>
                                            <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                <div>
                                                    <label className="text-xs font-bold text-gray-700 block mb-1">
                                                        Primary Helpline (Call
                                                        button on Footer)
                                                    </label>
                                                    <input
                                                        type="text"
                                                        value={
                                                            contactForm.data
                                                                .phone_primary
                                                        }
                                                        onChange={(e) =>
                                                            contactForm.setData(
                                                                "phone_primary",
                                                                e.target.value,
                                                            )
                                                        }
                                                        className="w-full text-xs rounded-xl border-gray-200 p-3"
                                                    />
                                                </div>
                                                <div>
                                                    <label className="text-xs font-bold text-gray-700 block mb-1">
                                                        Secondary / Distribution
                                                        Hotline (Leave blank to
                                                        hide)
                                                    </label>
                                                    <input
                                                        type="text"
                                                        placeholder="e.g. 018265-813373"
                                                        value={
                                                            contactForm.data
                                                                .phone_secondary
                                                        }
                                                        onChange={(e) =>
                                                            contactForm.setData(
                                                                "phone_secondary",
                                                                e.target.value,
                                                            )
                                                        }
                                                        className="w-full text-xs rounded-xl border-gray-200 p-3"
                                                    />
                                                </div>
                                                <div>
                                                    <label className="text-xs font-bold text-gray-700 block mb-1">
                                                        WhatsApp Number (e.g.
                                                        +8801306312372)
                                                    </label>
                                                    <input
                                                        type="text"
                                                        value={
                                                            contactForm.data
                                                                .whatsapp_number
                                                        }
                                                        onChange={(e) =>
                                                            contactForm.setData(
                                                                "whatsapp_number",
                                                                e.target.value,
                                                            )
                                                        }
                                                        className="w-full text-xs rounded-xl border-gray-200 p-3"
                                                    />
                                                </div>
                                                <div>
                                                    <label className="text-xs font-bold text-gray-700 block mb-1">
                                                        Official Email
                                                    </label>
                                                    <input
                                                        type="email"
                                                        value={
                                                            contactForm.data
                                                                .email
                                                        }
                                                        onChange={(e) =>
                                                            contactForm.setData(
                                                                "email",
                                                                e.target.value,
                                                            )
                                                        }
                                                        className="w-full text-xs rounded-xl border-gray-200 p-3"
                                                    />
                                                </div>
                                            </div>

                                            <div>
                                                <label className="text-xs font-bold text-gray-700 block mb-1">
                                                    Office & Production Address
                                                </label>
                                                <input
                                                    type="text"
                                                    value={
                                                        contactForm.data.address
                                                    }
                                                    onChange={(e) =>
                                                        contactForm.setData(
                                                            "address",
                                                            e.target.value,
                                                        )
                                                    }
                                                    className="w-full text-xs rounded-xl border-gray-200 p-3"
                                                />
                                            </div>
                                        </div>

                                        {/* সেকশন ২: ব্র্যান্ড বায়ো ও সোশ্যাল মিডিয়া (৬টি সোশ্যাল প্ল্যাটফর্ম) */}
                                        <div className="space-y-4 border-t pt-4">
                                            <h4 className="text-xs font-black text-[#183928] uppercase tracking-wider border-b pb-2">
                                                2. Brand Bio & Social Profiles
                                                (Leave empty to hide)
                                            </h4>

                                            <div>
                                                <label className="text-xs font-bold text-gray-700 block mb-1">
                                                    Footer Brand Bio Description
                                                </label>
                                                <textarea
                                                    rows={2}
                                                    value={
                                                        contactForm.data
                                                            .footer_settings.bio
                                                    }
                                                    onChange={(e) =>
                                                        contactForm.setData(
                                                            "footer_settings",
                                                            {
                                                                ...contactForm
                                                                    .data
                                                                    .footer_settings,
                                                                bio: e.target
                                                                    .value,
                                                            },
                                                        )
                                                    }
                                                    className="w-full text-xs rounded-xl border-gray-200 p-3"
                                                />
                                            </div>

                                            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                                <div>
                                                    <label className="text-xs font-bold text-gray-700 block mb-1">
                                                        Facebook Page URL
                                                    </label>
                                                    <input
                                                        type="text"
                                                        placeholder="https://facebook.com/..."
                                                        value={
                                                            contactForm.data
                                                                .footer_settings
                                                                .facebook_url
                                                        }
                                                        onChange={(e) =>
                                                            contactForm.setData(
                                                                "footer_settings",
                                                                {
                                                                    ...contactForm
                                                                        .data
                                                                        .footer_settings,
                                                                    facebook_url:
                                                                        e.target
                                                                            .value,
                                                                },
                                                            )
                                                        }
                                                        className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                                    />
                                                </div>
                                                <div>
                                                    <label className="text-xs font-bold text-gray-700 block mb-1">
                                                        Instagram Profile URL
                                                    </label>
                                                    <input
                                                        type="text"
                                                        placeholder="https://instagram.com/..."
                                                        value={
                                                            contactForm.data
                                                                .footer_settings
                                                                .instagram_url
                                                        }
                                                        onChange={(e) =>
                                                            contactForm.setData(
                                                                "footer_settings",
                                                                {
                                                                    ...contactForm
                                                                        .data
                                                                        .footer_settings,
                                                                    instagram_url:
                                                                        e.target
                                                                            .value,
                                                                },
                                                            )
                                                        }
                                                        className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                                    />
                                                </div>
                                                <div>
                                                    <label className="text-xs font-bold text-gray-700 block mb-1">
                                                        YouTube Channel URL
                                                    </label>
                                                    <input
                                                        type="text"
                                                        placeholder="https://youtube.com/..."
                                                        value={
                                                            contactForm.data
                                                                .footer_settings
                                                                .youtube_url
                                                        }
                                                        onChange={(e) =>
                                                            contactForm.setData(
                                                                "footer_settings",
                                                                {
                                                                    ...contactForm
                                                                        .data
                                                                        .footer_settings,
                                                                    youtube_url:
                                                                        e.target
                                                                            .value,
                                                                },
                                                            )
                                                        }
                                                        className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                                    />
                                                </div>
                                                <div>
                                                    <label className="text-xs font-bold text-gray-700 block mb-1">
                                                        TikTok Profile URL
                                                    </label>
                                                    <input
                                                        type="text"
                                                        placeholder="https://tiktok.com/@..."
                                                        value={
                                                            contactForm.data
                                                                .footer_settings
                                                                .tiktok_url
                                                        }
                                                        onChange={(e) =>
                                                            contactForm.setData(
                                                                "footer_settings",
                                                                {
                                                                    ...contactForm
                                                                        .data
                                                                        .footer_settings,
                                                                    tiktok_url:
                                                                        e.target
                                                                            .value,
                                                                },
                                                            )
                                                        }
                                                        className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                                    />
                                                </div>
                                                <div>
                                                    <label className="text-xs font-bold text-gray-700 block mb-1">
                                                        LinkedIn Company URL
                                                    </label>
                                                    <input
                                                        type="text"
                                                        placeholder="https://linkedin.com/company/..."
                                                        value={
                                                            contactForm.data
                                                                .footer_settings
                                                                .linkedin_url
                                                        }
                                                        onChange={(e) =>
                                                            contactForm.setData(
                                                                "footer_settings",
                                                                {
                                                                    ...contactForm
                                                                        .data
                                                                        .footer_settings,
                                                                    linkedin_url:
                                                                        e.target
                                                                            .value,
                                                                },
                                                            )
                                                        }
                                                        className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                                    />
                                                </div>
                                                <div>
                                                    <label className="text-xs font-bold text-gray-700 block mb-1">
                                                        Twitter / X URL
                                                    </label>
                                                    <input
                                                        type="text"
                                                        placeholder="https://x.com/..."
                                                        value={
                                                            contactForm.data
                                                                .footer_settings
                                                                .twitter_url
                                                        }
                                                        onChange={(e) =>
                                                            contactForm.setData(
                                                                "footer_settings",
                                                                {
                                                                    ...contactForm
                                                                        .data
                                                                        .footer_settings,
                                                                    twitter_url:
                                                                        e.target
                                                                            .value,
                                                                },
                                                            )
                                                        }
                                                        className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                                    />
                                                </div>
                                            </div>
                                        </div>

                                        {/* সেকশন ৩: Signature Blends */}
                                        <div className="space-y-4 border-t pt-4">
                                            <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 border-b pb-2">
                                                <div className="min-w-0">
                                                    <h4 className="text-xs font-black text-[#183928] uppercase tracking-wider">
                                                        3. Footer Signature
                                                        Blends List
                                                    </h4>

                                                    <p className="text-[11px] text-gray-500 mt-1 leading-relaxed">
                                                        Add or edit the
                                                        quick-access drink links
                                                        displayed in the footer
                                                        column.
                                                    </p>
                                                </div>

                                                <button
                                                    type="button"
                                                    onClick={() => {
                                                        const current =
                                                            contactForm.data
                                                                .footer_settings
                                                                .signature_blends ||
                                                            [];

                                                        contactForm.setData(
                                                            "footer_settings",
                                                            {
                                                                ...contactForm
                                                                    .data
                                                                    .footer_settings,
                                                                signature_blends:
                                                                    [
                                                                        ...current,
                                                                        {
                                                                            name: "",
                                                                            url: "",
                                                                        },
                                                                    ],
                                                            },
                                                        );
                                                    }}
                                                    className="w-full sm:w-auto shrink-0 text-xs bg-emerald-100 text-[#183928] font-bold px-3 py-2 sm:py-1.5 rounded-lg flex items-center justify-center gap-1 cursor-pointer hover:bg-emerald-200 transition-colors"
                                                >
                                                    <Plus className="w-3.5 h-3.5 shrink-0" />
                                                    <span className="whitespace-nowrap">
                                                        Add Blend Link
                                                    </span>
                                                </button>
                                            </div>

                                            <div className="space-y-3">
                                                {(
                                                    contactForm.data
                                                        .footer_settings
                                                        .signature_blends || []
                                                ).map((blend, idx) => (
                                                    <div
                                                        key={idx}
                                                        className="p-3 bg-[#f4faf4] rounded-xl border border-emerald-900/10 flex items-center gap-3"
                                                    >
                                                        <div className="flex-1">
                                                            <input
                                                                type="text"
                                                                placeholder="Drink Name (e.g. Hozmi Cola)"
                                                                value={
                                                                    blend.name
                                                                }
                                                                onChange={(
                                                                    e,
                                                                ) => {
                                                                    const next =
                                                                        [
                                                                            ...contactForm
                                                                                .data
                                                                                .footer_settings
                                                                                .signature_blends,
                                                                        ];
                                                                    next[
                                                                        idx
                                                                    ].name =
                                                                        e.target.value;
                                                                    contactForm.setData(
                                                                        "footer_settings",
                                                                        {
                                                                            ...contactForm
                                                                                .data
                                                                                .footer_settings,
                                                                            signature_blends:
                                                                                next,
                                                                        },
                                                                    );
                                                                }}
                                                                className="w-full text-xs rounded-xl border-gray-200 p-2 font-bold"
                                                            />
                                                        </div>
                                                        <div className="flex-1">
                                                            <input
                                                                type="text"
                                                                placeholder="Link URL (e.g. /products/hozmi-cola)"
                                                                value={
                                                                    blend.url
                                                                }
                                                                onChange={(
                                                                    e,
                                                                ) => {
                                                                    const next =
                                                                        [
                                                                            ...contactForm
                                                                                .data
                                                                                .footer_settings
                                                                                .signature_blends,
                                                                        ];
                                                                    next[
                                                                        idx
                                                                    ].url =
                                                                        e.target.value;
                                                                    contactForm.setData(
                                                                        "footer_settings",
                                                                        {
                                                                            ...contactForm
                                                                                .data
                                                                                .footer_settings,
                                                                            signature_blends:
                                                                                next,
                                                                        },
                                                                    );
                                                                }}
                                                                className="w-full text-xs rounded-xl border-gray-200 p-2"
                                                            />
                                                        </div>
                                                        <button
                                                            type="button"
                                                            onClick={() => {
                                                                const next =
                                                                    contactForm.data.footer_settings.signature_blends.filter(
                                                                        (
                                                                            _,
                                                                            i,
                                                                        ) =>
                                                                            i !==
                                                                            idx,
                                                                    );
                                                                contactForm.setData(
                                                                    "footer_settings",
                                                                    {
                                                                        ...contactForm
                                                                            .data
                                                                            .footer_settings,
                                                                        signature_blends:
                                                                            next,
                                                                    },
                                                                );
                                                            }}
                                                            className="p-1.5 text-red-500 hover:bg-red-50 rounded-lg cursor-pointer"
                                                        >
                                                            <Trash2 className="w-4 h-4" />
                                                        </button>
                                                    </div>
                                                ))}
                                            </div>
                                        </div>

                                        {/* সেকশন ৪: Wholesale Order Card ও BSTI QR Code */}
                                        <div className="space-y-4 border-t pt-4">
                                            <h4 className="text-xs font-black text-[#183928] uppercase tracking-wider border-b pb-2">
                                                4. Wholesale Card & Verification
                                                QR Code
                                            </h4>

                                            <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                <div>
                                                    <label className="text-xs font-bold text-gray-700 block mb-1">
                                                        Card Badge Text
                                                    </label>
                                                    <input
                                                        type="text"
                                                        value={
                                                            contactForm.data
                                                                .footer_settings
                                                                .wholesale_badge
                                                        }
                                                        onChange={(e) =>
                                                            contactForm.setData(
                                                                "footer_settings",
                                                                {
                                                                    ...contactForm
                                                                        .data
                                                                        .footer_settings,
                                                                    wholesale_badge:
                                                                        e.target
                                                                            .value,
                                                                },
                                                            )
                                                        }
                                                        className="w-full text-xs rounded-xl border-gray-200 p-3"
                                                    />
                                                </div>
                                                <div>
                                                    <label className="text-xs font-bold text-gray-700 block mb-1">
                                                        Card Title Headline
                                                    </label>
                                                    <input
                                                        type="text"
                                                        value={
                                                            contactForm.data
                                                                .footer_settings
                                                                .wholesale_title
                                                        }
                                                        onChange={(e) =>
                                                            contactForm.setData(
                                                                "footer_settings",
                                                                {
                                                                    ...contactForm
                                                                        .data
                                                                        .footer_settings,
                                                                    wholesale_title:
                                                                        e.target
                                                                            .value,
                                                                },
                                                            )
                                                        }
                                                        className="w-full text-xs rounded-xl border-gray-200 p-3"
                                                    />
                                                </div>
                                            </div>

                                            <div>
                                                <label className="text-xs font-bold text-gray-700 block mb-1">
                                                    Wholesale Card Description
                                                </label>
                                                <textarea
                                                    rows={2}
                                                    value={
                                                        contactForm.data
                                                            .footer_settings
                                                            .wholesale_desc
                                                    }
                                                    onChange={(e) =>
                                                        contactForm.setData(
                                                            "footer_settings",
                                                            {
                                                                ...contactForm
                                                                    .data
                                                                    .footer_settings,
                                                                wholesale_desc:
                                                                    e.target
                                                                        .value,
                                                            },
                                                        )
                                                    }
                                                    className="w-full text-xs rounded-xl border-gray-200 p-3"
                                                />
                                            </div>

                                            {/* QR Code Settings */}
                                            <div className="p-4 rounded-2xl bg-[#f4faf4] border border-emerald-900/10 space-y-3">
                                                <label className="text-xs font-black text-[#183928] uppercase tracking-wider block">
                                                    Verification QR Code &
                                                    Certificate Badge
                                                </label>

                                                <div className="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                                    <div>
                                                        <label className="text-[11px] font-bold text-gray-600 block mb-1">
                                                            QR Badge (e.g. BSTI
                                                            Certified)
                                                        </label>
                                                        <input
                                                            type="text"
                                                            value={
                                                                contactForm.data
                                                                    .footer_settings
                                                                    .qr_badge
                                                            }
                                                            onChange={(e) =>
                                                                contactForm.setData(
                                                                    "footer_settings",
                                                                    {
                                                                        ...contactForm
                                                                            .data
                                                                            .footer_settings,
                                                                        qr_badge:
                                                                            e
                                                                                .target
                                                                                .value,
                                                                    },
                                                                )
                                                            }
                                                            className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                                        />
                                                    </div>
                                                    <div>
                                                        <label className="text-[11px] font-bold text-gray-600 block mb-1">
                                                            QR Title (e.g. Scan
                                                            to Verify)
                                                        </label>
                                                        <input
                                                            type="text"
                                                            value={
                                                                contactForm.data
                                                                    .footer_settings
                                                                    .qr_title
                                                            }
                                                            onChange={(e) =>
                                                                contactForm.setData(
                                                                    "footer_settings",
                                                                    {
                                                                        ...contactForm
                                                                            .data
                                                                            .footer_settings,
                                                                        qr_title:
                                                                            e
                                                                                .target
                                                                                .value,
                                                                    },
                                                                )
                                                            }
                                                            className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                                        />
                                                    </div>
                                                    <div>
                                                        <label className="text-[11px] font-bold text-gray-600 block mb-1">
                                                            QR Subtitle / Detail
                                                        </label>
                                                        <input
                                                            type="text"
                                                            value={
                                                                contactForm.data
                                                                    .footer_settings
                                                                    .qr_desc
                                                            }
                                                            onChange={(e) =>
                                                                contactForm.setData(
                                                                    "footer_settings",
                                                                    {
                                                                        ...contactForm
                                                                            .data
                                                                            .footer_settings,
                                                                        qr_desc:
                                                                            e
                                                                                .target
                                                                                .value,
                                                                    },
                                                                )
                                                            }
                                                            className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                                        />
                                                    </div>
                                                </div>

                                                <div className="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                                                    <div>
                                                        <label className="text-[11px] font-bold text-gray-600 block mb-1">
                                                            QR Code Image Link
                                                            (URL)
                                                        </label>
                                                        <input
                                                            type="text"
                                                            placeholder="/images/qr-code.jpeg"
                                                            value={
                                                                contactForm.data
                                                                    .footer_settings
                                                                    .qr_image
                                                            }
                                                            onChange={(e) =>
                                                                contactForm.setData(
                                                                    "footer_settings",
                                                                    {
                                                                        ...contactForm
                                                                            .data
                                                                            .footer_settings,
                                                                        qr_image:
                                                                            e
                                                                                .target
                                                                                .value,
                                                                    },
                                                                )
                                                            }
                                                            className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                                        />
                                                    </div>
                                                    <div>
                                                        <label className="text-[11px] font-bold text-gray-600 block mb-1">
                                                            Or Upload QR Image
                                                            File
                                                        </label>
                                                        <input
                                                            type="file"
                                                            accept="image/*"
                                                            onChange={(e) =>
                                                                contactForm.setData(
                                                                    "qr_file",
                                                                    e.target
                                                                        .files[0],
                                                                )
                                                            }
                                                            className="w-full text-xs file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-[#183928] file:text-white cursor-pointer"
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <button
                                            type="submit"
                                            disabled={contactForm.processing}
                                            className="w-full sm:w-auto bg-[#183928] text-white text-xs font-bold px-4 sm:px-6 py-3.5 rounded-xl hover:bg-[#122c1f] flex items-center justify-center gap-2 cursor-pointer shadow transition-colors disabled:opacity-60 disabled:cursor-not-allowed"
                                        >
                                            <Save className="w-4 h-4 shrink-0" />

                                            <span className="whitespace-nowrap">
                                                {contactForm.processing
                                                    ? "Saving..."
                                                    : "Save All Footer & Contact Settings"}
                                            </span>
                                        </button>
                                    </form>
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </div>

            {/* নতুন ড্রিংক যোগ করার মডাল */}
            {showAddProductModal && (
                <div className="fixed inset-0 bg-black/60 backdrop-blur-xs flex items-center justify-center p-4 z-50">
                    <div className="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full space-y-4 max-h-[90vh] overflow-y-auto">
                        <div className="flex items-center justify-between border-b pb-3">
                            <h3 className="text-base font-black text-[#112318]">
                                Add New Botanical Drink
                            </h3>
                            <button
                                onClick={() => setShowAddProductModal(false)}
                                className="text-gray-400 hover:text-gray-600 font-bold"
                            >
                                ✕
                            </button>
                        </div>

                        <form onSubmit={submitNewProduct} className="space-y-3">
                            <div>
                                <label className="text-xs font-bold block mb-1">
                                    Drink Name *
                                </label>
                                <input
                                    type="text"
                                    required
                                    placeholder="e.g. Masala Lemonade"
                                    value={productForm.data.name}
                                    onChange={(e) =>
                                        productForm.setData(
                                            "name",
                                            e.target.value,
                                        )
                                    }
                                    className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                />
                            </div>

                            <div className="grid grid-cols-2 gap-3">
                                <div>
                                    <label className="text-xs font-bold block mb-1">
                                        Price *
                                    </label>
                                    <input
                                        type="text"
                                        required
                                        value={productForm.data.price}
                                        onChange={(e) =>
                                            productForm.setData(
                                                "price",
                                                e.target.value,
                                            )
                                        }
                                        className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                    />
                                </div>
                                <div>
                                    <label className="text-xs font-bold block mb-1">
                                        Net Volume *
                                    </label>
                                    <input
                                        type="text"
                                        required
                                        value={productForm.data.net_volume}
                                        onChange={(e) =>
                                            productForm.setData(
                                                "net_volume",
                                                e.target.value,
                                            )
                                        }
                                        className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                    />
                                </div>
                            </div>

                            <div className="grid grid-cols-2 gap-3">
                                <div>
                                    <label className="text-xs font-bold block mb-1">
                                        Category *
                                    </label>
                                    <select
                                        value={productForm.data.category}
                                        onChange={(e) =>
                                            productForm.setData(
                                                "category",
                                                e.target.value,
                                            )
                                        }
                                        className="w-full text-xs rounded-xl border-gray-200 p-2.5 font-bold"
                                    >
                                        <option value="digestive">
                                            Digestive & Gut
                                        </option>
                                        <option value="refreshing">
                                            Cooling & Tangy
                                        </option>
                                        <option value="immunity">
                                            Immunity Boost
                                        </option>
                                    </select>
                                </div>
                                <div>
                                    <label className="text-xs font-bold block mb-1">
                                        Key Ingredients (Comma separated)
                                    </label>
                                    <input
                                        type="text"
                                        placeholder="e.g. Mint Extract, Raw Mango"
                                        value={productForm.data.ingredients}
                                        onChange={(e) =>
                                            productForm.setData(
                                                "ingredients",
                                                e.target.value,
                                            )
                                        }
                                        className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                    />
                                </div>
                            </div>

                            <div className="grid grid-cols-2 gap-3">
                                <div>
                                    <label className="text-xs font-bold block mb-1">
                                        Manufacturer
                                    </label>
                                    <input
                                        type="text"
                                        value={productForm.data.manufacturer}
                                        onChange={(e) =>
                                            productForm.setData(
                                                "manufacturer",
                                                e.target.value,
                                            )
                                        }
                                        className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                    />
                                </div>
                                <div>
                                    <label className="text-xs font-bold block mb-1">
                                        Helpline Number
                                    </label>
                                    <input
                                        type="text"
                                        value={productForm.data.helpline}
                                        onChange={(e) =>
                                            productForm.setData(
                                                "helpline",
                                                e.target.value,
                                            )
                                        }
                                        className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                    />
                                </div>
                            </div>

                            <div>
                                <label className="text-xs font-bold block mb-1">
                                    Storage Instructions
                                </label>
                                <input
                                    type="text"
                                    value={productForm.data.storage}
                                    onChange={(e) =>
                                        productForm.setData(
                                            "storage",
                                            e.target.value,
                                        )
                                    }
                                    className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                />
                            </div>

                            <div className="p-3 bg-[#f4faf4] rounded-xl border space-y-2">
                                <label className="text-xs font-bold block">
                                    Product Image *
                                </label>
                                <div className="flex gap-4">
                                    <label className="flex items-center gap-1.5 text-xs font-bold cursor-pointer">
                                        <input
                                            type="radio"
                                            checked={
                                                productForm.data.image_type ===
                                                "url"
                                            }
                                            onChange={() =>
                                                productForm.setData(
                                                    "image_type",
                                                    "url",
                                                )
                                            }
                                        />
                                        <span>Image URL</span>
                                    </label>
                                    <label className="flex items-center gap-1.5 text-xs font-bold cursor-pointer">
                                        <input
                                            type="radio"
                                            checked={
                                                productForm.data.image_type ===
                                                "file"
                                            }
                                            onChange={() =>
                                                productForm.setData(
                                                    "image_type",
                                                    "file",
                                                )
                                            }
                                        />
                                        <span>Upload File</span>
                                    </label>
                                </div>

                                {productForm.data.image_type === "url" ? (
                                    <input
                                        type="text"
                                        placeholder="e.g. /images/hozmi-cola.jpeg"
                                        value={productForm.data.image_url}
                                        onChange={(e) =>
                                            productForm.setData(
                                                "image_url",
                                                e.target.value,
                                            )
                                        }
                                        className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                    />
                                ) : (
                                    <input
                                        type="file"
                                        accept="image/*"
                                        onChange={(e) =>
                                            productForm.setData(
                                                "image_file",
                                                e.target.files[0],
                                            )
                                        }
                                        className="w-full text-xs file:mr-4 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:bg-[#183928] file:text-white cursor-pointer"
                                    />
                                )}
                            </div>

                            <div>
                                <label className="text-xs font-bold block mb-1">
                                    Short Description *
                                </label>
                                <textarea
                                    rows={2}
                                    required
                                    value={productForm.data.short_description}
                                    onChange={(e) =>
                                        productForm.setData(
                                            "short_description",
                                            e.target.value,
                                        )
                                    }
                                    className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                />
                            </div>

                            <div className="flex justify-end gap-2 pt-2">
                                <button
                                    type="button"
                                    onClick={() =>
                                        setShowAddProductModal(false)
                                    }
                                    className="px-4 py-2 text-xs font-bold text-gray-500 hover:bg-gray-100 rounded-xl"
                                >
                                    Cancel
                                </button>
                                <button
                                    type="submit"
                                    disabled={productForm.processing}
                                    className="px-5 py-2 bg-[#183928] text-white text-xs font-bold rounded-xl cursor-pointer"
                                >
                                    {productForm.processing
                                        ? "Adding..."
                                        : "Save Drink"}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}

            {/* ড্রিংক এডিট করার মডাল */}
            {editingProduct && (
                <div className="fixed inset-0 bg-black/60 backdrop-blur-xs flex items-center justify-center p-4 z-50">
                    <div className="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full space-y-4 max-h-[90vh] overflow-y-auto">
                        <div className="flex items-center justify-between border-b pb-3">
                            <h3 className="text-base font-black text-[#112318]">
                                Edit Drink: {editingProduct.name}
                            </h3>
                            <button
                                onClick={() => setEditingProduct(null)}
                                className="text-gray-400 hover:text-gray-600 font-bold"
                            >
                                ✕
                            </button>
                        </div>

                        <form
                            onSubmit={submitEditProduct}
                            className="space-y-3"
                        >
                            <div>
                                <label className="text-xs font-bold block mb-1">
                                    Drink Name *
                                </label>
                                <input
                                    type="text"
                                    required
                                    value={editProductForm.data.name}
                                    onChange={(e) =>
                                        editProductForm.setData(
                                            "name",
                                            e.target.value,
                                        )
                                    }
                                    className="w-full text-xs rounded-xl border-gray-200 p-2.5 font-bold"
                                />
                            </div>

                            <div className="grid grid-cols-2 gap-3">
                                <div>
                                    <label className="text-xs font-bold block mb-1">
                                        Price *
                                    </label>
                                    <input
                                        type="text"
                                        required
                                        value={editProductForm.data.price}
                                        onChange={(e) =>
                                            editProductForm.setData(
                                                "price",
                                                e.target.value,
                                            )
                                        }
                                        className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                    />
                                </div>
                                <div>
                                    <label className="text-xs font-bold block mb-1">
                                        Net Volume *
                                    </label>
                                    <input
                                        type="text"
                                        required
                                        value={editProductForm.data.net_volume}
                                        onChange={(e) =>
                                            editProductForm.setData(
                                                "net_volume",
                                                e.target.value,
                                            )
                                        }
                                        className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                    />
                                </div>
                            </div>

                            <div className="grid grid-cols-2 gap-3">
                                <div>
                                    <label className="text-xs font-bold block mb-1">
                                        Category *
                                    </label>
                                    <select
                                        value={editProductForm.data.category}
                                        onChange={(e) =>
                                            editProductForm.setData(
                                                "category",
                                                e.target.value,
                                            )
                                        }
                                        className="w-full text-xs rounded-xl border-gray-200 p-2.5 font-bold"
                                    >
                                        <option value="digestive">
                                            Digestive & Gut
                                        </option>
                                        <option value="refreshing">
                                            Cooling & Tangy
                                        </option>
                                        <option value="immunity">
                                            Immunity Boost
                                        </option>
                                    </select>
                                </div>
                                <div>
                                    <label className="text-xs font-bold block mb-1">
                                        Key Ingredients (Comma separated)
                                    </label>
                                    <input
                                        type="text"
                                        value={editProductForm.data.ingredients}
                                        onChange={(e) =>
                                            editProductForm.setData(
                                                "ingredients",
                                                e.target.value,
                                            )
                                        }
                                        className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                    />
                                </div>
                            </div>

                            <div className="grid grid-cols-2 gap-3">
                                <div>
                                    <label className="text-xs font-bold block mb-1">
                                        Manufacturer
                                    </label>
                                    <input
                                        type="text"
                                        value={
                                            editProductForm.data.manufacturer
                                        }
                                        onChange={(e) =>
                                            editProductForm.setData(
                                                "manufacturer",
                                                e.target.value,
                                            )
                                        }
                                        className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                    />
                                </div>
                                <div>
                                    <label className="text-xs font-bold block mb-1">
                                        Helpline Number
                                    </label>
                                    <input
                                        type="text"
                                        value={editProductForm.data.helpline}
                                        onChange={(e) =>
                                            editProductForm.setData(
                                                "helpline",
                                                e.target.value,
                                            )
                                        }
                                        className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                    />
                                </div>
                            </div>

                            <div>
                                <label className="text-xs font-bold block mb-1">
                                    Storage Instructions
                                </label>
                                <input
                                    type="text"
                                    value={editProductForm.data.storage}
                                    onChange={(e) =>
                                        editProductForm.setData(
                                            "storage",
                                            e.target.value,
                                        )
                                    }
                                    className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                />
                            </div>

                            <div className="p-3 bg-[#f4faf4] rounded-xl border space-y-2">
                                <label className="text-xs font-bold block">
                                    Product Image URL / Path
                                </label>
                                <input
                                    type="text"
                                    value={editProductForm.data.image_url}
                                    onChange={(e) =>
                                        editProductForm.setData(
                                            "image_url",
                                            e.target.value,
                                        )
                                    }
                                    className="w-full text-xs rounded-xl border-gray-200 p-2.5 mb-2"
                                />
                                <input
                                    type="file"
                                    accept="image/*"
                                    onChange={(e) =>
                                        editProductForm.setData(
                                            "image_file",
                                            e.target.files[0],
                                        )
                                    }
                                    className="w-full text-xs file:mr-4 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:bg-[#183928] file:text-white cursor-pointer"
                                />
                            </div>

                            <div>
                                <label className="text-xs font-bold block mb-1">
                                    Short Description *
                                </label>
                                <textarea
                                    rows={2}
                                    required
                                    value={
                                        editProductForm.data.short_description
                                    }
                                    onChange={(e) =>
                                        editProductForm.setData(
                                            "short_description",
                                            e.target.value,
                                        )
                                    }
                                    className="w-full text-xs rounded-xl border-gray-200 p-2.5"
                                />
                            </div>

                            <div className="flex justify-end gap-2 pt-2">
                                <button
                                    type="button"
                                    onClick={() => setEditingProduct(null)}
                                    className="px-4 py-2 text-xs font-bold text-gray-500 hover:bg-gray-100 rounded-xl"
                                >
                                    Cancel
                                </button>
                                <button
                                    type="submit"
                                    disabled={editProductForm.processing}
                                    className="px-5 py-2 bg-[#183928] text-white text-xs font-bold rounded-xl cursor-pointer"
                                >
                                    {editProductForm.processing
                                        ? "Updating..."
                                        : "Save Changes"}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}
        </AuthenticatedLayout>
    );
}
