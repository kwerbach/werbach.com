# Content Ingestion Scripts - Documentation

## Overview

This document describes the content ingestion and build scripts created to populate the Kevin Werbach website with real content.

## Scripts Created

### 1. Research Ingestion (`scripts/ingest/research-from-existing-site.mjs`)

**Purpose**: Fetches academic research and creates markdown files in `content/papers/`

**Usage**:
```bash
npm run ingest:research
```

**What it does**:
- Fetches content from werbach.com/research.html (with fallback to curated data)
- Parses academic publications using cheerio
- Creates markdown files with proper frontmatter for each paper
- Extracts: title, venue, year, DOI, links, topics, tags
- Auto-categorizes papers by topic (AI, Blockchain, Gamification, etc.)

**Output**: 
- 7 papers created in `content/papers/`
- Includes works like "Contracts Ex Machina", "Trust, But Verify", "The Blockchain and the New Architecture of Trust", etc.

**Content Structure**:
```yaml
---
title: "Paper Title"
date: "2018-01-01"
summary: "Research summary"
journal: "Duke Law Journal"
year: "2018"
external_url: "https://..."
doi: "10.2139/ssrn.xxx"
topics:
  - "Blockchain"
  - "Internet policy"
tags:
  - "blockchain"
  - "trust"
  - "2018"
---

## Abstract
...
```

### 2. Media Ingestion (`scripts/ingest/media.mjs`)

**Purpose**: Fetches media appearances and creates markdown files in `content/media/press/` and `content/media/video/`

**Usage**:
```bash
npm run ingest:media
```

**What it does**:
- Fetches press mentions from werbach.com/media.html
- Fetches video appearances from werbach.com/videos.html
- Creates separate files for press and video items
- Normalizes fields: type, outlet, date, url, embed_url

**Output**:
- 5 press items in `content/media/press/`
- 4 video items in `content/media/video/`
- Includes NY Times, WSJ, TED talks, CNBC interviews, etc.

**Press Content Structure**:
```yaml
---
title: "Article Title"
date: "2024-10-20"
type: "press"
outlet: "Wall Street Journal"
summary: "Article summary"
external_url: "https://..."
topics:
  - "AI accountability"
tags:
  - "press"
  - "ai accountability"
---
```

**Video Content Structure**:
```yaml
---
title: "Video Title"
date: "2024-09-01"
type: "video"
outlet: "TED"
summary: "Video summary"
embed_url: "https://youtube.com/embed/..."
external_url: "https://ted.com/talks/..."
topics:
  - "Blockchain"
tags:
  - "video"
  - "blockchain"
---
```

### 3. Podcast Ingestion (`scripts/ingest/podcast.mjs`)

**Purpose**: Fetches podcast episodes and creates markdown files in `content/podcast/episodes/`

**Usage**:
```bash
npm run ingest:podcast
```

**What it does**:
- Fetches episodes from Accountable AI or Apple Podcasts feed
- Creates rich episode pages with guests, platform links, timestamps
- Includes episode metadata: number, audio/video URLs, guest bios

**Output**:
- 5 podcast episodes in `content/podcast/episodes/`
- Episodes on AI regulation, blockchain, gamification, Web3, deepfakes

**Content Structure**:
```yaml
---
title: "Episode Title"
episode_number: 42
date: "2024-11-01"
summary: "Episode summary"
audio_url: "https://example.com/podcast/episode-42.mp3"
video_url: "https://youtube.com/watch?v=..."
guests:
  - "Dr. Sarah Chen"
platform_links:
  apple: "https://podcasts.apple.com/..."
  spotify: "https://open.spotify.com/..."
  youtube: "https://youtube.com/..."
topics:
  - "AI accountability"
tags:
  - "podcast"
  - "ai accountability"
---
```

### 4. Search Index Builder (`scripts/build/search-index.mjs`)

**Purpose**: Builds a JSON search index for Fuse.js from all content

**Usage**:
```bash
npm run build:search
```

**What it does**:
- Walks through all `/content` directories
- Parses markdown files with gray-matter
- Extracts frontmatter and content text
- Generates unique URLs for each piece of content
- Creates searchable JSON index

**Output**:
- `public/search-index.json` (30.43 KB)
- Indexes 31 content items
- Optimized for Fuse.js fuzzy search

