import { Link } from 'react-router-dom';
import { ExternalLink } from 'lucide-react';

interface CardProps {
  title: string;
  date?: string;
  summary: string;
  link?: string;
  tags?: string[];
  className?: string;
  image?: string;
  imageContain?: boolean;
  externalLinks?: {
    pdf?: string;
    ssrn?: string;
    doi?: string;
    external?: string;
  };
  authors?: string[];
  publication?: string;
  compactMeta?: boolean;
  color?: string;
}

const CARD_COLORS = [
  '#F59E0B', '#0EA5E9', '#A855F7', '#10B981', '#EAB308',
  '#84CC16', '#EC4899', '#06B6D4', '#8B5CF6', '#14B8A6'
];

export default function Card({ title, date, summary, link, tags, className, image, imageContain, externalLinks, authors, publication, compactMeta, color }: CardProps) {
  const isClickable = Boolean(link && link.trim());
  const isExternalLink = isClickable ? /^https?:\/\//i.test(link as string) : false;

  // Get a consistent color based on title if not provided
  const cardColor = color || CARD_COLORS[Math.abs(title.split('').reduce((acc, char) => acc + char.charCodeAt(0), 0)) % CARD_COLORS.length];

  const cardContent = (
    <div className="group">
      <div
        className="relative bg-gradient-to-br via-[#443850]/80 to-black rounded-2xl p-6 shadow-lg transition-all duration-300 hover:shadow-2xl hover:-translate-y-1 hover:scale-[1.02] min-h-[220px] flex flex-col"
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

        {/* Image at top if present */}
        {image && (
          <div className="relative mb-4 -mx-6 -mt-6">
            <div className="rounded-t-2xl overflow-hidden bg-black/20" style={{ aspectRatio: imageContain ? 'auto' : '16/9' }}>
              <img
                src={image}
                alt={title}
                className={`w-full ${imageContain ? 'object-contain p-4' : 'object-cover h-full'}`}
              />
            </div>
          </div>
        )}

        <div className="relative flex-1 flex flex-col">
          {/* Title */}
          <h3 className="text-lg font-bold leading-tight text-white mb-3">
            {title}
          </h3>

          {/* Metadata */}
          {(authors || publication || date) && (
            <div className={`mb-3 ${compactMeta && 'mb-2'}`}>
              {publication && (
                <p className="text-xs uppercase tracking-wide text-white/90 font-semibold mb-1">
                  {publication}
                </p>
              )}
              {authors && authors.length > 0 && (
                <p className="text-xs text-beige-300 mb-1">
                  {authors.join(', ')}
                </p>
              )}
              {date && (
                <time className="text-xs text-beige-400" dateTime={date}>
                  {new Date(date).toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                  })}
                </time>
              )}
            </div>
          )}

          {/* Summary */}
          <p className="text-sm text-beige-300 mb-3 leading-relaxed line-clamp-3 flex-1">
            {summary}
          </p>

          {/* Tags */}
          {tags && tags.length > 0 && (
            <div className="flex flex-wrap gap-1.5 mb-3">
              {tags.slice(0, 3).map((tag) => (
                <span
                  key={tag}
                  className="px-2 py-0.5 text-xs bg-white/10 text-white rounded"
                >
                  {tag}
                </span>
              ))}
            </div>
          )}

          {/* External Links */}
          {externalLinks && (externalLinks.pdf || externalLinks.ssrn || externalLinks.doi || externalLinks.external) && (
            <div className="flex flex-wrap gap-2 mt-auto pt-3 border-t border-white/10">
              {externalLinks.pdf && (
                <a
                  href={externalLinks.pdf}
                  target="_blank"
                  rel="noopener noreferrer"
                  onClick={(e) => e.stopPropagation()}
                  className="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold bg-white/20 text-white rounded hover:bg-white/30 transition-colors"
                >
                  <ExternalLink size={12} /> PDF
                </a>
              )}
              {externalLinks.ssrn && (
                <a
                  href={externalLinks.ssrn}
                  target="_blank"
                  rel="noopener noreferrer"
                  onClick={(e) => e.stopPropagation()}
                  className="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold bg-white/20 text-white rounded hover:bg-white/30 transition-colors"
                >
                  <ExternalLink size={12} /> SSRN
                </a>
              )}
              {externalLinks.doi && (
                <a
                  href={externalLinks.doi}
                  target="_blank"
                  rel="noopener noreferrer"
                  onClick={(e) => e.stopPropagation()}
                  className="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold bg-white/20 text-white rounded hover:bg-white/30 transition-colors"
                >
                  <ExternalLink size={12} /> DOI
                </a>
              )}
              {externalLinks.external && (
                <a
                  href={externalLinks.external}
                  target="_blank"
                  rel="noopener noreferrer"
                  onClick={(e) => e.stopPropagation()}
                  className="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold bg-white/20 text-white rounded hover:bg-white/30 transition-colors"
                >
                  <ExternalLink size={12} /> Link
                </a>
              )}
            </div>
          )}
        </div>
      </div>
    </div>
  );

  if (!isClickable) {
    return <article className={className}>{cardContent}</article>;
  }

  if (isExternalLink) {
    return (
      <article className={className}>
        <a
          href={link}
          target="_blank"
          rel="noopener noreferrer"
          className="block"
        >
          {cardContent}
        </a>
      </article>
    );
  }

  return (
    <article className={className}>
      <Link to={link as string} className="block">
        {cardContent}
      </Link>
    </article>
  );
}
