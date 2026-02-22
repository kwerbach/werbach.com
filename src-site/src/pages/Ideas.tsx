import { useState, useEffect } from 'react';
import { Helmet } from 'react-helmet-async';
import { useSearchParams } from 'react-router-dom';
import { ChevronDown, ChevronRight, Loader2 } from 'lucide-react';
import { motion, AnimatePresence } from 'framer-motion';
import Card from '../components/Card';
import BookCard from '../components/BookCard';
import PublicationCard from '../components/PublicationCard';
import EventCard from '../components/EventCard';
import { getAllContent } from '../lib/content';
import type { ContentItem } from '../lib/content';
import {
  scholarlyArticles,
  bookChaptersAndEssays,
  whitePapersAndReports,
  generalAndTradePress,
  invitedTestimony,
  events,
  type PublicationItem,
  type EventItem
} from '../data/publications';

const FEATURED_PROJECT_SLUGS = new Set(['accountable-ai', 'bdap', 'supernova']);
const PROJECT_EXTERNAL_LINKS: Record<string, string> = {
  'accountable-ai': 'https://whr.tn/accountable-ai-lab',
  'bdap': 'https://bdap.wharton.upenn.edu'
};

type CategoryConfig = {
  id: string;
  label: string;
  contentTypes: string[];
  filter?: (item: ContentItem) => boolean;
  staticData?: PublicationItem[];
  staticEventData?: EventItem[];
};

const categories: CategoryConfig[] = [
  { id: 'books', label: 'Books', contentTypes: ['books'] },
  { id: 'projects', label: 'Projects', contentTypes: ['projects'], filter: (item: ContentItem) => FEATURED_PROJECT_SLUGS.has(item.slug || '') },
  {
    id: 'papers',
    label: 'Scholarly Articles',
    contentTypes: [],
    staticData: scholarlyArticles,
  },
  { 
    id: 'essays', 
    label: 'Book Chapters and Essays', 
    contentTypes: [],
    staticData: bookChaptersAndEssays,
  },
  { 
    id: 'policy', 
    label: 'White Papers and Reports', 
    contentTypes: [],
    staticData: whitePapersAndReports,
  },
  {
    id: 'press',
    label: 'General and Trade Press',
    contentTypes: [],
    staticData: generalAndTradePress,
  },
  {
    id: 'testimony',
    label: 'Invited Testimony',
    contentTypes: [],
    staticData: invitedTestimony,
  },
  {
    id: 'events',
    label: 'Events',
    contentTypes: [],
    staticEventData: events,
  },
];

const LINK_PRIORITY: Array<keyof NonNullable<ContentItem['links']>> = [
  'pdf',
  'external',
  'ssrn',
  'doi',
  'conference',
  'execed',
  'podcast',
  'podcast_feed',
  'newsletter'
];

// Topic tags matching the home page categories
const TOPIC_TAGS = [
  { label: 'All', value: null, color: '#9CA3AF' },
  { label: 'Most Recent', value: 'most-recent', color: '#468189' },
  { label: 'Telecommunications', value: 'Telecommunications', color: '#F97316' },
  { label: 'Tech Policy', value: 'Tech Policy', color: '#7C3AED' },
  { label: 'Blockchain', value: 'Blockchain', color: '#22C55E' },
  { label: 'Gamification', value: 'Gamification', color: '#EC4899' },
  { label: 'AI Governance', value: 'AI Governance', color: '#4F46E5' },
  { label: 'Tech Business', value: 'Tech Business', color: '#FACC15' },
  { label: 'Future of Education', value: 'Future of Education', color: '#10B981' },
  { label: 'Decentralized Finance', value: 'Decentralized Finance', color: '#0EA5E9' },
  { label: 'DAOs', value: 'DAOs', color: '#06B6D4' },
  { label: 'China', value: 'China', color: '#DC2626' },
  { label: 'Other', value: 'Other', color: '#6B7280' },
];

const getPrimaryExternalLink = (item: ContentItem) => {
  if (!item.links) return undefined;
  for (const key of LINK_PRIORITY) {
    const value = item.links[key];
    if (typeof value === 'string' && value.trim()) {
      return value.trim();
    }
  }
  return undefined;
};

