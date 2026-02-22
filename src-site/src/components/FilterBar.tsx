import { useSearchParams } from 'react-router-dom';
import { Filter, X } from 'lucide-react';
import { useState } from 'react';

interface FilterBarProps {
  topics?: string[];
  years?: string[];
  types?: string[];
  className?: string;
}

export default function FilterBar({ topics = [], years = [], types = [], className = '' }: FilterBarProps) {
  const [searchParams, setSearchParams] = useSearchParams();
  const [isOpen, setIsOpen] = useState(false);

  // Get current filter values from URL params
  const currentTopic = searchParams.get('topic') || '';
  const currentYear = searchParams.get('year') || '';
  const currentType = searchParams.get('type') || '';

  // Update URL params when filter changes
  const handleFilterChange = (key: string, value: string) => {
    const newParams = new URLSearchParams(searchParams);
    
    if (value) {
      newParams.set(key, value);
    } else {
      newParams.delete(key);
    }
    
    setSearchParams(newParams);
  };

  // Clear all filters
  const clearFilters = () => {
    setSearchParams(new URLSearchParams());
  };

  // Check if any filters are active
  const hasActiveFilters = currentTopic || currentYear || currentType;

  return (
    <div className={`bg-english_violet-600 border border-english_violet-400 rounded-lg p-4 ${className}`}>
      {/* Mobile Toggle */}
      <button
        onClick={() => setIsOpen(!isOpen)}
        className="md:hidden flex items-center gap-2 w-full justify-between text-white font-medium focus:outline-none focus:ring-2 focus:ring-green-600 rounded px-2 py-1"
        aria-expanded={isOpen}
        aria-controls="filter-content"
      >
        <span className="flex items-center gap-2">
          <Filter className="w-4 h-4" aria-hidden="true" />
          Filters
          {hasActiveFilters && (
            <span className="bg-green-600 text-white text-xs rounded-full px-2 py-0.5">
              Active
            </span>
          )}
        </span>
        <span className={`transform transition-transform ${isOpen ? 'rotate-180' : ''}`}>
          ▼
        </span>
      </button>

      {/* Filter Controls */}
      <div
        id="filter-content"
        className={`${isOpen ? 'block' : 'hidden'} md:block mt-4 md:mt-0`}
        role="region"
        aria-label="Content filters"
      >
        <div className="flex flex-col md:flex-row gap-4 items-start md:items-center">
          {/* Topic Filter */}
          {topics.length > 0 && (
            <div className="flex-1 w-full md:w-auto">
              <label htmlFor="topic-filter" className="block text-sm font-medium text-beige-700 mb-1">
                Topic
              </label>
              <select
                id="topic-filter"
                value={currentTopic}
                onChange={(e) => handleFilterChange('topic', e.target.value)}
                className="w-full px-3 py-2 bg-english_violet-500 border border-english_violet-300 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent"
                aria-label="Filter by topic"
              >
                <option value="">All Topics</option>
                {topics.map((topic) => (
                  <option key={topic} value={topic}>
                    {topic}
                  </option>
                ))}
              </select>
            </div>
          )}

          {/* Year Filter */}
          {years.length > 0 && (
            <div className="flex-1 w-full md:w-auto">
              <label htmlFor="year-filter" className="block text-sm font-medium text-beige-700 mb-1">
                Year
              </label>
              <select
                id="year-filter"
                value={currentYear}
                onChange={(e) => handleFilterChange('year', e.target.value)}
                className="w-full px-3 py-2 bg-english_violet-500 border border-english_violet-300 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent"
                aria-label="Filter by year"
              >
                <option value="">All Years</option>
                {years.sort((a, b) => Number(b) - Number(a)).map((year) => (
                  <option key={year} value={year}>
                    {year}
                  </option>
                ))}
              </select>
            </div>
          )}

          {/* Type Filter */}
          {types.length > 0 && (
            <div className="flex-1 w-full md:w-auto">
              <label htmlFor="type-filter" className="block text-sm font-medium text-beige-700 mb-1">
                Type
              </label>
              <select
                id="type-filter"
                value={currentType}
                onChange={(e) => handleFilterChange('type', e.target.value)}
                className="w-full px-3 py-2 bg-english_violet-500 border border-english_violet-300 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent"
                aria-label="Filter by type"
              >
                <option value="">All Types</option>
                {types.map((type) => (
                  <option key={type} value={type}>
                    {type}
                  </option>
                ))}
              </select>
            </div>
          )}

          {/* Clear Filters Button */}
          {hasActiveFilters && (
            <button
              onClick={clearFilters}
              className="flex items-center gap-2 px-4 py-2 text-sm text-beige-700 hover:text-white border border-english_violet-300 rounded-md hover:bg-english_violet-500 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 focus:ring-offset-black transition-colors md:mt-6"
              aria-label="Clear all filters"
            >
              <X className="w-4 h-4" aria-hidden="true" />
              Clear
            </button>
          )}
        </div>

        {/* Active Filters Display */}
        {hasActiveFilters && (
          <div className="mt-3 pt-3 border-t border-english_violet-400">
            <p className="text-sm text-beige-700 mb-2">Active filters:</p>
            <div className="flex flex-wrap gap-2" role="list" aria-label="Active filters">
              {currentTopic && (
                <span
                  className="inline-flex items-center gap-1 px-2 py-1 text-xs bg-green-900 text-green-300 rounded"
                  role="listitem"
                >
                  Topic: {currentTopic}
                  <button
                    onClick={() => handleFilterChange('topic', '')}
                    className="hover:bg-green-800 rounded-full p-0.5 focus:outline-none focus:ring-1 focus:ring-green-600"
                    aria-label={`Remove topic filter: ${currentTopic}`}
                  >
                    <X className="w-3 h-3" aria-hidden="true" />
                  </button>
                </span>
              )}
              {currentYear && (
                <span
                  className="inline-flex items-center gap-1 px-2 py-1 text-xs bg-green-900 text-green-300 rounded"
                  role="listitem"
                >
                  Year: {currentYear}
                  <button
                    onClick={() => handleFilterChange('year', '')}
                    className="hover:bg-green-800 rounded-full p-0.5 focus:outline-none focus:ring-1 focus:ring-green-600"
                    aria-label={`Remove year filter: ${currentYear}`}
                  >
                    <X className="w-3 h-3" aria-hidden="true" />
                  </button>
                </span>
              )}
              {currentType && (
                <span
                  className="inline-flex items-center gap-1 px-2 py-1 text-xs bg-green-900 text-green-300 rounded"
                  role="listitem"
                >
                  Type: {currentType}
                  <button
                    onClick={() => handleFilterChange('type', '')}
                    className="hover:bg-green-800 rounded-full p-0.5 focus:outline-none focus:ring-1 focus:ring-green-600"
                    aria-label={`Remove type filter: ${currentType}`}
                  >
                    <X className="w-3 h-3" aria-hidden="true" />
                  </button>
                </span>
              )}
            </div>
          </div>
        )}
      </div>
    </div>
  );
}
