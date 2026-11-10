import { Head, Link } from "@inertiajs/react";
import { 
  Leaf, 
  Sparkles, 
  ShieldCheck, 
  Award, 
  Droplet, 
  ArrowRight
} from "lucide-react";
import Header from "@/Components/Header";
import Footer from "@/Components/Footer";

const defaultPillars = [
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
];

const defaultTimeline = [
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
];

const defaultIcons = [Leaf, ShieldCheck, Award, Droplet];

export default function About({ settings = {} }) {
  const about = settings?.about_page || {};

  const badge = about?.badge || "THE PURE SIP STORY";
  const title = about?.title || "Reclaiming Real Taste.";
  const highlight = about?.highlight || "Born in Bangladesh.";
  const desc1 = about?.desc_1 || "For decades, the beverage shelves in our country have been dominated by ultra-processed sodas loaded with synthetic syrup, artificial flavors, and harmful chemicals.";
  const desc2 = about?.desc_2 || "Pure Sip Beverage was founded in Dhaka with a clear mission: reviving time-tested South Asian botanicals—from crushed Sylhet mint to roasted cumin and raw mango—into a crisp, hygienic, modern drink that heals the gut while instantly refreshing the body.";
  
  const stat1Val = about?.stat_1_val || "15K+";
  const stat1Label = about?.stat_1_label || "Sips Enjoyed";
  const stat2Val = about?.stat_2_val || "100%";
  const stat2Label = about?.stat_2_label || "Natural Botanical";
  const stat3Val = about?.stat_3_val || "Tk 10";
  const stat3Label = about?.stat_3_label || "Honest Price";

  const heroImage = about?.hero_image || "/images/banner.jpeg";
  const pillarsList = Array.isArray(about?.pillars) && about.pillars.length > 0 ? about.pillars : defaultPillars;
  const timelineList = Array.isArray(about?.timeline) && about.timeline.length > 0 ? about.timeline : defaultTimeline;

  return (
    <>
      <Head title="About Us - Pure Sip Botanical Brewing Story" />

      <div className="min-h-screen bg-[#f4faf4] flex flex-col justify-between selection:bg-[#183928] selection:text-white">
        <Header settings={settings} />

        <main className="w-full flex-1">

          {/* ================= ১. এবাউট হিরো সেকশন ================= */}
          <section className="w-full py-12 sm:py-16 lg:py-20">
            <div className="max-w-7xl mx-auto px-4 sm:px-8 lg:px-12">
              <div className="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
                
                <div className="lg:col-span-7 space-y-6">
                  <div className="inline-flex items-center gap-2 bg-[#183928] text-emerald-300 text-xs font-black tracking-widest uppercase px-4 py-1.5 rounded-full shadow-sm">
                    <Sparkles className="w-3.5 h-3.5 text-amber-400" />
                    <span>{badge}</span>
                  </div>

                  <h1 className="text-4xl sm:text-5xl lg:text-6xl font-black text-[#112318] tracking-tight leading-[1.12]">
                    {title} <br />
                    <span className="text-[#183928]">{highlight}</span>
                  </h1>

                  <p className="text-gray-700 text-sm sm:text-base leading-relaxed font-normal">
                    {desc1}
                  </p>

                  <p className="text-gray-700 text-sm sm:text-base leading-relaxed font-normal">
                    {desc2}
                  </p>

                  <div className="grid grid-cols-3 gap-4 pt-6 border-t border-emerald-900/10">
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
                </div>

                <div className="lg:col-span-5 flex justify-center">
                  <div className="relative w-full max-w-[440px] h-[380px] sm:h-[460px] rounded-3xl overflow-hidden shadow-2xl bg-white group">
                    <img
                      src={heroImage}
                      alt="Pure Sip Botanical Brewing Story"
                      className="w-full h-full object-cover object-[80%_center] group-hover:scale-105 transition-transform duration-700"
                      onError={(e) => { e.target.src = "/images/banner.jpeg"; }}
                    />
                    <div className="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent" />

                    <div className="absolute bottom-6 left-6 right-6 p-4 rounded-2xl bg-white/95 backdrop-blur-md shadow-lg flex items-center gap-3">
                      <div className="w-10 h-10 rounded-full bg-[#183928] text-white flex items-center justify-center flex-shrink-0 font-black text-sm">
                        PS
                      </div>
                      <div>
                        <h5 className="text-xs font-bold text-[#112318]">Crafted in Dhaka, Bangladesh</h5>
                        <p className="text-[11px] text-gray-500">Traditional recipes backed by food science</p>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </section>

          {/* ================= ২. ফোর কোর পিলার্স ================= */}
          <section className="w-full py-16 sm:py-20 lg:py-24 bg-[#ebf5ec]/40 border-y border-emerald-900/5">
            <div className="max-w-7xl mx-auto px-4 sm:px-8 lg:px-12 space-y-12">
              <div className="text-center max-w-2xl mx-auto">
                <div className="inline-flex items-center gap-2 bg-[#183928] text-emerald-300 text-xs font-black tracking-widest uppercase px-4 py-1.5 rounded-full shadow-sm">
                  <span>Our Purity Manifesto</span>
                </div>
                <h2 className="text-3xl sm:text-4xl font-extrabold text-[#112318] tracking-tight mt-3">
                  Why We Refuse to Cut Corners
                </h2>
                <p className="text-gray-600 text-sm sm:text-base leading-relaxed mt-2">
                  Every formula is built around genuine physiological wellness, sustainable sourcing, and unbeatable affordability.
                </p>
              </div>

              <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                {pillarsList.map((item, index) => {
                  const Icon = defaultIcons[index % defaultIcons.length];
                  return (
                    <div
                      key={index}
                      className="bg-white p-7 rounded-3xl shadow-sm hover:shadow-md transition-all duration-300 space-y-4 flex flex-col justify-between group border border-emerald-900/5"
                    >
                      <div className="space-y-4">
                        <div className="w-12 h-12 rounded-2xl bg-[#eef7ef] flex items-center justify-center text-[#183928] group-hover:bg-[#183928] group-hover:text-white transition-colors">
                          <Icon className="w-6 h-6 stroke-[1.75]" />
                        </div>
                        <h4 className="text-base font-bold text-[#112318] tracking-tight">
                          {item.title}
                        </h4>
                        <p className="text-xs text-gray-600 leading-relaxed font-normal">
                          {item.desc}
                        </p>
                      </div>
                    </div>
                  );
                })}
              </div>
            </div>
          </section>

          {/* ================= ৩. ব্রিউইং প্রসেস / টাইমলাইন ================= */}
          <section className="w-full py-16 sm:py-20 lg:py-24">
            <div className="max-w-7xl mx-auto px-4 sm:px-8 lg:px-12">
              <div className="w-full bg-white rounded-3xl p-8 sm:p-14 shadow-sm space-y-12 border border-emerald-900/5">
                <div className="text-center space-y-3 max-w-2xl mx-auto">
                  <div className="inline-flex items-center gap-1.5 text-xs font-bold text-[#183928] bg-[#eef7ef] px-3.5 py-1.5 rounded-full uppercase tracking-wider">
                    <Leaf className="w-3.5 h-3.5 text-emerald-600" />
                    <span>Farm to Pouch</span>
                  </div>
                  <h3 className="text-3xl sm:text-4xl font-black text-[#112318] tracking-tight">
                    How We Craft Every Batch
                  </h3>
                  <p className="text-gray-600 text-xs sm:text-sm">
                    From harvesting garden herbs to sealing chilled pouches in Dhaka.
                  </p>
                </div>

                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                  {timelineList.map((step, idx) => (
                    <div key={idx} className="space-y-3 relative">
                      <span className="text-4xl sm:text-5xl font-black text-[#183928]/15 block">
                        {step.step || `0${idx + 1}`}
                      </span>
                      <h4 className="text-base font-bold text-[#112318] tracking-tight">
                        {step.title}
                      </h4>
                      <p className="text-xs text-gray-600 leading-relaxed">
                        {step.desc}
                      </p>
                    </div>
                  ))}
                </div>
              </div>
            </div>
          </section>

          {/* ================= ৪. বটম CTA ব্যানার ================= */}
          <section className="w-full pb-20 sm:pb-24">
            <div className="max-w-7xl mx-auto px-4 sm:px-8 lg:px-12">
              <div className="w-full bg-[#183928] text-white rounded-3xl p-8 sm:p-14 shadow-xl flex flex-col lg:flex-row items-center justify-between gap-8">
                <div className="space-y-3 text-center lg:text-left max-w-xl">
                  <span className="text-xs font-bold text-emerald-300 uppercase tracking-wider">
                    Experience The Sensation
                  </span>
                  <h3 className="text-2xl sm:text-4xl font-black tracking-tight">
                    Ready to Taste Real Botanicals?
                  </h3>
                  <p className="text-emerald-100/80 text-xs sm:text-sm leading-relaxed">
                    Discover our signature lineup including Hozmi Cola, Pudina Drink, Citrus Boost, and Green Detox.
                  </p>
                </div>

                <div className="flex flex-col sm:flex-row items-center gap-4 w-full lg:w-auto">
                  <Link
                    href="/our-drinks"
                    className="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-white text-[#112318] hover:bg-emerald-50 text-xs sm:text-sm font-black px-8 py-4 rounded-xl shadow-lg transition-all whitespace-nowrap"
                  >
                    <span>Explore All Drinks</span>
                    <ArrowRight className="w-4 h-4" />
                  </Link>
                  <Link
                    href="/contact"
                    className="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-white/10 hover:bg-white/20 text-white text-xs sm:text-sm font-bold px-8 py-4 rounded-xl border border-white/10 transition-all whitespace-nowrap"
                  >
                    <span>Contact Team</span>
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