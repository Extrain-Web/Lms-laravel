import { Link } from "@inertiajs/react";
import {
  Leaf,
  Mail,
  MapPin,
  MessageCircle,
  PhoneCall,
  ShieldCheck,
} from "lucide-react";
import { 
  FaFacebook, 
  FaYoutube, 
  FaTiktok, 
  FaLinkedin, 
  FaTwitter 
} from "react-icons/fa";
import { BsInstagram } from "react-icons/bs";

const defaultSignatureBlends = [
  { name: "Hozmi Cola (Digestive)", url: "/products/hozmi-cola" },
  { name: "Pudina Drink (Cool Mint)", url: "/products/pudina-drink" },
  { name: "Citrus Boost (Vitamin C)", url: "/products/citrus-boost" },
  { name: "Green Detox (Cleanse)", url: "/products/green-detox" },
];

export default function Footer({ settings = {} }) {
  const footer = settings?.footer_settings || {};
  const brandName = settings?.brand_name || "Pure Sip";
  const logo = settings?.logo || "/images/logo.jpeg";
  const primaryPhone = settings?.phone_primary || "01306-312372";
  const secondaryPhone = settings?.phone_secondary; // ফাঁকা থাকলে আর দেখাবে না
  const rawWhatsapp = settings?.whatsapp_number || "+8801306312372";
  const cleanWhatsapp = rawWhatsapp.replace(/[^0-9]/g, "");
  const email = settings?.email || "info@puresipbeverage.com";
  const address = settings?.address || "Pure Sip Beverage, Dhaka, Bangladesh";

  // হোলসেল কার্ড ও কিউআর ডাটা
  const wholesaleBadge = footer?.wholesale_badge || "Wholesale & Instant Order";
  const wholesaleTitle = footer?.wholesale_title || "Scan or Call to Order in Bulk";
  const wholesaleDesc = footer?.wholesale_desc || "Looking to stock our 10 Tk chilled botanical pouches at your shop or need bulk orders for events? Scan the QR code or call our direct helpline.";
  const qrImage = footer?.qr_image || "/images/qr-code.jpeg";
  const qrBadge = footer?.qr_badge || "BSTI Certified";
  const qrTitle = footer?.qr_title || "Scan to Verify";
  const qrDesc = footer?.qr_desc || "Official BSTI Approval & Lab Quality Certificate";

  // বায়ো ও ডাইনামিক সিগনেচার ব্লেন্ডস
  const bio = footer?.bio || "Natural botanical drinks crafted from cold-extracted mint, ginger, raw mango, and ancient spices for pristine digestion and pure everyday vitality.";
  const signatureBlends = Array.isArray(footer?.signature_blends) && footer.signature_blends.length > 0 
    ? footer.signature_blends 
    : defaultSignatureBlends;

  return (
    <footer className="w-full bg-[#0f2317] text-white selection:bg-emerald-400 selection:text-[#0f2317] relative overflow-hidden pt-20 pb-12">
      <div className="absolute top-0 left-1/4 w-96 h-96 bg-emerald-700/10 rounded-full blur-3xl pointer-events-none" />
      <div className="absolute bottom-0 right-10 w-96 h-96 bg-emerald-600/10 rounded-full blur-3xl pointer-events-none" />

      <div className="max-w-7xl mx-auto px-6 sm:px-12 relative z-10 space-y-16">
        
        {/* ================= Wholesale & QR Action Card ================= */}
        <div className="rounded-3xl p-8 sm:p-10 bg-[#183928] flex flex-col lg:flex-row items-center justify-between gap-8">
          <div className="space-y-3 text-center lg:text-left max-w-xl">
            <div className="inline-flex items-center gap-2 bg-white/10 text-emerald-300 text-xs font-bold px-3.5 py-1.5 rounded-full uppercase tracking-wider">
              <Leaf className="w-3.5 h-3.5" />
              <span>{wholesaleBadge}</span>
            </div>

            <h3 className="text-2xl sm:text-3xl font-black tracking-tight text-white">
              {wholesaleTitle}
            </h3>

            <p className="text-emerald-100/70 text-xs sm:text-sm leading-relaxed font-normal">
              {wholesaleDesc}
            </p>

            <div className="pt-2">
              <a
                href={`tel:${primaryPhone}`}
                className="inline-flex items-center gap-2 bg-white hover:bg-emerald-50 text-[#112318] text-xs sm:text-sm font-extrabold px-6 py-3.5 rounded-2xl shadow-xl transition-all hover:scale-105 active:scale-95 whitespace-nowrap"
              >
                <PhoneCall className="w-4 h-4 text-[#183928]" />
                <span>Call Helpline: {primaryPhone}</span>
              </a>
            </div>
          </div>

          <div className="bg-white p-4 sm:p-5 rounded-3xl shadow-xl flex flex-col sm:flex-row items-center gap-4 text-center sm:text-left flex-shrink-0">
            <div className="relative w-28 h-28 sm:w-32 sm:h-32 bg-[#f4faf4] rounded-2xl overflow-hidden shadow-inner flex items-center justify-center">
              <img
                src={qrImage}
                alt="Order QR Code"
                className="w-full h-full object-contain p-2"
                onError={(e) => { e.target.src = "/images/qr-code.jpeg"; }}
              />
            </div>

            <div className="space-y-1 text-[#112318] max-w-[160px]">
              <div className="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-800 bg-[#eef7ef] px-2 py-0.5 rounded-full uppercase">
                <ShieldCheck className="w-3 h-3 text-emerald-600" />
                <span>{qrBadge}</span>
              </div>
              <h4 className="text-sm font-black">{qrTitle}</h4>
              <p className="text-[11px] text-gray-500 leading-tight font-normal">
                {qrDesc}
              </p>
            </div>
          </div>
        </div>

        {/* ================= Footer Navigation Links ================= */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12 lg:gap-8">
          
          {/* Brand Bio & 6 Social Media Profiles */}
          <div className="lg:col-span-4 space-y-6">
            <Link href="/" className="flex items-center gap-3 group">
              <div className="w-12 h-12 relative rounded-full overflow-hidden bg-white shadow-md flex items-center justify-center transition-transform group-hover:scale-105">
                <img
                  src={logo}
                  alt={`${brandName} Logo`}
                  className="w-full h-full object-contain p-1"
                  onError={(e) => { e.target.src = "/images/logo.png"; }}
                />
              </div>
              <span className="font-black text-xl text-white tracking-wider uppercase">
                {brandName}
              </span>
            </Link>

            <p className="text-emerald-100/70 text-sm leading-relaxed max-w-sm font-normal">
              {bio}
            </p>

            <div className="flex flex-wrap items-center gap-2.5 text-emerald-200">
              {cleanWhatsapp && (
                <a
                  href={`https://wa.me/${cleanWhatsapp}`}
                  target="_blank"
                  rel="noreferrer"
                  className="w-9 h-9 rounded-xl bg-white/5 hover:bg-white/15 flex items-center justify-center text-white transition-colors"
                  title="WhatsApp"
                >
                  <MessageCircle className="w-4 h-4" />
                </a>
              )}
              {footer?.facebook_url && (
                <a
                  href={footer.facebook_url}
                  target="_blank"
                  rel="noreferrer"
                  className="w-9 h-9 rounded-xl bg-white/5 hover:bg-white/15 flex items-center justify-center text-white transition-colors"
                  title="Facebook"
                >
                  <FaFacebook className="w-4 h-4" />
                </a>
              )}
              {footer?.instagram_url && (
                <a
                  href={footer.instagram_url}
                  target="_blank"
                  rel="noreferrer"
                  className="w-9 h-9 rounded-xl bg-white/5 hover:bg-white/15 flex items-center justify-center text-white transition-colors"
                  title="Instagram"
                >
                  <BsInstagram className="w-4 h-4" />
                </a>
              )}
              {footer?.youtube_url && (
                <a
                  href={footer.youtube_url}
                  target="_blank"
                  rel="noreferrer"
                  className="w-9 h-9 rounded-xl bg-white/5 hover:bg-white/15 flex items-center justify-center text-white transition-colors"
                  title="YouTube"
                >
                  <FaYoutube className="w-4 h-4" />
                </a>
              )}
              {footer?.tiktok_url && (
                <a
                  href={footer.tiktok_url}
                  target="_blank"
                  rel="noreferrer"
                  className="w-9 h-9 rounded-xl bg-white/5 hover:bg-white/15 flex items-center justify-center text-white transition-colors"
                  title="TikTok"
                >
                  <FaTiktok className="w-4 h-4" />
                </a>
              )}
              {footer?.linkedin_url && (
                <a
                  href={footer.linkedin_url}
                  target="_blank"
                  rel="noreferrer"
                  className="w-9 h-9 rounded-xl bg-white/5 hover:bg-white/15 flex items-center justify-center text-white transition-colors"
                  title="LinkedIn"
                >
                  <FaLinkedin className="w-4 h-4" />
                </a>
              )}
              {footer?.twitter_url && (
                <a
                  href={footer.twitter_url}
                  target="_blank"
                  rel="noreferrer"
                  className="w-9 h-9 rounded-xl bg-white/5 hover:bg-white/15 flex items-center justify-center text-white transition-colors"
                  title="Twitter / X"
                >
                  <FaTwitter className="w-4 h-4" />
                </a>
              )}
            </div>
          </div>

          {/* Dynamic Signature Blends */}
          <div className="lg:col-span-3 space-y-4">
            <h4 className="text-sm font-extrabold text-emerald-400 tracking-widest uppercase">
              Signature Blends
            </h4>
            <ul className="space-y-2.5 text-sm text-emerald-100/75">
              {signatureBlends.map((blend, idx) => (
                <li key={idx}>
                  <Link href={blend.url || "#"} className="hover:text-white transition-colors">
                    {blend.name}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          {/* Company Links */}
          <div className="lg:col-span-2 space-y-4">
            <h4 className="text-sm font-extrabold text-emerald-400 tracking-widest uppercase">
              Company
            </h4>
            <ul className="space-y-2.5 text-sm text-emerald-100/75">
              <li><Link href="/" className="hover:text-white transition-colors">Home</Link></li>
              <li><Link href="/about" className="hover:text-white transition-colors">About Us</Link></li>
              <li><Link href="/our-drinks" className="hover:text-white transition-colors">Our Drinks</Link></li>
              <li><Link href="/contact" className="hover:text-white transition-colors">Contact Us</Link></li>
            </ul>
          </div>

          {/* Headquarters */}
          <div className="lg:col-span-3 space-y-4">
            <h4 className="text-sm font-extrabold text-emerald-400 tracking-widest uppercase">
              Headquarters
            </h4>
            <div className="space-y-3 text-xs sm:text-sm text-emerald-100/75">
              <div className="flex items-start gap-3">
                <MapPin className="w-4 h-4 text-emerald-400 flex-shrink-0 mt-0.5" />
                <span>{address}</span>
              </div>
              <div className="flex items-center gap-3">
                <PhoneCall className="w-4 h-4 text-emerald-400 flex-shrink-0" />
                <span>{primaryPhone} {secondaryPhone ? `/ ${secondaryPhone}` : ""}</span>
              </div>
              <div className="flex items-center gap-3">
                <Mail className="w-4 h-4 text-emerald-400 flex-shrink-0" />
                <span>{email}</span>
              </div>
            </div>
          </div>

        </div>

        {/* Copyright Bar */}
        <div className="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-emerald-100/50 font-medium">
          <p>© {new Date().getFullYear()} {brandName} Beverage. All rights reserved.</p>
          <div className="flex items-center gap-6">
            <Link href="#" className="hover:text-emerald-300 transition-colors">Privacy Policy</Link>
            <Link href="#" className="hover:text-emerald-300 transition-colors">Terms of Service</Link>
            <Link href="#" className="hover:text-emerald-300 transition-colors">Licensing</Link>
          </div>
        </div>

      </div>
    </footer>
  );
}