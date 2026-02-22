import { Link } from 'react-router-dom';
import { motion } from 'framer-motion';
import { useState, useEffect } from 'react';
import Citation from './Citation';

interface ContentCardProps {
  title: string;
  date?: string;
  summary: string;
  link: string;
  venue?: string;
  year?: string;
  doi?: string;
  url?: string;
  tags?: string[];
  type?: string;
  className?: string;
}

export default function ContentCard({
  title,
  date,
  summary,
  link,
  venue,
  year,
  doi,
  url,
  tags,
  type,
  className = ''
}: ContentCardProps) {
  const [prefersReducedMotion, setPrefersReducedMotion] = useState(false);

  useEffect(() => {
    const mediaQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
    setPrefersReducedMotion(mediaQuery.matches);

    const handleChange = (e: MediaQueryListEvent) => {
      setPrefersReducedMotion(e.matches);
    };

    mediaQuery.addEventListener('change', handleChange);
    return () => mediaQuery.removeEventListener('change', handleChange);
  }, []);

  return (
    <motion.article
      whileHover={prefersReducedMotion ? {} : { y: -4 }}
      className={`bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition-shadow ${className}`}
    >
      <Link
        to={link}
        className="block focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 rounded"
        aria-label={`Read more about ${title}`}
      >
        {/* Citation-first layout for academic credibility */}
        {(venue || year || doi || url) && (
          <Citation venue={venue} year={year} doi={doi} url={url} className="mb-3" />
        )}

        <h3 className="text-xl font-bold text-gray-900 mb-2 hover:text-blue-600 transition-colors">
          {title}
        </h3>

        {date && (
          <time className="text-sm text-gray-500 mb-3 block" dateTime={date}>
            {new Date(date).toLocaleDateString('en-US', {
              year: 'numeric',
              month: 'long',
              day: 'numeric'
            })}
          </time>
        )}

        <p className="text-gray-700 mb-4 line-clamp-3">{summary}</p>

        {/* Tags and Type */}
        <div className="flex flex-wrap items-center gap-2">
          {type && (
            <span className="px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded">
              {type}
            </span>
          )}
          {tags && tags.length > 0 && (
            <div className="flex flex-wrap gap-2" role="list" aria-label="Tags">
              {tags.map((tag) => (
                <span
                  key={tag}
                  className="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded"
                  role="listitem"
                >
                  {tag}
                </span>
              ))}
            </div>
          )}
        </div>
      </Link>
    </motion.article>
  );
}
