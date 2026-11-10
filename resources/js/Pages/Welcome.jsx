import Header from "@/Components/Header";
import Banner from "@/Components/Banner";
import NaturalIngredients from "@/Components/NaturalIngredients";
import FeaturedJuices from "@/Components/FeaturedJuices";
import WhyChooseUs from "@/Components/WhyChooseUs";
import FrequentlyAskedQuestion from "@/Components/FrequentlyAskedQuestion";
import Testimonials from "@/Components/Testimonials";
import Footer from "@/Components/Footer";

export default function Welcome({ products = [], settings = {} }) {
    return (
        <div className="relative min-h-screen bg-[#f4faf4] flex flex-col selection:bg-[#183928] selection:text-white">
            <Header settings={settings} />

            <main className="flex-1">
                <Banner settings={settings} />
                <NaturalIngredients />
                <FeaturedJuices products={products} settings={settings} />
                <WhyChooseUs data={settings?.why_choose_us} />
                <FrequentlyAskedQuestion faqs={settings?.home_faqs} />
                <Testimonials reviews={settings?.home_testimonials} />
            </main>

            <Footer settings={settings} />
        </div>
    );
}
