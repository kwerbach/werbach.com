import { ExternalLink } from 'lucide-react';

interface EventCardProps {
  title: string;
  location: string;
  year: string;
  link?: string;
}

const CARD_COLORS = [
  '#F59E0B', '#0EA5E9', '#A855F7', '#10B981', '#EAB308',
  '#84CC16', '#EC4899', '#06B6D4', '#8B5CF6', '#14B8A6'
];

export default function EventCard({ title, location, year, link }: EventCardProps) {
  const hasLink = Boolean(link && link.trim());
  
  // Get a consistent color based on title
  const cardColor = CARD_COLORS[Math.abs(title.split('').reduce((acc, char) => acc + char.charCodeAt(0), 0)) % CARD_COLORS.length];

  const cardContent = (
    <div className="group">
      <div
        className="relative bg-gradient-to-br via-[#443850]/80 to-black rounded-2xl p-5 shadow-lg transition-all duration-300 hover:shadow-2xl hover:-translate-y-1 hover:scale-[1.02] min-h-[120px] flex flex-col"
        style={{
          backgroundImage: `linear-gradient(to bottom right, ${cardColor}85, #44385080, black)`,
          boxShadow: `0 10px 15px -3px ${cardColor}70, 0 4px 6px -4px ${cardColor}70`
        }}
        onMouseEnter={(e) => {
          e.currentTarget.style.boxShadow = `0 20px 25px -5px ${cardColor}95, 0 8px 10px -6px ${cardColor}95`;
        }}
        onMouseLeave={(e) => {
          e.currentTarget.style.boxShadow = `0 10px 15px -3px ${cardColor}70, 0 4px 6px -4px ${cardColor}70`;
        }}
      >
        <div
          className="absolute inset-0 bg-gradient-to-br to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-2xl"
          style={{
            backgroundImage: `linear-gradient(to bottom right, ${cardColor}90, transparent)`
          }}
        />

        <div className="relative z-10 flex-1 flex flex-col">
          {/* Title */}
          <h3 className="text-base font-semibold text-white mb-2 line-clamp-3 flex-grow">
            {title}
            {hasLink && (
              <ExternalLink className="inline-block ml-2 w-4 h-4 text-white/70" />
            )}
          </h3>

          {/* Location and Year */}
          <div className="mt-auto">
            {location && (
              <p className="text-sm text-white/80 italic line-clamp-1">{location}</p>
            )}
            <p className="text-sm text-white/60 mt-1">{year}</p>
          </div>
        </div>
      </div>
    </div>
  );

  if (hasLink) {
    return (
      <a
        href={link}
        target="_blank"
        rel="noopener noreferrer"
        className="block focus:outline-none focus:ring-2 focus:ring-citron focus:ring-offset-2 focus:ring-offset-black rounded-2xl"
      >
        {cardContent}
      </a>
    );
  }

  return cardContent;
}
