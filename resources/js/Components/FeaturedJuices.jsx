import { useRef } from "react";
import { Link } from "@inertiajs/react";
import { Swiper, SwiperSlide } from "swiper/react";
import { Navigation, Pagination, Autoplay } from "swiper/modules";

// Swiper CSS
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";

import { 
  ArrowRight, 
  Leaf, 
  Sparkles, 
  CheckCircle2, 
  ChevronLeft, 
  ChevronRight 
} from "lucide-react";
import { products as fallbackProducts } from "@/data/products";

export default function FeaturedJuices({ products: dbProducts = [], settings = {} }) {
  const swiperRef = useRef(null);

  // ড্যাশবোর্ড/ডাটাবেজের ডাটা থাকলে সেটি নেবে, না থাকলে ফলব্যাক ফাইল থেকে নেবে
  const productList = dbProducts && dbProducts.length > 0 ? dbProducts : fallbackProducts;

  // ড্যাশবোর্ড সেটিংস থেকে টেক্সট (প্রয়োজনে ড্যাশবোর্ডের ফিল্ড নেমের সাথে মিলিয়ে নিন)
  const homeSettings = settings?.home_featured || settings?.our_drinks_page || {};

  const badge = homeSettings?.badge || "Pure & Natural Lineup";
  const title = homeSettings?.title || "The Pure Sip Beverage";
  const subtitle = homeSettings?.subtitle || "Handcrafted botanical drinks cold-extracted from fresh herbs and native ingredients. Every flavor is priced at just Tk 10.";
  const footerNote = homeSettings?.footer_note || "🌿 Chilled Multi-Layer Pouch • Instant Gut Digestion • Free from Artificial Preservatives";

  // স্লাইডার স্মুথ লুপের জন্য প্রোডাক্ট কম থাকলে ডুপ্লিকেট করা
  const displayProducts = productList.length > 0 && productList.length < 8
    ? [...productList, ...productList, ...productList]
    : productList;

  return (
    <section className="relative z-20 py-20 px-4 sm:px-8 lg:px-12 w-full bg-[#f4faf4] selection:bg-[#183928] selection:text-white overflow-hidden">
      
      <div className="absolute top-1/3 -right-24 w-96 h-96 bg-emerald-100/60 rounded-full blur-3xl pointer-events-none" />
      <div className="absolute bottom-0 -left-24 w-96 h-96 bg-white/80 rounded-full blur-3xl pointer-events-none" />

      <div className="max-w-7xl mx-auto space-y-10 relative z-10">
        
        {/* Section Header */}
        <div className="flex flex-col md:flex-row md:items-end justify-between gap-6">
          <div className="space-y-3 max-w-2xl">
            <div className="inline-flex items-center gap-2 bg-[#183928] text-emerald-300 text-xs font-black px-4 py-1.5 rounded-full uppercase tracking-wider shadow-sm">
              <Leaf className="w-3.5 h-3.5" />
              <span>{badge}</span>
            </div>
            <h2 className="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#112318] tracking-tight">
              {title}
            </h2>
            <p className="text-gray-600 text-sm sm:text-base leading-relaxed">
              {subtitle}
            </p>
          </div>

          {/* Swiper Control Buttons */}
          <div className="flex items-center gap-3 self-end md:self-auto">
            <button
              type="button"
              onClick={() => swiperRef.current?.slidePrev()}
              aria-label="Previous Drink"
              className="w-12 h-12 rounded-full bg-white hover:bg-[#183928] text-[#183928] hover:text-white shadow-sm flex items-center justify-center transition-colors cursor-pointer active:scale-95"
            >
              <ChevronLeft className="w-5 h-5" />
            </button>

            <button
              type="button"
              onClick={() => swiperRef.current?.slideNext()}
              aria-label="Next Drink"
              className="w-12 h-12 rounded-full bg-white hover:bg-[#183928] text-[#183928] hover:text-white shadow-sm flex items-center justify-center transition-colors cursor-pointer active:scale-95"
            >
              <ChevronRight className="w-5 h-5" />
            </button>
          </div>
        </div>

        {/* Swiper Carousel */}
        <div className="w-full overflow-hidden pt-2 pb-6">
          <Swiper
            modules={[Navigation, Pagination, Autoplay]}
            onBeforeInit={(swiper) => {
              swiperRef.current = swiper;
            }}
            spaceBetween={24}
            slidesPerView={1}
            loop={displayProducts.length > 2}
            autoplay={{
              delay: 3500,
              disableOnInteraction: false,
              pauseOnMouseEnter: true,
            }}
            breakpoints={{
              640: { slidesPerView: 2, spaceBetween: 20 },
              1024: { slidesPerView: 3, spaceBetween: 24 },
            }}
            className="w-full !flex items-stretch pb-10"
          >
            {displayProducts.map((item, index) => (
              <SwiperSlide key={`${item.slug || item.id}-${index}`} className="!h-auto flex pb-2">
                <div className="w-full h-full bg-white rounded-3xl p-5 shadow-sm flex flex-col justify-between relative overflow-hidden group">
                  <div className="space-y-4 relative z-10">
                    <div className="relative w-full aspect-[4/5] rounded-2xl overflow-hidden bg-[#f4faf4]">
                      <img
                        src={item.image}
                        alt={item.name}
                        className="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500"
                        onError={(e) => {
                          e.target.src = "https://images.unsplash.com/photo-1622597467836-f3285f2131b7?w=600&auto=format&fit=crop&q=80";
                        }}
                      />
                      <div className="absolute top-3.5 right-3.5 bg-[#183928] text-white text-xs font-black px-3.5 py-1.5 rounded-full">
                        {item.price}
                      </div>
                      <div className="absolute bottom-3 left-3 bg-white text-[#183928] text-[10px] font-bold px-2.5 py-1 rounded-full flex items-center gap-1 shadow-sm">
                        <Sparkles className="w-3 h-3 text-amber-500" />
                        <span>100% Botanical</span>
                      </div>
                    </div>

                    <div className="space-y-2">
                      <span className="text-[11px] font-extrabold text-emerald-800 tracking-wider uppercase block">
                        Pure Sip Special
                      </span>
                      <h3 className="text-xl font-black text-[#112318] tracking-tight truncate">
                        {item.name}
                      </h3>
                      <p className="text-gray-600 text-xs leading-relaxed line-clamp-2 h-9">
                        {item.short_description || item.shortDescription}
                      </p>

                      <div className="pt-2">
                        <span className="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-1.5">
                          Key Ingredients:
                        </span>
                        <div className="flex flex-wrap gap-1.5 min-h-[54px] content-start">
                          {item.ingredients && Array.isArray(item.ingredients) && item.ingredients.slice(0, 3).map((ing, i) => (
                            <span
                              key={i}
                              className="inline-flex items-center gap-1 text-[10px] font-bold bg-[#eef7ef] text-[#183928] px-2.5 py-1 rounded-md h-fit"
                            >
                              <CheckCircle2 className="w-3 h-3 text-emerald-600 flex-shrink-0" />
                              <span className="truncate max-w-[130px]">
                                {typeof ing === "string" ? ing : ing.name}
                              </span>
                            </span>
                          ))}
                        </div>
                      </div>
                    </div>
                  </div>

                  <div className="pt-5 mt-auto relative z-10">
                    <Link
                      href={`/products/${item.slug || item.id}`}
                      className="w-full bg-[#183928] hover:bg-[#122c1f] text-white text-xs font-bold py-3.5 px-4 rounded-xl flex items-center justify-center gap-2 transition-colors group-hover:gap-3"
                    >
                      <span>View Full Details</span>
                      <ArrowRight className="w-4 h-4" />
                    </Link>
                  </div>
                </div>
              </SwiperSlide>
            ))}
          </Swiper>
        </div>

        <div className="text-center pt-2">
          <p className="text-gray-500 text-xs font-medium tracking-wide">
            {footerNote}
          </p>
        </div>

      </div>
    </section>
  );
}