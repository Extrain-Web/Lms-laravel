const ingredients = [
  {
    id: "cumin",
    name: "CUMIN",
    iconPath: "/images/cumin-icon.png", 
    description: "Rich in antioxidants & aids digestion",
  },
  {
    id: "lemon",
    name: "LEMON",
    iconPath: "/images/lemon-icon.png",
    description: "Natural Vitamin C & instant freshness",
  },
  {
    id: "ginger",
    name: "GINGER",
    iconPath: "/images/ginger-icon.png",
    description: "Boosts immunity & gut metabolism",
  },
  {
    id: "black-pepper",
    name: "BLACK PEPPER",
    iconPath: "/images/black-pepper.png",
    description: "Bioactive piperine for digestive health",
  },
  {
    id: "tamarind",
    name: "TAMARIND",
    iconPath: "/images/tamarind-icon.png",
    description: "Traditional tangy coolness & gut soothing",
  },
];

export default function NaturalIngredients() {
  return (
    <section className="pt-20 pb-5 px-4 sm:px-8 lg:px-12 w-full bg-[#f4faf4] selection:bg-[#183928] selection:text-white">
      <div className="max-w-7xl mx-auto space-y-16">
        
        {/* Header */}
        <div className="text-center space-y-2 max-w-3xl mx-auto">
          <h2 className="text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight text-[#112318]">
            Desi Punch in this New Age Drink
          </h2>
          <p className="font-serif italic text-[#65a30d] text-lg sm:text-2xl font-medium tracking-wide">
            Natural Ingredients
          </p>
        </div>

        {/* 5 Circular Image Grid */}
        <div className="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-8 sm:gap-10 lg:gap-8 justify-items-center">
          {ingredients.map((item) => (
            <div
              key={item.id}
              className="flex flex-col items-center group cursor-pointer transition-transform duration-300 hover:-translate-y-2"
            >
              <div className="relative w-36 h-36 sm:w-40 sm:h-40 rounded-full flex items-center justify-center p-2 transition-all duration-300">
                <div className="relative w-full h-full rounded-full overflow-hidden transition-transform group-hover:scale-110 duration-300">
                  <img
                    src={item.iconPath}
                    alt={`${item.name} Icon`}
                    className="w-full h-full object-contain"
                  />
                </div>
              </div>

              <span className="mt-3 text-[11px] font-medium text-gray-500 text-center max-w-[130px] opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                {item.description}
              </span>
            </div>
          ))}
        </div>

      </div>
    </section>
  );
}