import React from "react";
import { Head, Link } from "@inertiajs/react";
import { 
  ArrowLeft, 
  Leaf, 
  ShieldCheck, 
  CheckCircle, 
  Sparkles, 
  PhoneCall 
} from "lucide-react";
import Header from "@/Components/Header";
import Footer from "@/Components/Footer";

export default function ProductDetails({ product, relatedProducts = [], settings = {} }) {
  
  if (!product) {
    return (
      <main className="min-h-screen bg-[#f4faf4] flex flex-col items-center justify-center p-6 text-center">
        <h2 className="text-2xl font-bold text-[#183928] mb-2">Flavor Not Found!</h2>
        <p className="text-gray-600 mb-6 text-sm">The botanical blend you requested could not be located.</p>
        <Link
          href="/our-drinks"
          className="inline-flex items-center gap-2 text-sm font-bold text-white bg-[#183928] px-6 py-3 rounded-xl shadow-md hover:bg-emerald-950 transition-all"
        >
          <ArrowLeft className="w-4 h-4" />
          <span>Back to Collection</span>
        </Link>
      </main>
    );
  }

  // নিরাপদভাবে ইনগ্রেডিয়েন্টস এবং বেনিফিটস পার্সিং
  const ingredientsList = typeof product.ingredients === 'string' 
    ? JSON.parse(product.ingredients || '[]') 
    : (product.ingredients || []);

  const benefitsList = typeof product.benefits === 'string' 
    ? JSON.parse(product.benefits || '[]') 
    : (product.benefits || []);

  return (
    <>
      <Head title={`${product.name} - Pure Sip Botanical Brewing`} />

      <div className="min-h-screen bg-[#f4faf4] flex flex-col justify-between selection:bg-[#183928] selection:text-white">
        <Header settings={settings} />

        <main className="w-full flex-1 py-10 px-4 sm:px-6 lg:px-12">
          <div className="max-w-6xl mx-auto space-y-8">
            
            {/* Back Button */}
            <div>
              <Link
                href="/our-drinks"
                className="inline-flex items-center gap-2 text-sm font-bold text-[#183928] bg-white px-5 py-2.5 rounded-full shadow-sm hover:shadow hover:bg-emerald-50 transition-all"
              >
                <ArrowLeft className="w-4 h-4" />
                <span>Back to Collection</span>
              </Link>
            </div>

            {/* Main Product Details Card */}
            <div className="bg-white rounded-3xl shadow-xl overflow-hidden grid grid-cols-1 lg:grid-cols-12 gap-8 p-6 sm:p-10">
              
              {/* Left Side: Product Image & Badges */}
              <div className="lg:col-span-5 space-y-6">
                <div className="relative w-full aspect-[3/4] rounded-2xl overflow-hidden shadow-md bg-gray-50 border border-emerald-900/10">
                  <img
                    src={product.image?.startsWith('/') || product.image?.startsWith('http') ? product.image : `/${product.image}`}
                    alt={product.name}
                    className="w-full h-full object-cover object-center"
                  />
                  <div className="absolute top-4 right-4 bg-[#183928] text-white text-xs font-bold px-3.5 py-1.5 rounded-full shadow">
                    Price: {product.price}
                  </div>
                </div>

                {/* Feature Badges */}
                <div className="grid grid-cols-2 gap-3">
                  <div className="p-3.5 bg-[#eef7ef] rounded-xl border border-emerald-900/10 flex items-center gap-2.5">
                    <ShieldCheck className="w-5 h-5 text-[#183928]" />
                    <span className="text-xs font-bold text-[#183928]">100% Safe</span>
                  </div>
                  <div className="p-3.5 bg-[#eef7ef] rounded-xl border border-emerald-900/10 flex items-center gap-2.5">
                    <Leaf className="w-5 h-5 text-[#183928]" />
                    <span className="text-xs font-bold text-[#183928]">Natural Ingredients</span>
                  </div>
                </div>
              </div>

              {/* Right Side: Details */}
              <div className="lg:col-span-7 space-y-6 flex flex-col justify-between">
                <div className="space-y-4">
                  <div className="space-y-1">
                    <span className="text-xs font-extrabold text-[#e0564c] tracking-widest uppercase">
                      Pure Sip Beverage
                    </span>
                    <h1 className="text-3xl sm:text-4xl font-black text-[#112318] tracking-tight">
                      {product.name}
                    </h1>
                    <p className="text-sm font-semibold text-emerald-800">
                      {product.tagline || "Pure Botanical Blend"}
                    </p>
                  </div>

                  {/* Price & Packaging */}
                  <div className="flex items-center gap-4 py-2 border-y border-gray-100">
                    <div className="text-2xl font-black text-[#183928]">
                      {product.price} <span className="text-xs text-gray-500 font-normal">/ package</span>
                    </div>
                    <div className="text-xs font-semibold text-gray-600 bg-gray-100 px-3 py-1 rounded-full">
                      Packaging: {product.net_volume || "200ml"}
                    </div>
                  </div>

                  {/* Description */}
                  <p className="text-gray-700 text-sm sm:text-base leading-relaxed">
                    {product.short_description || product.description}
                  </p>

                  {/* Ingredients */}
                  {Array.isArray(ingredientsList) && ingredientsList.length > 0 && (
                    <div className="space-y-2 pt-2">
                      <h3 className="text-sm font-bold text-[#112318] flex items-center gap-2">
                        <Sparkles className="w-4 h-4 text-emerald-700" />
                        <span>Key Ingredients:</span>
                      </h3>
                      <div className="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                        {ingredientsList.map((ing, i) => (
                          <div key={i} className="p-2.5 bg-gray-50 rounded-lg border border-gray-100 text-xs">
                            <p className="font-bold text-[#183928]">{typeof ing === 'string' ? ing : ing.name}</p>
                            {ing.desc && <p className="text-gray-500 text-[11px]">{ing.desc}</p>}
                          </div>
                        ))}
                      </div>
                    </div>
                  )}

                  {/* Benefits */}
                  {Array.isArray(benefitsList) && benefitsList.length > 0 && (
                    <div className="space-y-2 pt-2">
                      <h3 className="text-sm font-bold text-[#112318] flex items-center gap-2">
                        <CheckCircle className="w-4 h-4 text-emerald-700" />
                        <span>Health Benefits:</span>
                      </h3>
                      <ul className="space-y-1.5 text-xs sm:text-sm text-gray-700">
                        {benefitsList.map((b, i) => (
                          <li key={i} className="flex items-start gap-2">
                            <span className="text-emerald-600 font-bold">•</span>
                            <span>{typeof b === 'string' ? b : b.text}</span>
                          </li>
                        ))}
                      </ul>
                    </div>
                  )}
                </div>

                {/* ড্যাশবোর্ড থেকে কন্ট্রোল করা ডাইনামিক ম্যানুফ্যাকচারার, স্টোরেজ ও হেল্পলাইন */}
                <div className="bg-[#183928] text-white p-5 rounded-2xl space-y-3 mt-6">
                  <div className="flex items-center justify-between">
                    <div>
                      <p className="text-[11px] text-emerald-200">Prepared & Marketed by:</p>
                      <p className="text-xs font-bold">{product.manufacturer || "Pure Sip Beverage"}</p>
                    </div>
                    <div className="text-right">
                      <p className="text-[11px] text-emerald-200">Storage Method:</p>
                      <p className="text-xs font-semibold">{product.storage || "Keep in Refrigerator"}</p>
                    </div>
                  </div>
                  <div className="pt-2 border-t border-white/10 flex items-center justify-between text-xs">
                    <span className="flex items-center gap-1.5 text-emerald-100">
                      <PhoneCall className="w-3.5 h-3.5" /> Helpline & Dealership:
                    </span>
                    <span className="font-bold tracking-wider">{product.helpline || "01306-312372"}</span>
                  </div>
                </div>

              </div>

            </div>

          </div>
        </main>

        <Footer settings={settings} />
      </div>
    </>
  );
}