import { usePage } from "@inertiajs/react";

export default function Banner() {
  const { settings } = usePage().props;

  const bannerSrc = settings?.banner_image || "/images/banner.jpeg";

  return (
    <section className="relative w-full h-[220px] xs:h-[280px] sm:h-[380px] md:h-[480px] lg:h-[580px] xl:h-[650px] 2xl:h-[800px] overflow-hidden bg-[#183928]/5">
      <img
        src={bannerSrc}
        alt="Pure Sip Juice Showcase"
        className="w-full h-full object-cover object-center"
        loading="eager"
        onError={(e) => {
          e.target.src = "/images/banner.jpeg";
        }}
      />
    </section>
  );
}