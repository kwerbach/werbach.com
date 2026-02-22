import { Link } from 'react-router-dom';

interface BookCardProps {
  title: string;
  year?: string;
  summary: string;
  link: string;
  coverImage?: string;
  amazonLink?: string;
  className?: string;
  compact?: boolean;
  color?: string;
}

const BOOK_COLORS = [
  '#F59E0B', '#0EA5E9', '#A855F7', '#10B981'
];

export default function BookCard({
  title,
  year,
  summary,
  link,
  coverImage,
  amazonLink,
  className,
  compact = false,
  color
}: BookCardProps) {
  // Get a consistent color based on title if not provided
  const cardColor = color || BOOK_COLORS[Math.abs(title.split('').reduce((acc, char) => acc + char.charCodeAt(0), 0)) % BOOK_COLORS.length];

  // Compact version - just cover and title
  if (compact) {
    return (
      <article className={`shrink-0 w-32 group ${className ?? ''}`}>
        <Link to={link} className="block">
          {/* Book Cover */}
          <div className="aspect-[2/3] bg-english_violet-500 relative overflow-hidden rounded-lg transition-colors">
            {coverImage ? (
              <img
                src={coverImage}
                alt={`Cover of ${title}`}
                loading="lazy"
                className="w-full h-full object-cover"
              />
            ) : (
              <div className="w-full h-full flex items-center justify-center p-2 text-center">
                <div>
                  <div className="text-2xl mb-2">📖</div>
                  <h3 className="text-xs font-bold text-white leading-tight">
                    {title}
                  </h3>
                </div>
              </div>
            )}
          </div>

          {/* Title below cover */}
          <h3 className="mt-2 text-sm font-semibold text-white group-hover:text-citron transition-colors line-clamp-2 text-center">
            {title}
          </h3>
        </Link>
      </article>
    );
  }

  // Full version with new card design
  return (
    <article className={className}>
      <Link to={link} className="block group">
        <div
          className="relative bg-gradient-to-br via-[#443850]/80 to-black rounded-2xl shadow-lg transition-all duration-300 hover:shadow-2xl hover:-translate-y-1 hover:scale-[1.02] overflow-hidden"
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
            className="absolute inset-0 bg-gradient-to-br to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"
            style={{
              backgroundImage: `linear-gradient(to bottom right, ${cardColor}90, transparent)`
            }}
          />

          {/* Book Cover at top */}
          <div className="relative aspect-[3/2] bg-black/20 overflow-hidden">
            {coverImage ? (
              <img
                src={coverImage}
                alt={`Cover of ${title}`}
                loading="lazy"
                className="w-full h-full object-contain p-6"
              />
            ) : (
              <div className="w-full h-full flex items-center justify-center p-6 text-center">
                <div>
                  <div className="text-4xl mb-4">📖</div>
                  <h3 className="text-lg font-bold text-white leading-tight">
                    {title}
                  </h3>
                </div>
              </div>
            )}
          </div>

          {/* Book Info */}
          <div className="relative p-6">
            <h3 className="text-xl font-bold text-white mb-2 line-clamp-2">
              {title}
            </h3>
            {year && (
              <p className="text-sm text-beige-300 mb-3 font-semibold">
                {year}
              </p>
            )}
            <p className="text-beige-300 line-clamp-3 text-sm leading-relaxed">{summary}</p>

            {/* Amazon Buy Link */}
            {amazonLink && (
              <div className="mt-4 pt-4 border-t border-white/10">
                <a
                  href={amazonLink}
                  target="_blank"
                  rel="noopener noreferrer"
                  onClick={(e) => e.stopPropagation()}
                  className="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold bg-white/20 text-white rounded hover:bg-white/30 transition-colors w-full justify-center"
                >
                  <span>📚</span>
                  Buy on Amazon
                </a>
              </div>
            )}
          </div>
        </div>
      </Link>
    </article>
  );
}
