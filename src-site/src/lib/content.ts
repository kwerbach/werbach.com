import matter from 'gray-matter';

export interface ContentItem {
  slug: string;
  title: string;
  date: string;
  type: string;
  summary?: string;
  short?: string;
  authors?: string[];
  publication?: string;
  venue?: string;
  outlet?: string;
  topics?: string[];
  tags?: string[];
  links?: {
    pdf?: string;
    ssrn?: string;
    doi?: string;
    external?: string;
    conference?: string;
    execed?: string;
    podcast?: string;
    podcast_feed?: string;
    newsletter?: string;
  };
  citation?: string;
  content: string;
  coverImage?: string;
  thumbnail?: string;
  publisher?: string;
  year?: string;
  buy_links?: Array<{
    store: string;
    url: string;
  }>;
  status?: string;
  endDate?: string;
}

// Import all markdown files from content directories
const contentModules = import.meta.glob('/content/**/*.md', { 
  query: '?raw',
  import: 'default',
  eager: false
});

console.log('=== CONTENT MODULES DEBUG ===');
console.log('Total modules found:', Object.keys(contentModules).length);
console.log('First 10 paths:', Object.keys(contentModules).slice(0, 10));
console.log('============================');

// Simple in-memory cache to avoid reloading markdown repeatedly during a session.
const allContentCache: Record<string, ContentItem[] | undefined> = {};
const loadingPromises: Record<string, Promise<ContentItem[]> | undefined> = {};

export async function getAllContent(type?: string): Promise<ContentItem[]> {
  const key = type || '*';
  // Serve from completed cache
  if (allContentCache[key]) {
    return allContentCache[key] as ContentItem[];
  }
  // Return in-flight promise if load already started
  if (loadingPromises[key]) {
    return loadingPromises[key] as Promise<ContentItem[]>;
  }

  const loadPromise: Promise<ContentItem[]> = (async () => {
    const items: ContentItem[] = [];
    console.log(`getAllContent called with type: "${type}"`);
    console.log('Total contentModules:', Object.keys(contentModules).length);

    for (const path in contentModules) {
      const contentPath = path.includes('/content/') ? path.split('/content/')[1] : path;
      const pathParts = contentPath.split('/');
      const contentType = pathParts[0] || 'unknown';
      if (type && contentType !== type) continue;

      try {
        const rawFile = await contentModules[path]() as string;
        const { data, content: markdown } = matter(rawFile);

      const rawAuthors = (data.authors ?? data.coauthors ?? data.co_authors) as string | string[] | undefined;
      let authors: string[] | undefined;
      if (Array.isArray(rawAuthors)) {
        authors = rawAuthors.map(a => String(a).trim()).filter(Boolean);
      } else if (typeof rawAuthors === 'string') {
        const parts = rawAuthors.split(/,| and |\u2013|\u2014|\&/g).map(s => s.trim()).filter(Boolean);
        authors = parts.length ? parts : undefined;
      }

      const publication: string | undefined = (data.publication || data.journal || data.outlet || data.publisher) as string | undefined;
      const slug = path.split('/').pop()?.replace('.md', '') || '';

        items.push({
          slug,
          title: data.title || '',
          date: data.date || '',
          type: contentType,
          summary: data.summary || data.description || '',
          short: data.short || '',
          authors,
          publication,
          venue: data.venue,
          topics: data.topics,
          tags: data.tags,
          links: data.links || (data.external_url ? { external: data.external_url } : (data.external ? { external: data.external } : undefined)),
          citation: data.citation,
          content: markdown,
          coverImage: data.coverImage,
          thumbnail: data.thumbnail,
          publisher: data.publisher,
          year: (data.year !== undefined && data.year !== null) ? String(data.year) : undefined,
          buy_links: data.buy_links,
          status: data.status,
          endDate: data.endDate
        });
      } catch (error) {
        console.error(`Error parsing file ${path}:`, error);
      }
    }
    console.log(`getAllContent returning ${items.length} items for type "${type}"`);
    if (items.length) console.log('Sample item:', items[0].title, items[0].type);
    allContentCache[key] = items;
    return items;
  })();

  loadingPromises[key] = loadPromise;
  try {
    const result = await loadPromise;
    return result;
  } finally {
    loadingPromises[key] = undefined; // clear in-flight marker regardless of success
  }
}

export async function getContentBySlug(type: string, slug: string): Promise<ContentItem | null> {
  // Find the matching path in contentModules
  const matchingPath = Object.keys(contentModules).find(path => {
    const contentPath = path.includes('/content/') ? path.split('/content/')[1] : path;
    return contentPath === `${type}/${slug}.md`;
  });
  
  if (!matchingPath) {
    return null;
  }

  const content = await contentModules[matchingPath]() as string;
  const { data, content: markdown } = matter(content);

  // Normalize authors
  const rawAuthors = (data.authors ?? data.coauthors ?? data.co_authors) as string | string[] | undefined;
  let authors: string[] | undefined = undefined;
  if (Array.isArray(rawAuthors)) {
    authors = rawAuthors.map(a => String(a).trim()).filter(Boolean);
  } else if (typeof rawAuthors === 'string') {
    const parts = rawAuthors
      .split(/,| and |\u2013|\u2014|\&/g)
      .map(s => s.trim())
      .filter(Boolean);
    authors = parts.length > 0 ? parts : undefined;
  }

  // Normalize publication name
  const publication: string | undefined = (data.publication || data.journal || data.outlet || data.publisher) as string | undefined;

  return {
    slug,
    title: data.title || '',
    date: data.date || '',
    type,
    summary: data.summary || data.description || '',
    short: data.short || '',
    authors,
    publication,
    venue: data.venue,
    topics: data.topics,
    tags: data.tags,
    links: data.links || (data.external_url ? { external: data.external_url } : (data.external ? { external: data.external } : undefined)),
    citation: data.citation,
    content: markdown,
    coverImage: data.coverImage,
    thumbnail: data.thumbnail,
    publisher: data.publisher,
    year: (data.year !== undefined && data.year !== null) ? String(data.year) : undefined,
    buy_links: data.buy_links,
    status: data.status,
    endDate: data.endDate
  };
}

export async function getLatestContent(count: number = 3): Promise<ContentItem[]> {
  const allItems = await getAllContent();
  
  return allItems
    .filter(item => item.date) // Only items with dates
    .sort((a, b) => new Date(b.date).getTime() - new Date(a.date).getTime())
    .slice(0, count);
}

export async function getLatestByType(type: string, count: number = 1): Promise<ContentItem[]> {
  const items = await getAllContent(type);
  
  return items
    .filter(item => item.date)
    .sort((a, b) => new Date(b.date).getTime() - new Date(a.date).getTime())
    .slice(0, count);
}
