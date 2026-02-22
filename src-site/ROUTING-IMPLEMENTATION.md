# Routing & Dynamic Content Implementation

This document describes the complete routing and dynamic content loading implementation for the kevinwerbach.com website.

## Overview

All pages now load real content from markdown files in the `/content` directory using React Router for navigation and gray-matter for parsing frontmatter.

## Core Utilities

### `/src/lib/content.ts`
- `getAllContent(type?)` - Load all markdown files from content directories
- `getContentBySlug(type, slug)` - Load a specific content item by slug
- `getLatestContent(count)` - Get the most recent content items across all types
- `getLatestByType(type, count)` - Get the most recent items of a specific type
- Uses `import.meta.glob()` to dynamically import markdown files
- Extracts frontmatter with gray-matter
- Returns standardized `ContentItem` interface

### `/src/lib/markdown.ts`
- `markdownToHtml(markdown)` - Convert markdown content to HTML
- Uses unified + remark-parse + remark-html pipeline
- Returns safe HTML string for rendering

## Routing Structure

### Home Page (`/`)
**Features:**
- Fetches latest 1 paper, 1 media item, 1 podcast episode
- Sorted by date (most recent first)
- CTAs: "Invite to Speak" and "Subscribe to Podcast" buttons
- Loading states for async content

### Ideas Page (`/ideas`)
**Features:**
- Loads all papers, essays, and policy documents
- Filterable by tags/topics using FilterBar component
- Searchable by title and summary using SearchBox component
- Grid layout with Card components
- Empty state handling

### Idea Detail Page (`/ideas/:slug`)
**Features:**
- Dynamic slug-based content loading
- Tries papers → essays → policy folders
- Full markdown rendering with Prose component
- Displays authors, publication, date
- Shows citation in styled box
- Links to PDF, SSRN, DOI, external resources
- Back navigation to Ideas page

### Projects Page (`/projects`)
**Features:**
- Loads all projects from `/content/projects/`
- Grid layout with summaries
- Links to individual project pages

### Project Detail Page (`/projects/:slug`)
**Features:**
- Full markdown content rendering
- Summary and description
- External links and PDFs
- Back navigation to Projects page

### Books Page (`/books`)
**Features:**
- Loads all books from `/content/books/`
- Full content display (not just cards)
- External buy links and PDF links
- Vertically stacked articles with borders

### Teaching Page (`/teaching`)
**Features:**
- Loads courses from `/content/teaching/`
- Full course descriptions with markdown
- External syllabus links
- Vertically stacked course articles

### Speaking Page (`/speaking`)
**Features:**
- Static speaking topics list
- Netlify form integration for speaking requests
- Form fields: name, email, organization, event date, topic, message
- Honeypot field for spam protection
- Form name: `speaking-request`

### Podcast Page (`/podcast`)
**Features:**
- Loads all episodes from `/content/podcast/`
- Sorted by date (newest first)
- Card layout with links to detail pages

### Podcast Detail Page (`/podcast/:slug`)
**Features:**
- Episode markdown rendering
- Platform links ("Listen on" section)
- Tags display
- Date formatting
- Back navigation to Podcast page

### Media Page (`/media`)
**Features:**
- Loads all media from `/content/media/`
- Filterable by tags (press, video, etc.)
- External links to media sources
- Vertically stacked card layout

## Content Loading Pattern

All pages follow this pattern:

```typescript
const [content, setContent] = useState<ContentItem[]>([]);
const [loading, setLoading] = useState(true);

useEffect(() => {
  async function loadContent() {
    try {
      const items = await getAllContent('type');
      setContent(items);
    } catch (error) {
      console.error('Error loading content:', error);
    } finally {
      setLoading(false);
    }
  }
  loadContent();
}, []);
```

## Netlify Configuration

### `netlify.toml`
```toml
[build]
  command = "npm run build"
  publish = "dist"

[[redirects]]
  from = "/*"
  to = "/index.html"
  status = 200
```

This ensures SPA routing works correctly by redirecting all routes to index.html.

### Netlify Forms
The Speaking page includes a Netlify form with:
- `data-netlify="true"` attribute
- `netlify-honeypot="bot-field"` for spam protection
- Hidden `form-name` input field
- All form fields are controlled components

## Build & Deployment

### Build Command
```bash
npm run build
```

### Output
- Builds to `/dist` directory
- All markdown files are bundled as chunks
- Static assets optimized
- Build succeeds with no errors

### Deployment Steps
1. Connect GitHub repository to Netlify
2. Set build command: `npm run build`
3. Set publish directory: `dist`
4. Enable Netlify Forms in dashboard
5. Configure Decap CMS OAuth (GitHub backend)
6. Deploy automatically on push to main branch

## Content Structure

All content lives in `/content` with the following structure:

```
content/
├── papers/         # Academic papers
├── essays/         # Opinion pieces
├── policy/         # Policy documents
├── projects/       # Research projects (BDAP, Accountable AI)
├── books/          # Published books
├── teaching/       # Course information
├── podcast/        # Podcast episodes
└── media/          # Press, videos, interviews
```

Each markdown file includes frontmatter with:
- `title` (required)
- `date` (required for sorting)
- `summary` or `description`
- `authors` (array)
- `publication`
- `topics` (array)
- `tags` (array)
- `links` (object with pdf, ssrn, doi, external)
- `citation`

## Testing

Build successfully tested with:
- TypeScript compilation ✓
- Vite production build ✓
- All routes defined ✓
- Content loading utilities ✓
- Markdown rendering ✓

## Next Steps

1. **Deploy to Netlify** - Connect repository and configure environment
2. **Enable Decap CMS OAuth** - Set up GitHub OAuth app for admin access
3. **Add SEO meta tags** - Implement react-helmet-async for dynamic meta tags
4. **Integrate search** - Use Fuse.js with the generated search-index.json
5. **Add analytics** - Integrate Netlify Analytics or Google Analytics
6. **Content population** - Add more content using Decap CMS or ingestion scripts

## Related Files

- `/IMPLEMENTATION-SUMMARY.md` - Initial project setup
- `/INGESTION-SCRIPTS.md` - Content ingestion documentation
- `/public/admin/config.yml` - Decap CMS configuration
- `/scripts/build/search-index.mjs` - Search index builder