export default function Ideas() {
  const [searchParams, setSearchParams] = useSearchParams();
  const selectedTag = searchParams.get('tags');
  const [contentByCategory, setContentByCategory] = useState<Record<string, ContentItem[]>>({});
  const [openSections, setOpenSections] = useState<Record<string, boolean>>({
    books: true,
    projects: true,
    papers: false,
    essays: false,
    policy: false,
    press: false,
    testimony: false,
    events: false,
  });
  const [loadingCategories, setLoadingCategories] = useState<Record<string, boolean>>({});
  const [initialLoad, setInitialLoad] = useState(true);

  useEffect(() => {
    async function loadContentSequentially() {
      try {
        // Load priority categories first (books and projects)
        const priorityCategories = categories.filter(c => c.id === 'books' || c.id === 'projects');
        const otherCategories = categories.filter(c => c.id !== 'books' && c.id !== 'projects' && c.contentTypes.length > 0);

        // Mark priority categories as loading
        const loadingState: Record<string, boolean> = {};
        priorityCategories.forEach(cat => {
          loadingState[cat.id] = true;
        });
        setLoadingCategories(loadingState);

        // Load priority categories
        for (const category of priorityCategories) {
          await loadCategory(category);
          setLoadingCategories(prev => ({ ...prev, [category.id]: false }));
        }

        // Initial load complete - show priority content
        setInitialLoad(false);

        // Load remaining categories in parallel (only those with contentTypes)
        const otherLoadingState: Record<string, boolean> = {};
        otherCategories.forEach(cat => {
          otherLoadingState[cat.id] = true;
        });
        setLoadingCategories(prev => ({ ...prev, ...otherLoadingState }));

        const loadPromises = otherCategories.map(async (category) => {
          try {
            await loadCategory(category);
            setLoadingCategories(prev => ({ ...prev, [category.id]: false }));
          } catch (error) {
            console.error(`Error loading category ${category.id}:`, error);
            setLoadingCategories(prev => ({ ...prev, [category.id]: false }));
          }
        });

        await Promise.all(loadPromises);
      } catch (error) {
        console.error('Error loading content:', error);
        console.error('Error details:', error instanceof Error ? error.message : String(error));
        console.error('Error stack:', error instanceof Error ? error.stack : 'no stack');
        setInitialLoad(false);
      }
    }

    async function loadCategory(category: CategoryConfig) {
      const contentMap: Record<string, ContentItem[]> = {};

      // Load content for this category's types
      await Promise.all(
        category.contentTypes.map(async (type) => {
          contentMap[type] = await getAllContent(type);
        })
      );

      let items: ContentItem[] = [];
      category.contentTypes.forEach((type) => {
        if (contentMap[type]) {
          items = [...items, ...contentMap[type]];
        }
      });

      if (category.filter) {
        items = items.filter(category.filter);
      }

      if (category.id === 'projects') {
        const current = items.filter((p) => !p.status || p.status !== 'past');
        const past = items.filter((p) => p.status === 'past');
        items = [
          ...current.sort((a, b) => (a.title || '').localeCompare(b.title || '')),
          ...past.sort(
            (a, b) => new Date(b.date || '2000').getTime() - new Date(a.date || '2000').getTime()
          ),
        ];
      } else if (category.id === 'books') {
        items = items.sort((a, b) => Number(b.year || 0) - Number(a.year || 0));
      } else {
        items = items.sort(
          (a, b) => new Date(b.date || '2000').getTime() - new Date(a.date || '2000').getTime()
        );
      }

      setContentByCategory(prev => ({ ...prev, [category.id]: items }));
    }

    loadContentSequentially();
  }, []);

  const toggleSection = (categoryId: string) => {
    setOpenSections(prev => ({
      ...prev,
      [categoryId]: !prev[categoryId]
    }));
  };

  const handleTagFilter = (tag: string | null) => {
    if (tag === null) {
      setSearchParams({});
    } else {
      setSearchParams({ tags: tag });
    }
  };

  const matchesTag = (item: ContentItem, tag: string | null): boolean => {
    if (!tag) return true; // "All" selected
    if (tag === 'most-recent') return true; // "Most Recent" shows all items

    const itemTags = item.tags || [];
    const knownTags = TOPIC_TAGS.filter(t => t.value !== null && t.value !== 'Other' && t.value !== 'most-recent').map(t => t.value);

    if (tag === 'Other') {
      // "Other" means items with no tags OR tags not in our known categories
      return itemTags.length === 0 || !itemTags.some(t => knownTags.includes(t));
    }

    return itemTags.includes(tag);
  };

  if (initialLoad) {
    return (
      <div className="bg-black min-h-screen text-white">
        <div className="px-4 sm:px-6 lg:px-8 py-8">
          <div className="max-w-7xl mx-auto space-y-4">
            <div className="flex items-center justify-center py-16">
              <div className="text-center">
                <Loader2 className="w-12 h-12 text-citron animate-spin mx-auto mb-4" />
                <p className="text-beige-600 text-lg">Loading Kevin's work...</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    );
  }

  return (
    <>
      <Helmet>
        <title>Ideas | Kevin Werbach</title>
        <meta name="description" content="Research publications, articles, essays, and talks by Kevin Werbach on blockchain, gamification, AI governance, telecommunications, and technology policy." />
        <link rel="canonical" href="https://kevinwerbach.com/ideas" />
        <meta property="og:title" content="Ideas | Kevin Werbach" />
        <meta property="og:description" content="Research publications, articles, essays, and talks by Kevin Werbach." />
        <meta property="og:url" content="https://kevinwerbach.com/ideas" />
        <meta property="og:type" content="website" />
      </Helmet>
      <div className="bg-black min-h-screen text-white">
      <div className="px-4 sm:px-6 lg:px-8 py-8">
        {/* Topic filter buttons */}
        <div className="max-w-7xl mx-auto mb-6">
          <div className="flex flex-wrap gap-2 justify-center">
            {TOPIC_TAGS.map((topic) => {
              const isActive = selectedTag === topic.value;
              return (
                <button
                  key={topic.label}
                  onClick={() => handleTagFilter(topic.value)}
                  className="px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300 border-2"
                  style={{
                    backgroundColor: isActive ? topic.color : 'transparent',
                    borderColor: topic.color,
                    color: isActive ? '#000' : topic.color,
                    boxShadow: isActive ? `0 0 15px ${topic.color}40` : 'none',
                  }}
                >
                  {topic.label}
                </button>
              );
            })}
          </div>
        </div>

        <div id="main-content" className="max-w-7xl mx-auto space-y-4">
          {selectedTag === 'most-recent' ? (
            // Special handling for "Most Recent" - show top 10 items across all categories
            (() => {
              // Gather all items from dynamic categories (excluding books and static data categories)
              const allItems: ContentItem[] = [];
              categories.forEach(category => {
                if (category.id !== 'books' && !category.staticData) {
                  const categoryItems = contentByCategory[category.id] || [];
                  allItems.push(...categoryItems);
                }
              });

              // Sort by date and take top 10
              const recentItems = allItems
                .filter(item => item.date) // Only items with dates
                .sort((a, b) => new Date(b.date || '2000').getTime() - new Date(a.date || '2000').getTime())
                .slice(0, 10);

              if (recentItems.length === 0) return null;

              return (
                <motion.div
                  initial={{ opacity: 0, y: 20 }}
                  animate={{ opacity: 1, y: 0 }}
                  transition={{ duration: 0.3 }}
                  className="border border-teal-500/30 rounded-lg overflow-hidden bg-english_violet-600/10"
                >
                  <div className="w-full px-6 py-4">
                    <div className="flex items-center gap-3">
                      <h2 className="text-2xl font-bold text-white">Most Recent</h2>
                      <span className="text-sm text-beige-600">({recentItems.length})</span>
                    </div>
                  </div>

                  <div className="px-6 py-6 border-t border-teal-500/20">
                    <div className="grid md:grid-cols-2 gap-6">
                      {recentItems.map((item) => {
                        const externalLink = getPrimaryExternalLink(item);
                        const summary =
                          item.short ||
                          item.summary ||
                          (item.content ? `${item.content.substring(0, 140)}...` : '') ||
                          '';

                        return (
                          <Card
                            key={item.slug}
                            title={item.title}
                            summary={summary}
                            link={externalLink}
                            tags={item.tags || []}
                            authors={item.authors}
                            publication={item.publication}
                            compactMeta
                            image={item.coverImage || item.thumbnail}
                            imageContain={Boolean(item.coverImage || item.thumbnail)}
                            externalLinks={item.links}
                          />
                        );
                      })}
                    </div>
                  </div>
                </motion.div>
              );
            })()
          ) : (
            // Normal category view
            categories.map((category) => {
              // Check if this is a static data category
              const isStaticCategory = Boolean(category.staticData);
              const isStaticEventCategory = Boolean(category.staticEventData);
              
              // Filter static items by tag
              const staticItems = (category.staticData || []).filter(item => {
                if (!selectedTag) return true; // "All" selected
                if (selectedTag === 'most-recent') return true; // Show all for most recent
                const itemTags = item.tags || [];
                const knownTags = TOPIC_TAGS.filter(t => t.value !== null && t.value !== 'Other' && t.value !== 'most-recent').map(t => t.value);
                if (selectedTag === 'Other') {
                  return itemTags.length === 0 || !itemTags.some(t => knownTags.includes(t));
                }
                return itemTags.includes(selectedTag);
              });
              
              // Filter static event items by tag
              const staticEventItems = (category.staticEventData || []).filter(item => {
                if (!selectedTag) return true; // "All" selected
                if (selectedTag === 'most-recent') return true; // Show all for most recent
                const itemTags = item.tags || [];
                const knownTags = TOPIC_TAGS.filter(t => t.value !== null && t.value !== 'Other' && t.value !== 'most-recent').map(t => t.value);
                if (selectedTag === 'Other') {
                  return itemTags.length === 0 || !itemTags.some(t => knownTags.includes(t));
                }
                return itemTags.includes(selectedTag);
              });
              
              let dynamicItems = (contentByCategory[category.id] || []).filter(item => matchesTag(item, selectedTag));

              const isOpen = openSections[category.id];
              const count = isStaticCategory ? staticItems.length : (isStaticEventCategory ? staticEventItems.length : dynamicItems.length);
              const isLoading = loadingCategories[category.id];


            // Show loading skeleton for categories being loaded
            if (isLoading && !isStaticCategory && !isStaticEventCategory) {
              return (
                <div key={category.id} className="border border-teal-500/30 rounded-lg overflow-hidden bg-english_violet-600/10">
                  <div className="w-full px-6 py-4 flex items-center justify-between">
                    <div className="flex items-center gap-3">
                      <Loader2 className="text-citron animate-spin" size={24} />
                      <h2 className="text-2xl font-bold text-white">{category.label}</h2>
                      <span className="text-sm text-beige-600">Loading…</span>
                    </div>
                  </div>
                </div>
              );
            }

            if (count === 0) return null;

            return (
              <motion.div
                key={category.id}
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.3 }}
                className="border border-teal-500/30 rounded-lg overflow-hidden bg-english_violet-600/10"
              >
                <button
                  onClick={() => toggleSection(category.id)}
                  className="w-full px-6 py-4 flex items-center justify-between hover:bg-teal-500/10 transition-colors"
                >
                  <div className="flex items-center gap-3">
                    {isOpen ? (
                      <ChevronDown className="text-citron" size={24} />
                    ) : (
                      <ChevronRight className="text-citron" size={24} />
                    )}
                    <h2 className="text-2xl font-bold text-white">{category.label}</h2>
                    <span className="text-sm text-beige-600">({count})</span>
                  </div>
                </button>

                <AnimatePresence initial={false}>
                  {isOpen && (
                    <motion.div
                      initial={{ height: 0, opacity: 0 }}
                      animate={{ height: 'auto', opacity: 1 }}
                      exit={{ height: 0, opacity: 0 }}
                      transition={{ duration: 0.3, ease: 'easeInOut' }}
                      className="overflow-hidden"
                    >
                      <div className="px-6 py-6 border-t border-teal-500/20">
                        {category.id === 'books' ? (
                          <div className="flex gap-4 overflow-x-auto pb-4">
                            {dynamicItems.map((book) => (
                              <BookCard
                                key={book.slug}
                                title={book.title}
                                year={book.year}
                                summary={book.summary || ''}
                                link={`/ideas/books/${book.slug}`}
                                coverImage={book.coverImage}
                                compact
                              />
                            ))}
                          </div>
                        ) : isStaticCategory ? (
                          // Render static publication data
                          <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                            {staticItems.map((item, index) => (
                              <PublicationCard
                                key={`${item.title}-${index}`}
                                title={item.title}
                                publication={item.publication}
                                year={item.year}
                                link={item.link}
                              />
                            ))}
                          </div>
                        ) : isStaticEventCategory ? (
                          // Render static event data
                          <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                            {staticEventItems.map((item, index) => (
                              <EventCard
                                key={`${item.title}-${index}`}
                                title={item.title}
                                location={item.location}
                                year={item.year}
                                link={item.link}
                              />
                            ))}
                          </div>
                        ) : (
                          <div className="grid md:grid-cols-2 gap-6">
                            {dynamicItems.map((item) => {
                              const isProject = category.id === 'projects';
                              const slug = item.slug || '';
                              const externalLink = getPrimaryExternalLink(item);
                              let linkTarget: string | undefined;

                              if (isProject && slug) {
                                linkTarget = PROJECT_EXTERNAL_LINKS[slug];
                              }

                              if (!linkTarget) {
                                linkTarget = externalLink;
                              }

                              const summary =
                                item.short ||
                                item.summary ||
                                (item.content ? `${item.content.substring(0, 140)}...` : '') ||
                                '';

                              return (
                                <Card
                                  key={item.slug}
                                  title={item.title}
                                  summary={summary}
                                  link={linkTarget}
                                  tags={item.tags || []}
                                  date={isProject ? undefined : item.date}
                                  authors={item.authors}
                                  publication={item.publication}
                                  compactMeta
                                  image={item.coverImage || item.thumbnail}
                                  imageContain={isProject && Boolean(item.coverImage || item.thumbnail)}
                                  externalLinks={item.links}
                                />
                              );
                            })}
                          </div>
                        )}
                      </div>
                    </motion.div>
                  )}
                </AnimatePresence>
              </motion.div>
            );
          })
          )}
        </div>
      </div>
    </div>
    </>
  );
}
