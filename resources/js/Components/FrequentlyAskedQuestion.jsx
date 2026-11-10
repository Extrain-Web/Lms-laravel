import { useState } from "react";
import { ChevronDown, HelpCircle, MessageCircle } from "lucide-react";

// আগের ৫টি ডিফল্ট প্রশ্ন (ডাটাবেজ খালি থাকলে এটি দেখাবে)
const defaultFaqs = [
  {
    question: "What makes Pure Sip drinks 100% natural and unique?",
    answer:
      "Our drinks are crafted directly from cold-extracted garden mint, raw fruits, ginger, and Ayurvedic spices like cumin and black pepper. We use zero artificial colors, synthetic flavors, or chemical preservatives.",
  },
  {
    question: "How should I store the pouches and what is the shelf life?",
    answer:
      "Pure Sip pouches are best enjoyed chilled. Keep them refrigerated (2°C - 5°C) to maintain maximum botanical freshness. Since we do not add harsh preservatives, consume within 10 to 14 days of manufacturing.",
  },
  {
    question: "Are these drinks safe for children and daily digestion?",
    answer:
      "Yes, absolutely. All ingredients—such as fresh lemon, cumin, and ginger—are traditional natural foods that support gut health, alleviate acidity after heavy meals, and keep the whole family hydrated.",
  },
  {
    question: "How is it possible to offer premium botanical drinks at only Tk 10?",
    answer:
      "By sourcing herbs directly from regional farmers and utilizing lightweight, food-grade eco-pouches instead of costly heavy glass bottles, we pass the cost savings directly to our consumers.",
  },
  {
    question: "How can I order in bulk for events or apply for wholesale dealership?",
    answer:
      "For retail supply, restaurant partnerships, or wedding/event bulk orders, please call our direct hotline at 01306-312372 / 018265-813373 or reach out via WhatsApp.",
  },
];

// faqs প্রপস রিসিভ করা হচ্ছে
export default function FrequentlyAskedQuestion({ faqs = [] }) {
  const [openIndex, setOpenIndex] = useState(0);

  // ডাটাবেজে ডাটা থাকলে তা দেখাবে, না থাকলে ডিফল্ট প্রশ্নগুলো দেখাবে
  const activeFaqs = Array.isArray(faqs) && faqs.length > 0 ? faqs : defaultFaqs;

  const toggleFAQ = (index) => {
    setOpenIndex(openIndex === index ? -1 : index);
  };

  return (
    <section className="py-24 px-4 sm:px-8 lg:px-12 w-full bg-[#f4faf4] selection:bg-[#183928] selection:text-white">
      <div className="max-w-4xl mx-auto space-y-12">
        
        {/* Section Header */}
        <div className="text-center space-y-3">
          <div className="inline-flex items-center gap-2 bg-[#183928] text-emerald-300 text-xs font-black tracking-widest uppercase px-4 py-1.5 rounded-full shadow-sm">
            <HelpCircle className="w-3.5 h-3.5" />
            <span>Got Questions?</span>
          </div>
          <h2 className="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#112318] tracking-tight">
            Frequently Asked Questions
          </h2>
          <p className="text-gray-600 text-sm sm:text-base max-w-xl mx-auto">
            Everything you need to know about our ingredients, storage, and natural brewing process.
          </p>
        </div>

        {/* Accordion List */}
        <div className="space-y-4">
          {activeFaqs.map((faq, index) => {
            const isOpen = openIndex === index;
            return (
              <div
                key={index}
                className="bg-white rounded-2xl shadow-sm transition-all duration-200 overflow-hidden"
              >
                <button
                  onClick={() => toggleFAQ(index)}
                  className="w-full text-left px-6 py-6 flex items-center justify-between gap-4 font-semibold text-[#112318] text-base sm:text-lg hover:text-[#183928] transition-colors cursor-pointer"
                  aria-expanded={isOpen}
                >
                  <span>{faq.question}</span>
                  <div
                    className={`w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 transition-transform duration-300 ${
                      isOpen
                        ? "bg-[#183928] text-white rotate-180"
                        : "bg-[#eef7ef] text-[#183928]"
                    }`}
                  >
                    <ChevronDown className="w-4 h-4" />
                  </div>
                </button>

                {isOpen && (
                  <div className="px-6 pb-5 pt-1 text-sm sm:text-base text-gray-600 leading-relaxed">
                    {faq.answer}
                  </div>
                )}
              </div>
            );
          })}
        </div>

        {/* Quick Contact Box */}
        <div className="p-6 rounded-2xl bg-[#eef7ef] border border-[#eff4f0] text-center flex flex-col sm:flex-row items-center justify-between gap-4">
          <div className="flex items-center gap-3 text-left">
            <div className="w-10 h-10 rounded-full bg-[#183928] text-white flex items-center justify-center flex-shrink-0">
              <MessageCircle className="w-5 h-5" />
            </div>
            <div>
              <h4 className="text-sm font-bold text-[#112318]">Still have questions?</h4>
              <p className="text-xs text-gray-600">Our customer support team is always ready to assist you.</p>
            </div>
          </div>
          <a
            href="tel:01306312372"
            className="bg-[#183928] hover:bg-[#122c1f] text-white text-xs font-bold px-6 py-3 rounded-xl shadow transition-all whitespace-nowrap"
          >
            Call: 01306-312372
          </a>
        </div>

      </div>
    </section>
  );
}