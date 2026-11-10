import { Link } from "@inertiajs/react";
import { 
  ShieldCheck, 
  Leaf, 
  Droplet, 
  HeartHandshake, 
  ArrowRight,
  CheckCircle2
} from "lucide-react";

const defaultIcons = [Leaf, ShieldCheck, Droplet, HeartHandshake];

const defaultFeatures = [
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
];

// data প্রপস রিসিভ করা হচ্ছে
export default function WhyChooseUs({ data = {} }) {
  const badge = data?.badge || "THE PURITY STANDARD";
  const title = data?.title || "Crafted Botanicals.";
  const highlight = data?.highlight || "Zero Artificial Compromise.";
  const subtitle = data?.subtitle || "Cold-extracted garden mint, raw fruits, and digestive spices brewed in small batches for pristine clarity and deep gut vitality.";
  const storyTitle = data?.story_title || "Real Botanical Roots for Natural Well-Being";
  const storyDesc = data?.story_desc || "At Pure Sip Beverage, we believe true refreshment comes directly from the earth. Our small-batch cold blends extract the purest essence of traditional herbs, raw fruits, and authentic spices—bringing you a pure experience without a single drop of chemical additives.";
  const stat1Val = data?.stat_1_val || "100%";
  const stat1Label = data?.stat_1_label || "Real Botanical Brew";
  const stat2Val = data?.stat_2_val || "0g";
  const stat2Label = data?.stat_2_label || "Harmful Preservatives";
  const stat3Val = data?.stat_3_val || "4.9★";
  const stat3Label = data?.stat_3_label || "Over 15,000 Sips";
  const storyImage = data?.story_image || "/images/banner.jpeg";
  const featuresList = (data?.features && data.features.length > 0) ? data.features : defaultFeatures;

  return (
    <section className="relative z-20 py-14 px-4 sm:px-8 lg:px-12 w-full bg-gradient-to-b from-[#f4faf4] via-[#eaf4ec] to-[#f4faf4] selection:bg-[#183928] selection:text-white overflow-hidden">
      
      <div className="absolute top-1/4 -left-20 w-80 h-80 bg-emerald-200/40 rounded-full blur-3xl pointer-events-none" />
      <div className="absolute bottom-10 right-0 w-96 h-96 bg-white/60 rounded-full blur-3xl pointer-events-none" />

      <div className="max-w-7xl mx-auto space-y-16 lg:space-y-20">
        
        {/* Title Header */}
        <div className="text-center space-y-4 max-w-3xl mx-auto">
          <div className="inline-flex items-center gap-2 bg-[#183928] text-emerald-300 text-xs font-black tracking-widest uppercase px-5 py-2 rounded-full shadow-lg border border-emerald-700/50">
            <span>{badge}</span>
            <span className="text-sm">🌿</span>
          </div>

          <h2 className="text-3xl lg:text-5xl font-black text-[#112318] tracking-tight leading-[1.12]">
            {title} <br className="hidden sm:inline" />
            <span className="text-[#183928]">{highlight}</span>
          </h2>

          <p className="text-gray-600 text-sm sm:text-base md:text-lg leading-relaxed max-w-2xl mx-auto font-normal">
            {subtitle}
          </p>
        </div>

        {/* Story & Image Grid */}
        <div className="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
          
          <div className="lg:col-span-7 space-y-6">
            <h3 className="text-2xl sm:text-3xl font-extrabold text-[#112318] tracking-tight">
              {storyTitle}
            </h3>

            <p className="text-gray-700 text-sm sm:text-base leading-relaxed font-normal">
              {storyDesc}
            </p>

            <div className="grid grid-cols-3 gap-4 pt-4 border-y border-emerald-900/10 py-5 max-w-lg">
              <div>
                <h4 className="text-2xl sm:text-3xl font-black text-[#183928]">{stat1Val}</h4>
                <p className="text-xs text-gray-500 font-medium mt-0.5">{stat1Label}</p>
              </div>
              <div>
                <h4 className="text-2xl sm:text-3xl font-black text-[#183928]">{stat2Val}</h4>
                <p className="text-xs text-gray-500 font-medium mt-0.5">{stat2Label}</p>
              </div>
              <div>
                <h4 className="text-2xl sm:text-3xl font-black text-[#183928]">{stat3Val}</h4>
                <p className="text-xs text-gray-500 font-medium mt-0.5">{stat3Label}</p>
              </div>
            </div>

            <div className="pt-2">
              <Link
                href="/about"
                className="inline-flex items-center gap-2.5 bg-[#183928] hover:bg-[#122c1f] text-white text-xs sm:text-sm font-bold px-8 py-4 rounded-xl shadow-md hover:shadow-xl transition-all group active:scale-95"
              >
                <span>Learn Our Brewing Story</span>
                <ArrowRight className="w-4 h-4 group-hover:translate-x-1 transition-transform" />
              </Link>
            </div>
          </div>

          <div className="lg:col-span-5 relative flex justify-center items-center">
            <div className="relative w-full max-w-[480px] aspect-[4/4.5] rounded-3xl overflow-hidden shadow-2xl border-white bg-white group">
              <img
                src={storyImage}
                alt="Pure Sip Botanicals"
                className="w-full h-full object-cover object-[85%_center] group-hover:scale-105 transition-transform duration-700"
              />
              
              <div className="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent" />

              <div className="absolute bottom-6 left-6 right-6 p-4 rounded-2xl bg-white/95 backdrop-blur-md shadow-lg border border-white/40 flex items-center gap-3.5">
                <div className="w-10 h-10 rounded-full bg-[#183928] text-white flex items-center justify-center flex-shrink-0">
                  <CheckCircle2 className="w-5 h-5 text-emerald-300" />
                </div>
                <div>
                  <h5 className="text-xs font-bold text-[#112318]">Laboratory Tested & Verified</h5>
                  <p className="text-[11px] text-gray-500">Hygiene standard strictly monitored in Dhaka</p>
                </div>
              </div>
            </div>
          </div>

        </div>

        {/* 4-Card Feature Grid */}
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 pt-4">
          {featuresList.map((item, index) => {
            const Icon = defaultIcons[index % defaultIcons.length];
            return (
              <div
                key={index}
                className="bg-white/80 backdrop-blur-sm p-6 rounded-2xl shadow-sm hover:shadow-md hover:bg-white transition-all duration-300 space-y-3 group"
              >
                <div className="w-12 h-12 rounded-xl bg-[#eef7ef] flex items-center justify-center text-[#183928] group-hover:bg-[#183928] group-hover:text-white transition-colors">
                  <Icon className="w-6 h-6 stroke-[1.75]" />
                </div>
                <h4 className="text-base font-bold text-[#112318] tracking-tight">
                  {item.title}
                </h4>
                <p className="text-xs leading-relaxed text-gray-600">
                  {item.desc}
                </p>
              </div>
            );
          })}
        </div>

      </div>
    </section>
  );
}