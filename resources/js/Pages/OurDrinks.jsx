import { useState, useRef } from "react";
import { Head, Link } from "@inertiajs/react";
import { Swiper, SwiperSlide } from "swiper/react";
import { Navigation, Autoplay } from "swiper/modules";

import "swiper/css";
import "swiper/css/navigation";

import { 
  Leaf, 
  Sparkles, 
  ArrowRight, 
  CheckCircle2, 
  PhoneCall, 
  ShieldCheck,
  Flame,
  Droplet,
  ChevronLeft,
  ChevronRight
} from "lucide-react";
import Header from "@/Components/Header";
import Footer from "@/Components/Footer";
import { products as fallbackProducts } from "@/data/products";

const defaultCategories = [
  { id: "all", label: "All Drinks" },
  { id: "digestive", label: "Digestive & Gut" },
  { id: "refreshing", label: "Cooling & Tangy" },
  { id: "immunity", label: "Immunity Boost" },
];

export default function OurDrinks({ products: dbProducts = [], settings = {} }) {
  const [activeCategory, setActiveCategory] = useState("all");
  const swiperRef = useRef(null);

  const productList = dbProducts.length > 0 ? dbProducts : fallbackProducts;
  const ourDrinksPage = settings?.our_drinks_page || {};

  const badge = ourDrinksPage?.badge || "100% BOTANICAL LINEUP";
  const title = ourDrinksPage?.title || "Crafted for Taste.";
  const highlight = ourDrinksPage?.highlight || "Brewed for Well-Being.";
  const subtitle = ourDrinksPage?.subtitle || "Explore our handcrafted lineup of cold-extracted botanical juices. Made with raw fruits, garden mint, and Ayurvedic spices—every pouch strictly priced at just Tk 10.";
  const categoriesList = Array.isArray(ourDrinksPage?.categories) && ourDrinksPage.categories.length > 0 
    ? ourDrinksPage.categories 
    : defaultCategories;

  // ক্যাটাগরি ফিল্টার
  const baseFilteredProducts = productList.filter((item) => {
    if (activeCategory === "all") return true;
    const cat = (item.category || "").toLowerCase();
    const id = (item.slug || item.id || "").toLowerCase();

    if (activeCategory === "digestive") return cat === "digestive" || id.includes("hozmi");
    if (activeCategory === "refreshing") return cat === "refreshing" || id.includes("pudina") || id.includes("green");
    if (activeCategory === "immunity") return cat === "immunity" || id.includes("citrus");
    return cat === activeCategory;
  });

  const displayProducts = baseFilteredProducts.length > 0 && baseFilteredProducts.length < 8
    ? [...baseFilteredProducts, ...baseFilteredProducts, ...baseFilteredProducts]
    : baseFilteredProducts;

  return (
    <>
      <Head title="Our Drinks - Handcrafted Botanical Flavors | Pure Sip" />

      <div className="min-h-screen bg-[#f4faf4] flex flex-col justify-between selection:bg-[#183928] selection:text-white">
        <Header settings={settings} />

        <main className="w-full flex-1 block">

          {/* হেডার ও ফিল্টার */}
          <section className="w-full py-12 sm:py-16 px-4 sm:px-8 lg:px-12 block">
            <div className="max-w-4xl mx-auto text-center space-y-4">
              <div className="inline-flex items-center gap-2 bg-[#183928] text-emerald-300 text-xs font-black tracking-widest uppercase px-4 py-1.5 rounded-full shadow-sm">
                <Sparkles className="w-3.5 h-3.5 text-amber-400" />
                <span>{badge}</span>
              </div>

              <h1 className="text-4xl sm:text-5xl lg:text-6xl font-black text-[#112318] tracking-tight leading-[1.15]">
                {title} <br />
                <span className="text-[#183928]">{highlight}</span>
              </h1>

              <p className="text-gray-600 text-sm sm:text-base md:text-lg leading-relaxed max-w-2xl mx-auto font-normal">
                {subtitle}
              </p>

              <div className="flex flex-wrap items-center justify-center gap-2.5 pt-4">
                {categoriesList.map((cat) => (
                  <button
                    key={cat.id}
                    type="button"
                    onClick={() => setActiveCategory(cat.id)}
                    className={`px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all cursor-pointer ${
                      activeCategory === cat.id
                        ? "bg-[#183928] text-white shadow-md scale-105"
                        : "bg-white text-gray-700 hover:bg-emerald-50 hover:text-[#183928] shadow-xs"
                    }`}
                  >
                    {cat.label}
                  </button>
                ))}
              </div>
            </div>
          </section>

          {/* স্লাইডার */}
          <section className="w-full pb-16 px-4 sm:px-8 lg:px-12 block">
            <div className="max-w-7xl mx-auto space-y-6">
              
              <div className="flex items-center justify-between px-2">
                <span className="text-xs font-black text-[#183928] uppercase tracking-wider">
                  Showing {baseFilteredProducts.length} Drinks
                </span>

                <div className="flex items-center gap-3">
                  <button
                    type="button"
                    onClick={() => swiperRef.current?.slidePrev()}
                    aria-label="Previous Slide"
                    className="w-12 h-12 rounded-full bg-white hover:bg-[#183928] text-[#183928] hover:text-white shadow-md border border-emerald-900/10 flex items-center justify-center transition-all duration-200 active:scale-95 cursor-pointer group"
                  >
                    <ChevronLeft className="w-6 h-6 stroke-[2.5] group-hover:-translate-x-0.5 transition-transform" />
                  </button>

                  <button
                    type="button"
                    onClick={() => swiperRef.current?.slideNext()}
                    aria-label="Next Slide"
                    className="w-12 h-12 rounded-full bg-white hover:bg-[#183928] text-[#183928] hover:text-white shadow-md border border-emerald-900/10 flex items-center justify-center transition-all duration-200 active:scale-95 cursor-pointer group"
                  >
                    <ChevronRight className="w-6 h-6 stroke-[2.5] group-hover:translate-x-0.5 transition-transform" />
                  </button>
                </div>
              </div>

              <div className="w-full overflow-hidden pb-4">
                <Swiper
                  key={activeCategory}
                  modules={[Navigation, Autoplay]}
                  onBeforeInit={(swiper) => {
                    swiperRef.current = swiper;
                  }}
                  spaceBetween={24}
                  slidesPerView={1}
                  loop={true}
                  loopAdditionalSlides={3}
                  grabCursor={true}
                  autoplay={{
                    delay: 3000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                  }}
                  breakpoints={{
                    640: { slidesPerView: 2, spaceBetween: 20 },
                    1024: { slidesPerView: 3, spaceBetween: 24 },
                  }}
                  className="w-full !flex items-stretch pb-6"
                >
                  {displayProducts.map((item, index) => (
                    <SwiperSlide key={`${item.slug || item.id}-${index}`} className="!h-auto flex pb-2">
                      <div className="w-full h-full bg-white rounded-3xl p-5 shadow-md transition-all duration-300 flex flex-col justify-between relative overflow-hidden group border border-emerald-900/5">
                        
                        <div className="space-y-4 relative z-10">
                          
                          {/* প্রোডাক্ট ইমেজ */}
                          <div className="relative w-full aspect-[4/5] rounded-2xl overflow-hidden bg-[#f4faf4] shadow-inner">
                            <img
                              src={item.image}
                              alt={item.name}
                              className="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500"
                            />

                            <div className="absolute top-3.5 right-3.5 bg-[#183928] text-white text-xs font-black px-4 py-2 rounded-full shadow-lg">
                              {item.price}
                            </div>

                            <div className="absolute bottom-3 left-3 bg-white/95 backdrop-blur-sm text-[#183928] text-[10px] font-bold px-2.5 py-1 rounded-full flex items-center gap-1 shadow-sm">
                              <Leaf className="w-3.5 h-3.5 text-emerald-600" />
                              <span>100% Botanical</span>
                            </div>
                          </div>

                          {/* টেক্সট ডিটেইলস */}
                          <div className="space-y-2">
                            <div className="flex items-center justify-between">
                              <span className="text-[11px] font-extrabold text-[#183928] tracking-widest uppercase">
                                Pure Sip Special
                              </span>
                              <span className="text-[11px] text-gray-400 font-medium">
                                {item.net_volume || item.netVolume || "200ml"}
                              </span>
                            </div>

                            <h3 className="text-xl font-black text-[#112318] tracking-tight truncate">
                              {item.name}
                            </h3>

                            <p className="text-gray-600 text-xs leading-relaxed line-clamp-2 h-9">
                              {item.short_description || item.shortDescription}
                            </p>

                            {/* উপাদান তালিকা */}
                            <div className="pt-2">
                              <span className="text-[10px] font-bold text-gray-400 block uppercase tracking-wider mb-1.5">
                                Key Ingredients:
                              </span>
                              <div className="flex flex-wrap gap-1.5 min-h-[54px] content-start">
                                {item.ingredients && Array.isArray(item.ingredients) && item.ingredients.slice(0, 3).map((ing, i) => (
                                  <span
                                    key={i}
                                    className="inline-flex items-center gap-1 text-[10px] font-bold bg-[#eef7ef] text-[#183928] px-2.5 py-1 rounded-md h-fit"
                                  >
                                    <CheckCircle2 className="w-3.5 h-3.5 text-emerald-600 flex-shrink-0" />
                                    <span className="truncate max-w-[130px]">{typeof ing === 'string' ? ing : ing.name}</span>
                                  </span>
                                ))}
                              </div>
                            </div>
                          </div>
                        </div>

                        {/* ডিটেইলস বাটন */}
                        <div className="pt-5 mt-auto relative z-10">
                          <Link
                            href={`/products/${item.slug || item.id}`}
                            className="w-full bg-[#183928] hover:bg-[#122c1f] text-white text-xs font-bold py-3.5 px-4 rounded-xl flex items-center justify-center gap-2 shadow-sm transition-all group-hover:gap-3"
                          >
                            <span>View Benefits & Nutrition</span>
                            <ArrowRight className="w-4 h-4" />
                          </Link>
                        </div>
                      </div>
                    </SwiperSlide>
                  ))}
                </Swiper>
              </div>
            </div>
          </section>

          {/* When to Sip What? */}
          <section className="w-full py-16 sm:py-20 px-4 sm:px-8 lg:px-12 border-y border-emerald-900/5 block">
            <div className="max-w-7xl mx-auto space-y-10">
              <div className="text-center space-y-2 max-w-2xl mx-auto">
                <h2 className="text-2xl sm:text-3xl font-black text-[#112318] tracking-tight">
                  When to Sip What?
                </h2>
                <p className="text-gray-600 text-xs sm:text-sm">
                  Tailored botanical formulas designed for specific times of your day.
                </p>
              </div>

              <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div className="p-6 rounded-3xl bg-[#f4faf4] space-y-3 border border-emerald-900/2">
                  <div className="w-10 h-10 rounded-xl bg-[#183928] text-white flex items-center justify-center shadow-xs">
                    <Flame className="w-5 h-5 text-amber-400" />
                  </div>
                  <h3 className="text-base font-bold text-[#112318]">After Heavy Meals</h3>
                  <p className="text-sm text-gray-600 leading-relaxed">
                    Grab a chilled <strong className="text-[#183928]">Hozmi Cola</strong>. Roasted cumin and ginger accelerate digestive enzyme release and eliminate stomach bloating.
                  </p>
                </div>

                <div className="p-6 rounded-3xl bg-[#f4faf4] space-y-3 border border-emerald-900/2">
                  <div className="w-10 h-10 rounded-xl bg-[#183928] text-white flex items-center justify-center shadow-xs">
                    <Droplet className="w-5 h-5 text-emerald-300" />
                  </div>
                  <h3 className="text-base font-bold text-[#112318]">Midday Summer Heat</h3>
                  <p className="text-sm text-gray-600 leading-relaxed">
                    Choose <strong className="text-[#183928]">Pudina Drink</strong>. Raw mango electrolytes combined with crushed garden mint prevent heat fatigue instantly.
                  </p>
                </div>

                <div className="p-6 rounded-3xl bg-[#f4faf4] space-y-3 border border-emerald-900/2">
                  <div className="w-10 h-10 rounded-xl bg-[#183928] text-white flex items-center justify-center shadow-xs">
                    <ShieldCheck className="w-5 h-5 text-emerald-300" />
                  </div>
                  <h3 className="text-base font-bold text-[#112318]">Morning Vitality</h3>
                  <p className="text-sm text-gray-600 leading-relaxed">
                    Start with <strong className="text-[#183928]">Citrus Boost</strong> or <strong className="text-[#183928]">Green Detox</strong> for clean natural energy without processed caffeine.
                  </p>
                </div>
              </div>
            </div>
          </section>

          {/* হোলসেল ব্যানার */}
          <section className="w-full py-16 sm:py-20 px-4 sm:px-8 lg:px-12 block">
            <div className="max-w-7xl mx-auto">
              <div className="w-full bg-[#183928] text-white rounded-3xl p-8 sm:p-14 shadow-xl flex flex-col lg:flex-row items-center justify-between gap-8">
                <div className="space-y-3 text-center lg:text-left max-w-xl">
                  <span className="text-xs font-bold text-emerald-300 uppercase tracking-wider">
                    Bulk Distribution & Events
                  </span>
                  <h2 className="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight">
                    Need Pure Sip for Your Shop, Cafe or Event?
                  </h2>
                  <p className="text-emerald-100/80 text-xs sm:text-sm leading-relaxed">
                    We provide direct cold-chain supply across Dhaka for restaurants, retail partners, and wedding/catering events. Special wholesale pricing available.
                  </p>
                </div>

                <div className="flex flex-col sm:flex-row items-center gap-4 w-full lg:w-auto">
                  <a
                    href="tel:01306312372"
                    className="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-white text-[#112318] hover:bg-emerald-50 text-xs sm:text-sm font-black px-8 py-4 rounded-xl shadow-lg transition-all whitespace-nowrap active:scale-95"
                  >
                    <PhoneCall className="w-4 h-4 text-[#183928]" />
                    <span>Call: 01306-312372</span>
                  </a>
                  <Link
                    href="/contact"
                    className="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-white/10 hover:bg-white/20 text-white text-xs sm:text-sm font-bold px-8 py-4 rounded-xl border border-white/10 transition-all whitespace-nowrap active:scale-95"
                  >
                    <span>Contact Us</span>
                  </Link>
                </div>
              </div>
            </div>
          </section>

        </main>

        <Footer settings={settings} />
      </div>
    </>
  );
}