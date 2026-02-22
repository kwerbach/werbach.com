import { ExternalLink } from 'lucide-react';

interface CitationProps {
  venue?: string;
  year?: string;
  doi?: string;
  url?: string;
  className?: string;
}

export default function Citation({ venue, year, doi, url, className = '' }: CitationProps) {
  // Build citation text
  const citationParts: string[] = [];
  if (venue) citationParts.push(venue);
  if (year) citationParts.push(year);

  const citationText = citationParts.join(', ');

  return (
    <div className={`text-sm text-gray-600 space-y-1 ${className}`}>
      {/* Venue and Year */}
      {citationText && (
        <p className="font-medium italic">{citationText}</p>
      )}

      {/* DOI and URL Links */}
      <div className="flex flex-wrap items-center gap-3">
        {doi && (
          <a
            href={`https://doi.org/${doi}`}
            target="_blank"
            rel="noopener noreferrer"
            className="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 hover:underline focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-1 rounded"
            aria-label={`View DOI ${doi}`}
          >
            <span className="font-mono text-xs">DOI: {doi}</span>
            <ExternalLink className="w-3 h-3" aria-hidden="true" />
          </a>
        )}

        {url && (
          <a
            href={url}
            target="_blank"
            rel="noopener noreferrer"
            className="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 hover:underline focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-1 rounded"
            aria-label="View publication online"
          >
            <span className="text-xs">View Online</span>
            <ExternalLink className="w-3 h-3" aria-hidden="true" />
          </a>
        )}
      </div>
    </div>
  );
}
