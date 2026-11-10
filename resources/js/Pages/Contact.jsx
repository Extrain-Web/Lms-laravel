import React from "react";
import { Head, useForm, Link } from "@inertiajs/react";
import { 
  PhoneCall, 
  Mail, 
  MapPin, 
  MessageCircle, 
  Send, 
  Clock, 
  Sparkles, 
  CheckCircle2,
  Building2,
  ShieldCheck
} from "lucide-react";
import Header from "@/Components/Header";
import Footer from "@/Components/Footer";

export default function Contact({ settings = {} }) {

  const contactData = settings?.contact_page || {};

  const { data, setData, post, processing, errors, reset, recentlySuccessful } = useForm({
    name: "",
    phone: "",
    email: "",
    inquiry_type: "Dealership & Wholesale",
    message: "",
  });

  const handleSubmit = (e) => {
    e.preventDefault();
    post("/inquiries", {
      preserveScroll: true,
      onSuccess: () => reset(),
    });
  };

  const contactPage = settings?.contact_page || {};
  const badge = contactPage?.badge || "LET'S CONNECT";
  const title = contactPage?.title || "Get in Touch with";
  const highlight = contactPage?.highlight || "Pure Sip Beverage";
  const subtitle = contactPage?.subtitle || "Have questions about our botanical formulas, want to stock our Tk 10 pouches at your shop, or planning bulk orders for events? We are here to help.";
  const addressTitle = contactPage?.address_title || "Production & Office";
  const addressDesc = contactPage?.address_desc || "Pure Sip Beverage, Dhaka, Bangladesh";
  const email = contactPage?.email || settings?.email || "info@puresipbeverage.com";
  const hours = contactPage?.hours || "Saturday – Thursday: 9:00 AM – 8:00 PM";
  const wholesaleTitle = contactPage?.wholesale_banner_title || "Looking for Wholesale Supply in Dhaka?";
  const wholesaleDesc = contactPage?.wholesale_banner_desc || "We supply insulated, chilled batches directly to grocery stores, restaurants, and eateries within 24 hours.";

const primaryPhone = contactData?.primary_phone || contactData?.phone_primary || "01306-312372";
const secondaryPhone = contactData?.dealership_phone || contactData?.phone_secondary || "018265-813373";
const whatsappNum = contactData?.whatsapp_phone || contactData?.whatsapp_number || "+8801306312372";
const whatsappClean = whatsappNum.replace(/[^0-9]/g, '');


  return (
    <>
      <Head title="Contact Us - Wholesale & Dealership | Pure Sip Beverage" />

      <div className="min-h-screen bg-[#f4faf4] flex flex-col justify-between selection:bg-[#183928] selection:text-white">
        <Header settings={settings} />

        <main className="w-full flex-1 block">

          {/* ================= ১. পেজ হেডার ================= */}
          <section className="w-full py-12 sm:py-16 px-4 sm:px-8 lg:px-12 block">
            <div className="max-w-3xl mx-auto text-center space-y-4">
              <div className="inline-flex items-center gap-2 bg-[#183928] text-emerald-300 text-xs font-black tracking-widest uppercase px-4 py-1.5 rounded-full shadow-sm">
                <Sparkles className="w-3.5 h-3.5 text-amber-400" />
                <span>{badge}</span>
              </div>

              <h1 className="text-4xl sm:text-5xl lg:text-6xl font-black text-[#112318] tracking-tight leading-[1.15]">
                {title} <br />
                <span className="text-[#183928]">{highlight}</span>
              </h1>

              <p className="text-gray-600 text-sm sm:text-base md:text-lg leading-relaxed font-normal max-w-2xl mx-auto">
                {subtitle}
              </p>
            </div>
          </section>

          {/* ================= ২. মেইন কন্টাক্ট গ্রিড ================= */}
          <section className="w-full pb-16 px-4 sm:px-8 lg:px-12 block">
            <div className="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-start">
              
              {/* বামপাশ: হটলাইন ও যোগাযোগ তথ্য */}
              <div className="lg:col-span-5 space-y-6">
                <div className="bg-[#183928] text-white p-7 sm:p-8 rounded-3xl shadow-xl space-y-6 relative overflow-hidden">
                  <div className="space-y-2">
                    <span className="text-[11px] font-bold text-emerald-300 uppercase tracking-wider block">
                      Direct Line & Instant Response
                    </span>
                    <h2 className="text-2xl sm:text-3xl font-black tracking-tight text-white">
                      Hotlines & Wholesale
                    </h2>
                    <p className="text-emerald-100/75 text-xs sm:text-sm leading-relaxed font-normal">
                      Call directly or send a quick WhatsApp message for instant delivery schedules across Dhaka.
                    </p>
                  </div>

                  <div className="space-y-3 pt-2">
                    <a
                      href={`tel:${primaryPhone}`}
                      className="flex items-center gap-3.5 p-3.5 rounded-2xl bg-white/10 hover:bg-white/20 transition-all active:scale-98"
                    >
                      <div className="w-11 h-11 rounded-xl bg-white text-[#183928] flex items-center justify-center font-bold shadow-sm flex-shrink-0">
                        <PhoneCall className="w-5 h-5" />
                      </div>
                      <div>
                        <p className="text-[11px] text-emerald-300 font-semibold">Primary Helpline</p>
                        <p className="text-sm sm:text-base font-black tracking-wide text-white">{primaryPhone}</p>
                      </div>
                    </a>

                    {secondaryPhone && (
                      <a
                        href={`tel:${secondaryPhone}`}
                        className="flex items-center gap-3.5 p-3.5 rounded-2xl bg-white/10 hover:bg-white/20 transition-all active:scale-98"
                      >
                        <div className="w-11 h-11 rounded-xl bg-white text-[#183928] flex items-center justify-center font-bold shadow-sm flex-shrink-0">
                          <PhoneCall className="w-5 h-5" />
                        </div>
                        <div>
                          <p className="text-[11px] text-emerald-300 font-semibold">Dealership & Distribution</p>
                          <p className="text-sm sm:text-base font-black tracking-wide text-white">{secondaryPhone}</p>
                        </div>
                      </a>
                    )}

                    <a
                      href={`https://wa.me/${whatsappClean}`}
                      target="_blank"
                      rel="noreferrer"
                      className="flex items-center gap-3.5 p-3.5 rounded-2xl bg-emerald-700/70 hover:bg-emerald-700 transition-all active:scale-98"
                    >
                      <div className="w-11 h-11 rounded-xl bg-white text-emerald-800 flex items-center justify-center font-bold shadow-sm flex-shrink-0">
                        <MessageCircle className="w-5 h-5" />
                      </div>
                      <div>
                        <p className="text-[11px] text-emerald-200 font-semibold">WhatsApp Inquiry</p>
                        <p className="text-sm sm:text-base font-black tracking-wide text-white">{whatsappNum}</p>
                      </div>
                    </a>
                  </div>
                </div>

                <div className="bg-white p-7 sm:p-8 rounded-3xl shadow-sm border border-emerald-900/5 space-y-5">
                  <div className="space-y-4 text-gray-700">
                    <div className="flex items-start gap-3.5">
                      <div className="w-10 h-10 rounded-xl bg-[#eef7ef] text-[#183928] flex items-center justify-center flex-shrink-0 mt-0.5">
                        <MapPin className="w-5 h-5" />
                      </div>
                      <div>
                        <h3 className="text-sm font-black text-[#112318]">{addressTitle}</h3>
                        <p className="text-xs text-gray-600 mt-0.5 leading-relaxed">
                          {addressDesc}
                        </p>
                      </div>
                    </div>

                    <div className="flex items-start gap-3.5">
                      <div className="w-10 h-10 rounded-xl bg-[#eef7ef] text-[#183928] flex items-center justify-center flex-shrink-0 mt-0.5">
                        <Mail className="w-5 h-5" />
                      </div>
                      <div>
                        <h3 className="text-sm font-black text-[#112318]">Official Email</h3>
                        <p className="text-xs text-gray-600 mt-0.5">
                          {email}
                        </p>
                      </div>
                    </div>

                    <div className="flex items-start gap-3.5">
                      <div className="w-10 h-10 rounded-xl bg-[#eef7ef] text-[#183928] flex items-center justify-center flex-shrink-0 mt-0.5">
                        <Clock className="w-5 h-5" />
                      </div>
                      <div>
                        <h3 className="text-sm font-black text-[#112318]">Operational Hours</h3>
                        <p className="text-xs text-gray-600 mt-0.5">
                          {hours}
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              {/* ডানপাশ: রিয়েল ইনকোয়ারি ফর্ম */}
              <div className="lg:col-span-7 bg-white p-7 sm:p-10 rounded-3xl shadow-sm border border-emerald-900/5 space-y-6">
                <div className="space-y-2">
                  <div className="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-800 bg-[#eef7ef] px-3 py-1 rounded-full">
                    <ShieldCheck className="w-3.5 h-3.5 text-emerald-600" />
                    <span>Quick Response Guaranteed</span>
                  </div>
                  <h2 className="text-2xl sm:text-3xl font-black text-[#112318] tracking-tight">
                    Send an Inquiry
                  </h2>
                  <p className="text-gray-600 text-xs sm:text-sm">
                    Fill out the form below and our distribution team will respond within 2 hours.
                  </p>
                </div>

                {recentlySuccessful && (
                  <div className="p-4 rounded-2xl bg-[#eef7ef] text-[#183928] flex items-center gap-3 text-xs sm:text-sm font-bold border border-emerald-200">
                    <CheckCircle2 className="w-5 h-5 text-emerald-600 flex-shrink-0" />
                    <span>Thank you! Your inquiry has been sent and saved. We will contact you shortly.</span>
                  </div>
                )}

                <form onSubmit={handleSubmit} className="space-y-5">
                  <div className="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div className="space-y-2">
                      <label className="text-xs font-bold text-[#112318] uppercase tracking-wider block">
                        Full Name *
                      </label>
                      <input
                        type="text"
                        required
                        placeholder="e.g. Tanvir Ahmed"
                        value={data.name}
                        onChange={(e) => setData("name", e.target.value)}
                        className="w-full bg-[#f4faf4] text-[#112318] text-sm rounded-xl px-4 py-3.5 border border-emerald-900/10 focus:outline-none focus:ring-2 focus:ring-[#183928] transition-all"
                      />
                      {errors.name && <p className="text-xs text-red-500 font-medium">{errors.name}</p>}
                    </div>

                    <div className="space-y-2">
                      <label className="text-xs font-bold text-[#112318] uppercase tracking-wider block">
                        Phone Number *
                      </label>
                      <input
                        type="tel"
                        required
                        placeholder="01XXXXXXXXX"
                        value={data.phone}
                        onChange={(e) => setData("phone", e.target.value)}
                        className="w-full bg-[#f4faf4] text-[#112318] text-sm rounded-xl px-4 py-3.5 border border-emerald-900/10 focus:outline-none focus:ring-2 focus:ring-[#183928] transition-all"
                      />
                      {errors.phone && <p className="text-xs text-red-500 font-medium">{errors.phone}</p>}
                    </div>
                  </div>

                  <div className="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div className="space-y-2">
                      <label className="text-xs font-bold text-[#112318] uppercase tracking-wider block">
                        Email Address
                      </label>
                      <input
                        type="email"
                        placeholder="name@example.com"
                        value={data.email}
                        onChange={(e) => setData("email", e.target.value)}
                        className="w-full bg-[#f4faf4] text-[#112318] text-sm rounded-xl px-4 py-3.5 border border-emerald-900/10 focus:outline-none focus:ring-2 focus:ring-[#183928] transition-all"
                      />
                      {errors.email && <p className="text-xs text-red-500 font-medium">{errors.email}</p>}
                    </div>

                    <div className="space-y-2">
                      <label className="text-xs font-bold text-[#112318] uppercase tracking-wider block">
                        Inquiry Reason
                      </label>
                      <select
                        value={data.inquiry_type}
                        onChange={(e) => setData("inquiry_type", e.target.value)}
                        className="w-full bg-[#f4faf4] text-[#112318] text-sm rounded-xl px-4 py-3.5 border border-emerald-900/10 focus:outline-none focus:ring-2 focus:ring-[#183928] transition-all cursor-pointer"
                      >
                        <option value="Dealership & Wholesale">Retail Dealership & Supply</option>
                        <option value="Restaurant / Cafe Partnership">Restaurant / Cafe Partnership</option>
                        <option value="Event Bulk Supply">Event / Catering Bulk Order</option>
                        <option value="General Feedback">Customer Feedback & Support</option>
                      </select>
                    </div>
                  </div>

                  <div className="space-y-2">
                    <label className="text-xs font-bold text-[#112318] uppercase tracking-wider block">
                      Your Requirement / Message *
                    </label>
                    <textarea
                      rows={4}
                      required
                      placeholder="Tell us about your store location, estimated crate requirement, or event details..."
                      value={data.message}
                      onChange={(e) => setData("message", e.target.value)}
                      className="w-full bg-[#f4faf4] text-[#112318] text-sm rounded-xl px-4 py-3.5 border border-emerald-900/10 focus:outline-none focus:ring-2 focus:ring-[#183928] transition-all"
                    />
                    {errors.message && <p className="text-xs text-red-500 font-medium">{errors.message}</p>}
                  </div>

                  <button
                    type="submit"
                    disabled={processing}
                    className="w-full bg-[#183928] hover:bg-[#122c1f] text-white text-sm font-bold py-4 px-6 rounded-xl flex items-center justify-center gap-2 shadow-md hover:shadow-xl transition-all active:scale-95 cursor-pointer disabled:opacity-50"
                  >
                    <span>{processing ? "Sending to Database..." : "Submit Inquiry"}</span>
                    <Send className="w-4 h-4" />
                  </button>
                </form>
              </div>

            </div>
          </section>

          {/* ================= ৩. রিটেইল ব্যানার ================= */}
          <section className="w-full pb-20 px-4 sm:px-8 lg:px-12 block">
            <div className="max-w-7xl mx-auto">
              <div className="bg-[#eef7ef] border border-emerald-900/10 rounded-3xl p-7 sm:p-10 flex flex-col md:flex-row items-center justify-between gap-6">
                <div className="flex items-center gap-4">
                  <div className="w-12 h-12 rounded-2xl bg-[#183928] text-white flex items-center justify-center flex-shrink-0 shadow-sm">
                    <Building2 className="w-6 h-6" />
                  </div>
                  <div>
                    <h3 className="text-base sm:text-lg font-bold text-[#112318]">
                      {wholesaleTitle}
                    </h3>
                    <p className="text-xs sm:text-sm text-gray-600 mt-0.5">
                      {wholesaleDesc}
                    </p>
                  </div>
                </div>

                <a
                  href={`tel:${primaryPhone}`}
                  className="bg-[#183928] text-white hover:bg-[#122c1f] text-xs sm:text-sm font-black px-7 py-3.5 rounded-xl shadow whitespace-nowrap transition-all active:scale-95"
                >
                  Call: {primaryPhone}
                </a>
              </div>
            </div>
          </section>

        </main>

        <Footer settings={settings} />
      </div>
    </>
  );
}