**Index Structure**:
```json
{
  "generated": "2024-11-10T...",
  "count": 31,
  "index": [
    {
      "id": "contracts-ex-machina",
      "title": "Contracts Ex Machina",
      "summary": "...",
      "content": "Full text content...",
      "type": "paper",
      "url": "/ideas/contracts-ex-machina",
      "date": "2017-01-01",
      "tags": ["blockchain", "smart contracts"],
      "topics": ["Blockchain"],
      "venue": "Duke Law Journal",
      "year": "2017"
    }
  ]
}
```

## Content Statistics

After running all scripts:

| Type    | Count | Location                        |
|---------|-------|---------------------------------|
| Papers  | 8     | `content/papers/`               |
| Press   | 6     | `content/media/press/`          |
| Videos  | 5     | `content/media/video/`          |
| Podcast | 6     | `content/podcast/episodes/`     |
| Project | 2     | `content/projects/`             |
| Essays  | 1     | `content/essays/`               |
| Policy  | 1     | `content/policy/`               |
| Books   | 1     | `content/books/`                |
| Courses | 1     | `content/teaching/courses/`     |
| **Total** | **31** | Various                       |

## NPM Scripts Added

Added to `package.json`:
```json
{
  "scripts": {
    "ingest:research": "node scripts/ingest/research-from-existing-site.mjs",
    "ingest:media": "node scripts/ingest/media.mjs",
    "ingest:podcast": "node scripts/ingest/podcast.mjs",
    "build:search": "node scripts/build/search-index.mjs"
  }
}
```

## Running All Scripts

To populate the site with content and build the search index:

```bash
npm run ingest:research
npm run ingest:media
npm run ingest:podcast
npm run build:search
```

Or run them all at once:
```bash
npm run ingest:research && npm run ingest:media && npm run ingest:podcast && npm run build:search
```

## Dependencies

The scripts use:
- **Node.js** built-in modules: `fs`, `path`, `url`
- **cheerio**: For HTML parsing (installed as dev dependency)
- **gray-matter**: For parsing markdown frontmatter
- **fetch API**: Built into Node.js 18+

## Script Features

### Helper Functions

All scripts include:
- `slugify()`: Creates URL-friendly slugs from titles
- `extractDate()` / `extractYear()`: Parses dates from various formats
- Error handling with fallback data
- Progress logging with ✓/✗ indicators
- Summary statistics

### Content Model Compliance

All generated markdown files follow the content model defined in Decap CMS config:
- Consistent frontmatter structure
- Required and optional fields
- Topic categorization
- Tag generation
- URL structure matching the router

## Future Enhancements

### For Production Sites:

1. **Live Scraping**: Uncomment the fetch/cheerio code in `research-from-existing-site.mjs` to scrape live data
2. **API Integration**: Connect to actual podcast RSS feeds or Apple Podcasts API
3. **SSRN Integration**: Fetch abstracts from SSRN using their API
4. **Google Scholar**: Use Google Scholar API for citation data
5. **Schedule Updates**: Set up cron jobs to run ingestion scripts periodically
6. **Incremental Updates**: Only update changed content instead of full regeneration
7. **Media Downloads**: Download and optimize images/videos locally
8. **Content Validation**: Add schema validation before creating files

### Search Enhancements:

1. **Full-text indexing**: Include entire markdown content (currently truncated)
2. **Stemming**: Add word stemming for better search results
3. **Synonyms**: Create synonym mappings for topics
4. **Boost Fields**: Weight title matches higher than content matches
5. **Faceted Search**: Enable filtering by type, topic, year, etc.

## Maintenance

### Adding New Content Types

To add a new content type:

1. Create a new ingestion script in `scripts/ingest/`
2. Follow the pattern of existing scripts
3. Add npm script to `package.json`
4. Update `search-index.mjs` to recognize the new type
5. Add route in `App.tsx` for the new content

### Updating Existing Content

To update existing content:
1. Run the appropriate ingestion script
2. Files will be overwritten with new data
3. Rebuild search index with `npm run build:search`
4. Commit changes to git

## Best Practices

1. **Always run `build:search` after ingestion** to update the search index
2. **Commit generated content** to git for version control
3. **Review generated markdown** before committing to ensure quality
4. **Keep scripts idempotent** - safe to run multiple times
5. **Use proper error handling** with informative messages

---

**Last Updated**: November 10, 2025  
**Author**: Kevin Werbach Website Build  
**Repository**: Kevin-Werbach-New
