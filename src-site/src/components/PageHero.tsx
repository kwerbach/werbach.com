interface PageHeroProps {
  title: string;
  subtitle?: string;
}

export default function PageHero({ title, subtitle }: PageHeroProps) {
  return (
    <div className="bg-black border-b border-english_violet-400">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 className="text-xl md:text-2xl font-semibold tracking-wide text-white mb-1">
          {title}
        </h1>
        {subtitle && (
          <p className="text-sm md:text-base text-beige-700 max-w-2xl">
            {subtitle}
          </p>
        )}
      </div>
    </div>
  );
}
