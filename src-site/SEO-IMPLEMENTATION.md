# SEO & Structure Implementation

This document describes the complete SEO infrastructure for the kevinwerbach.com website, including meta tags, structured data, sitemaps, and RSS feeds.

## Overview

The site implements comprehensive SEO best practices:
- Dynamic meta tags with react-helmet-async
- JSON-LD structured data for content types
- XML sitemap with all pages
- RSS feeds for Ideas and Podcast
- robots.txt for crawler guidance
- Canonical URLs on all pages

## Meta Tags & Structured Data

### `/src/lib/seo.ts`
Utility functions for generating SEO metadata and JSON-LD structured data:

**Functions:**
- `generatePersonSchema()` - Kevin Werbach's Person schema
- `generateScholarlyArticleSchema(item)` - For academic papers
- `generateBookSchema(item)` - For published books
- `generatePodcastEpisodeSchema(item)` - For podcast episodes
- `getSiteUrl()` - Returns canonical site URL

**Schema Types:**
- **Person** - Author/professor information with job title, organization, social links
- **ScholarlyArticle** - Papers with authors, publication, keywords, dates
- **Book** - Published works with author, publisher, ISBN
- **PodcastEpisode** - Episodes with series information

### Dynamic Meta Tags (react-helmet-async)

All pages include:
- Page-specific `<title>` tags
- Meta descriptions
- Canonical URLs
- Open Graph tags (og:title, og:description, og:url, og:type)
- Twitter Card tags (twitter:card, twitter:creator)
- JSON-LD structured data in `<script type="application/ld+json">`

**Implemented on:**
- **Home** (`/`) - Person schema for Kevin Werbach
- **IdeaDetail** (`/ideas/:slug`) - ScholarlyArticle schema with authors, publication
- **PodcastDetail** (`/podcast/:slug`) - PodcastEpisode schema with series info

### App-Level Setup

`/src/App.tsx` wraps the entire application in `<HelmetProvider>` to enable react-helmet-async functionality across all pages.

## Sitemap Generation

### `/scripts/build/sitemap.mjs`
Automatically generates XML sitemap from static pages and content.

**Features:**
- Scans all markdown files in `/content` directories
- Includes static pages with priorities
- Sets appropriate change frequencies
- Outputs to `/public/sitemap.xml`

**Static Pages (10 URLs):**
```
/ (priority: 1.0, weekly)
/ideas (priority: 0.9, weekly)
/projects (priority: 0.8, monthly)
/books (priority: 0.8, monthly)
/teaching (priority: 0.7, monthly)
/speaking (priority: 0.7, monthly)
/podcast (priority: 0.9, weekly)
/media (priority: 0.8, weekly)
/about (priority: 0.6, monthly)
/contact (priority: 0.5, yearly)
```

**Dynamic Content Pages:**
- `/ideas/:slug` - Papers, essays, policy documents
- `/projects/:slug` - Research projects
- `/podcast/:slug` - Podcast episodes

**Current Stats:**
- 28 total URLs (10 static + 18 content)
- Valid XML format
- Includes lastmod dates from content frontmatter

**Usage:**
```bash
npm run build:sitemap
```

## robots.txt

### `/public/robots.txt`
Standard robots.txt file for search engine crawlers.

```
User-agent: *
Allow: /

Sitemap: https://kevinwerbach.com/sitemap.xml
```

- Allows all crawlers
- Points to sitemap location
- No disallow rules (all content is public)

## RSS Feeds

### `/scripts/build/rss.mjs`
Generates two RSS feeds in valid RSS 2.0 format.

### Ideas Feed (`/public/rss-ideas.xml`)

**Content:**
- Papers from `/content/papers/`
- Essays from `/content/essays/`
- Policy documents from `/content/policy/`
- Most recent 20 items
- Sorted by date (newest first)

**Feed Metadata:**
```xml
<title>Kevin Werbach - Ideas</title>
<description>Research papers, essays, and policy work by Kevin Werbach</description>
<link>https://kevinwerbach.com/ideas</link>
```

**Item Fields:**
- title
- link (canonical URL)
- guid (permalink)
- pubDate (RFC 822 format)
- description (summary)
- author(s)

**Current Stats:** 10 items

### Podcast Feed (`/public/rss-podcast.xml`)

**Content:**
- All episodes from `/content/podcast/`
- Sorted by date (newest first)
- iTunes-compatible tags

**Feed Metadata:**
```xml
<title>Kevin Werbach Podcast</title>
<description>Conversations on technology, policy, and innovation</description>
<itunes:category text="Technology" />
<itunes:category text="Business" />
```

**iTunes Tags:**
- `itunes:author`
- `itunes:summary`
- `itunes:owner`
- `itunes:explicit` (set to "no")
- `itunes:category`

**Current Stats:** 6 episodes

**Usage:**
```bash
npm run build:rss
```

## Build Scripts

All SEO-related build tasks are available via npm scripts:

```json
{
  "build:search": "node scripts/build/search-index.mjs",
  "build:sitemap": "node scripts/build/sitemap.mjs",
  "build:rss": "node scripts/build/rss.mjs",
  "build:seo": "npm run build:search && npm run build:sitemap && npm run build:rss"
}
```

### Recommended Build Process

```bash
# Generate all content
npm run ingest:research
npm run ingest:media
npm run ingest:podcast

# Generate all SEO files
npm run build:seo

# Build production app
npm run build
```

### Output Files

