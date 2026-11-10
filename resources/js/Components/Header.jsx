import { useState, useEffect } from "react";
import { Link, usePage } from "@inertiajs/react";
import {
    Search,
    Menu,
    X,
    PhoneCall,
    ArrowRight,
    Sparkles,
    User, // লগইন আইকন যুক্ত করা হয়েছে
} from "lucide-react";
import { products } from "@/data/products";

const navLinks = [
    { name: "Home", href: "/" },
    { name: "About Us", href: "/about" },
    { name: "Our Drinks", href: "/our-drinks" },
    { name: "Contact Us", href: "/contact" },
];

const quickTags = ["Hozmi", "Mint", "Digestion", "Lemon", "Tamarind", "Detox"];

export default function Header() {
    const { settings, auth } = usePage().props;

    // ডায়নামিক সেটিংস ডাটা (না পেলে ডিফল্ট দেখাবে)
    const brandName = settings?.brand_name || "Pure Sip";
    const logoSrc = settings?.logo || "/images/logo.jpeg";
    const phone = settings?.header_phone || settings?.phone_primary || "01306-312372";

    const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
    const [searchOpen, setSearchOpen] = useState(false);
    const [searchQuery, setSearchQuery] = useState("");

    // Inertia.js দিয়ে কারেন্ট URL পাথ নেওয়া
    const { url: pathname } = usePage();

    useEffect(() => {
        const handleKeyDown = (e) => {
            if (e.key === "Escape") setSearchOpen(false);
        };
        window.addEventListener("keydown", handleKeyDown);
        return () => window.removeEventListener("keydown", handleKeyDown);
    }, []);

    const filteredResults =
        searchQuery.trim() === ""
            ? []
            : products.filter((item) => {
                  const query = searchQuery.toLowerCase();
                  const matchName = item.name.toLowerCase().includes(query);
                  const matchDesc = item.shortDescription
                      ?.toLowerCase()
                      .includes(query);
                  const matchIngredients = item.ingredients?.some((ing) =>
                      ing.name.toLowerCase().includes(query),
                  );
                  return matchName || matchDesc || matchIngredients;
              });

    return (
        <>
            <header className="w-full bg-[#f4faf4] sticky top-0 z-40">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 h-16 sm:h-20 flex items-center justify-between">
                    {/* লোগো ও ব্র্যান্ড নাম */}
                    <div className="flex items-center">
                        <Link
                            href="/"
                            className="flex items-center gap-2 sm:gap-3 group"
                        >
                            <div className="w-10 h-10 sm:w-12 sm:h-12 relative rounded-full overflow-hidden bg-white shadow-sm flex items-center justify-center transition-transform group-hover:scale-105">
                                <img
                                    src={logoSrc}
                                    alt={`${brandName} Logo`}
                                    className="w-full h-full object-contain p-1"
                                    onError={(e) => {
                                        e.target.src = "/images/logo.jpeg";
                                    }}
                                />
                            </div>
                            <div className="flex flex-col">
                                <span className="font-extrabold text-sm sm:text-base md:text-lg text-[#183928] tracking-wider uppercase leading-none">
                                    {brandName}
                                </span>
                                <span className="text-[10px] text-emerald-800 font-semibold tracking-widest mt-0.5">
                                    Beverage
                                </span>
                            </div>
                        </Link>
                    </div>

                    {/* ডেস্কটপ মেনু */}
                    <nav className="hidden md:flex items-center space-x-8 lg:space-x-10 text-sm">
                        {navLinks.map((link) => {
                            const isActive = pathname === link.href;

                            return (
                                <Link
                                    key={link.name}
                                    href={link.href}
                                    className={`relative py-1 transition-colors duration-200 ${
                                        isActive
                                            ? "font-extrabold text-[#183928]"
                                            : "font-medium text-[#183928]/70 hover:text-[#183928]"
                                    }`}
                                >
                                    {link.name}
                                    {isActive && (
                                        <span className="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 bg-[#183928] rounded-full" />
                                    )}
                                </Link>
                            );
                        })}
                    </nav>

                    {/* সার্চ, লগইন বাটন ও কল একশন */}
                    <div className="flex items-center space-x-2 sm:space-x-3 text-[#183928]">
                        {/* সার্চ বাটন */}
                        <button
                            type="button"
                            onClick={() => setSearchOpen(true)}
                            aria-label="Open Search"
                            className="p-2 hover:bg-[#eaf3ea] rounded-full transition-colors cursor-pointer"
                        >
                            <Search className="w-5 h-5 stroke-[2]" />
                        </button>

                        {/* লগইন আইকন বাটন */}
                        <Link
                            href={auth?.user ? "/dashboard" : "/login"}
                            title={auth?.user ? "Go to Dashboard" : "Login / Sign In"}
                            aria-label="Account Login"
                            className="p-2 hover:bg-[#eaf3ea] text-[#183928] rounded-full transition-colors cursor-pointer flex items-center justify-center relative group"
                        >
                            <User className="w-5 h-5 stroke-[2]" />
                            {auth?.user && (
                                <span className="absolute top-1.5 right-1.5 w-2 h-2 bg-emerald-500 rounded-full ring-2 ring-white" />
                            )}
                        </Link>

                        {/* কল হেল্পলাইন বাটন */}
                        <a
                            href={`tel:${phone}`}
                            className="hidden sm:inline-flex items-center gap-2 bg-[#183928] hover:bg-[#122c1f] text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow-sm transition-all"
                        >
                            <PhoneCall className="w-3.5 h-3.5" />
                            <span>{phone}</span>
                        </a>

                        {/* মোবাইল মেনু টগল বাটন */}
                        <button
                            type="button"
                            onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
                            className="p-1.5 md:hidden text-[#183928] hover:opacity-75 transition-opacity focus:outline-none cursor-pointer"
                            aria-label="Toggle Navigation Menu"
                        >
                            {mobileMenuOpen ? (
                                <X className="w-6 h-6 stroke-[2]" />
                            ) : (
                                <Menu className="w-6 h-6 stroke-[2]" />
                            )}
                        </button>
                    </div>
                </div>

                {/* মোবাইল ড্রয়ার মেনু */}
                {mobileMenuOpen && (
                    <div className="md:hidden bg-[#eaf3ea] px-6 py-6 space-y-4 shadow-xl">
                        <div className="space-y-3">
                            {navLinks.map((link) => {
                                const isActive = pathname === link.href;

                                return (
                                    <Link
                                        key={link.name}
                                        href={link.href}
                                        onClick={() => setMobileMenuOpen(false)}
                                        className={`block text-sm py-1.5 transition-all ${
                                            isActive
                                                ? "font-extrabold text-[#183928] pl-2 border-l-2 border-[#183928]"
                                                : "font-medium text-[#183928]/75 hover:text-[#183928]"
                                        }`}
                                    >
                                        {link.name}
                                    </Link>
                                );
                            })}
                        </div>

                        <div className="pt-3 space-y-2">
                            {/* মোবাইলের জন্য লগইন বাটন */}
                            <Link
                                href={auth?.user ? "/dashboard" : "/login"}
                                onClick={() => setMobileMenuOpen(false)}
                                className="w-full flex items-center justify-center gap-2 bg-white text-[#183928] border border-[#183928]/15 hover:bg-[#183928] hover:text-white text-xs font-bold py-3 rounded-xl shadow-xs transition-colors"
                            >
                                <User className="w-4 h-4" />
                                <span>{auth?.user ? "Admin Dashboard" : "Login to Account"}</span>
                            </Link>

                            <a
                                href={`tel:${phone}`}
                                className="w-full flex items-center justify-center gap-2 bg-[#183928] text-white text-xs font-bold py-3.5 rounded-xl shadow"
                            >
                                <PhoneCall className="w-4 h-4" />
                                <span>Call Helpline: {phone}</span>
                            </a>
                        </div>
                    </div>
                )}
            </header>

            {/* সার্চ মডাল */}
            {searchOpen && (
                <div
                    onClick={() => setSearchOpen(false)}
                    className="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm flex items-start justify-center pt-16 sm:pt-24 px-4"
                >
                    <div
                        onClick={(e) => e.stopPropagation()}
                        className="w-full max-w-2xl bg-white rounded-3xl shadow-2xl overflow-hidden p-6 sm:p-8 space-y-5"
                    >
                        <div className="flex items-center justify-between">
                            <div className="inline-flex items-center gap-2 text-xs font-extrabold text-[#183928] uppercase tracking-wider">
                                <Sparkles className="w-3.5 h-3.5 text-amber-500" />
                                <span>Quick Flavor Finder</span>
                            </div>
                            <button
                                type="button"
                                onClick={() => setSearchOpen(false)}
                                aria-label="Close search"
                                className="w-8 h-8 rounded-full bg-[#f4faf4] hover:bg-[#183928] text-gray-500 hover:text-white flex items-center justify-center transition-colors cursor-pointer"
                            >
                                <X className="w-4 h-4 stroke-[2.5]" />
                            </button>
                        </div>

                        {/* সার্চ ইনপুট বার */}
                        <div className="flex items-center gap-3 bg-[#f4faf4] rounded-2xl px-4 py-3.5 focus-within:border-transparent focus-within:ring-0">
                            <Search className="w-5 h-5 text-gray-400 flex-shrink-0" />
                            <input
                                type="text"
                                autoFocus
                                placeholder="Search flavors (e.g. Hozmi Cola, Mint, Lemon, Digestion)..."
                                value={searchQuery}
                                onChange={(e) => setSearchQuery(e.target.value)}
                                className="w-full bg-transparent text-sm sm:text-base font-semibold text-[#112318] placeholder:text-gray-400 border-0 border-transparent focus:border-transparent focus:outline-none focus:ring-0 outline-none shadow-none ring-0"
                            />
                            {searchQuery && (
                                <button
                                    type="button"
                                    onClick={() => setSearchQuery("")}
                                    className="text-gray-400 hover:text-gray-600 p-1 cursor-pointer"
                                    aria-label="Clear input"
                                >
                                    <X className="w-4 h-4" />
                                </button>
                            )}
                        </div>

                        {/* কুইক ট্যাগস */}
                        <div className="flex flex-wrap items-center gap-2">
                            <span className="text-xs font-bold text-gray-400 uppercase tracking-wider">
                                Popular:
                            </span>
                            {quickTags.map((tag) => (
                                <button
                                    key={tag}
                                    type="button"
                                    onClick={() => setSearchQuery(tag)}
                                    className="text-xs font-semibold bg-[#eef7ef] hover:bg-[#183928] text-[#183928] hover:text-white px-3 py-1 rounded-full transition-colors cursor-pointer"
                                >
                                    {tag}
                                </button>
                            ))}
                        </div>

                        {/* সার্চ রেজাল্টস */}
                        <div className="max-h-80 overflow-y-auto space-y-3 pt-1">
                            {searchQuery.trim() === "" ? (
                                <div className="text-center py-8 text-gray-400 text-xs font-medium">
                                    Type a flavor, botanical ingredient, or
                                    benefit to search...
                                </div>
                            ) : filteredResults.length > 0 ? (
                                filteredResults.map((item) => (
                                    <Link
                                        key={item.id}
                                        href={`/products/${item.slug}`}
                                        onClick={() => setSearchOpen(false)}
                                        className="flex items-center justify-between p-3.5 rounded-2xl bg-[#f4faf4] hover:bg-[#eaf4ec] transition-colors group"
                                    >
                                        <div className="flex items-center gap-3.5">
                                            <div className="relative w-12 h-14 rounded-xl overflow-hidden bg-white shadow-sm flex-shrink-0">
                                                <img
                                                    src={item.image}
                                                    alt={item.name}
                                                    className="w-full h-full object-cover"
                                                />
                                            </div>
                                            <div>
                                                <h4 className="text-sm font-bold text-[#112318] group-hover:text-[#183928] transition-colors">
                                                    {item.name}
                                                </h4>
                                                <p className="text-xs text-gray-500 line-clamp-1">
                                                    {item.shortDescription}
                                                </p>
                                            </div>
                                        </div>

                                        <div className="flex items-center gap-3 flex-shrink-0">
                                            <span className="text-xs font-extrabold text-[#183928] bg-white px-3 py-1 rounded-full shadow-sm">
                                                {item.price}
                                            </span>
                                            <ArrowRight className="w-4 h-4 text-gray-400 group-hover:text-[#183928] group-hover:translate-x-1 transition-all" />
                                        </div>
                                    </Link>
                                ))
                            ) : (
                                <div className="text-center py-8 text-gray-500 text-xs sm:text-sm">
                                    No botanical drinks found for &ldquo;
                                    {searchQuery}&rdquo;.
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            )}
        </>
    );
}