All generated SEO files are placed in `/public` for static serving:
- `sitemap.xml` - XML sitemap (28 URLs)
- `robots.txt` - Crawler instructions
- `rss-ideas.xml` - Ideas RSS feed (10 items)
- `rss-podcast.xml` - Podcast RSS feed (6 episodes)
- `search-index.json` - Fuse.js search index (31 items)

## Page-Specific SEO

### Home Page (`/`)

**Title:** Kevin Werbach - Professor, Author, Tech Policy Expert

**Description:** Kevin Werbach is a Professor at Wharton School, expert on blockchain, AI, gamification, and technology policy. Explore research, books, and insights.

**Structured Data:** Person schema with job title, organization (Wharton), social media links

### Ideas Detail Page (`/ideas/:slug`)

**Title:** `{article.title} - Kevin Werbach`

**Description:** From article summary or generated

**Structured Data:** ScholarlyArticle schema with:
- headline
- authors (array)
- datePublished
- description
- publisher (if available)
- keywords (topics + tags)
- url (canonical)

**Open Graph:** article:published_time, article:author tags

### Podcast Detail Page (`/podcast/:slug`)

**Title:** `{episode.title} - Kevin Werbach Podcast`

**Description:** From episode summary or generated

**Structured Data:** PodcastEpisode schema with:
- name
- description
- datePublished
- url (canonical)
- partOfSeries (Kevin Werbach Podcast)

## Canonical URLs

All content pages include canonical URLs to prevent duplicate content issues:

```html
<link rel="canonical" href="https://kevinwerbach.com/ideas/blockchain-trust" />
```

**Format:**
- Home: `https://kevinwerbach.com`
- Ideas: `https://kevinwerbach.com/ideas/{slug}`
- Projects: `https://kevinwerbach.com/projects/{slug}`
- Podcast: `https://kevinwerbach.com/podcast/{slug}`

## Open Graph & Twitter Cards

All pages with content include social media preview tags:

**Open Graph:**
```html
<meta property="og:title" content="..." />
<meta property="og:description" content="..." />
<meta property="og:url" content="..." />
<meta property="og:type" content="article" />
```

**Twitter:**
```html
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:creator" content="@kwerb" />
```

## RSS Feed Links

RSS feeds should be linked in page headers (to be implemented):

```html
<!-- In Ideas page -->
<link rel="alternate" type="application/rss+xml" title="Kevin Werbach - Ideas" href="/rss-ideas.xml" />

<!-- In Podcast page -->
<link rel="alternate" type="application/rss+xml" title="Kevin Werbach Podcast" href="/rss-podcast.xml" />
```

## Testing & Validation

### Sitemap Validation
- Valid XML format ✓
- All URLs return 200 status codes (after deployment)
- Proper date formats (YYYY-MM-DD)
- Valid priority values (0.0-1.0)
- Valid changefreq values

### RSS Validation
- Valid RSS 2.0 format ✓
- All required fields present ✓
- Proper date formats (RFC 822) ✓
- iTunes tags for podcast feed ✓
- XML escaping for special characters ✓

### Structured Data Validation
Test with:
- Google Rich Results Test: https://search.google.com/test/rich-results
- Schema.org Validator: https://validator.schema.org/

### Meta Tags Testing
Test with:
- Facebook Debugger: https://developers.facebook.com/tools/debug/
- Twitter Card Validator: https://cards-dev.twitter.com/validator

## Performance Considerations

**react-helmet-async** benefits:
- Asynchronous rendering
- Server-side rendering support (if needed)
- No blocking of React rendering
- Minimal performance overhead

**Build Script Performance:**
- Sitemap generation: ~100ms for 30 URLs
- RSS generation: ~50ms per feed
- Search index: ~200ms for 31 items
- Total: <500ms for all SEO files

## Future Enhancements

1. **Add remaining pages:**
   - Books page with Book schema
   - Projects detail with Project schema
   - About page with Person schema

2. **Enhanced Open Graph:**
   - Add og:image for all content
   - Generate social media preview images

3. **Additional RSS feeds:**
   - Media RSS feed for press/videos
   - Combined "all updates" feed

4. **Structured data expansion:**
   - BreadcrumbList for navigation
   - Organization schema for Wharton
   - WebSite schema with search action

5. **Sitemap improvements:**
   - Image sitemap for media content
   - Video sitemap for video content
   - News sitemap (if applicable)

6. **Analytics integration:**
   - Google Analytics 4
   - Search Console verification
   - Track SEO performance metrics

## Related Files

- `/src/lib/seo.ts` - SEO utilities and schema generators
- `/scripts/build/sitemap.mjs` - Sitemap generator
- `/scripts/build/rss.mjs` - RSS feed generators
- `/public/robots.txt` - Crawler instructions
- `/ROUTING-IMPLEMENTATION.md` - Routing documentation
- `/IMPLEMENTATION-SUMMARY.md` - Project overview

## Deployment Checklist

- [x] Generate sitemap with `npm run build:sitemap`
- [x] Generate RSS feeds with `npm run build:rss`
- [x] Verify robots.txt exists
- [x] Test build succeeds with `npm run build`
- [ ] Submit sitemap to Google Search Console
- [ ] Submit sitemap to Bing Webmaster Tools
- [ ] Test structured data with Google Rich Results Test
- [ ] Verify Open Graph tags with Facebook Debugger
- [ ] Add RSS feed links to relevant pages
- [ ] Monitor SEO performance in analytics
