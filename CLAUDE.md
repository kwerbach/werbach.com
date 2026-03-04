# CLAUDE.md — werbach.com

## Project Overview

**Repository:** `kwerbach/werbach.com`
**Live site:** https://werbach.com
**Stack:** Vite + React + TypeScript + Tailwind CSS
**Deploy:** Push to `main` → GitHub Actions builds `src-site/` → rsync to Pair Networks

## Repository Structure

```
werbach.com/
├── .github/workflows/deploy.yml    # Build + deploy pipeline
├── src-site/                       # The modern React site (ALL edits happen here)
│   ├── content/                    # Markdown content files (the part you'll edit most)
│   │   ├── books/
│   │   ├── essays/                 # Book chapters and essays
│   │   ├── media/                  # Podcast episodes, media appearances
│   │   ├── papers/                 # Scholarly/journal articles
│   │   ├── policy/                 # White papers and policy reports
│   │   ├── press/                  # General and trade press articles
│   │   ├── projects/               # Research projects (WAAL, BDAP, etc.)
│   │   ├── teaching/courses/       # Course listings
│   │   └── testimony/              # Congressional/government testimony
│   ├── src/                        # React components, routing, styles
│   ├── public/                     # Static assets
│   ├── scripts/                    # Build/ingestion scripts
│   ├── package.json
│   ├── vite.config.ts
│   └── tailwind.config.ts
├── assets/                         # Built JS/CSS bundles (generated, don't edit)
├── index.html                      # Built entry point (generated, don't edit)
├── about-old/, auditorium/, barebones/, etc.  # Legacy static HTML (preserved)
└── uploads/                        # Images, PDFs
```

## Adding New Content

Content lives in `src-site/content/` as Markdown files with YAML frontmatter. Each content type has a specific directory and schema.

### How to add a new item

1. Create a `.md` file in the correct `src-site/content/` subdirectory
2. Use the slug-based filename: lowercase, hyphens, no special chars (e.g., `agents-incorporated.md`)
3. Fill in the frontmatter following the schema for that content type (below)
4. Add a body paragraph below the `---` that matches or expands on the `summary`
5. Commit and push to `main` — GitHub Actions handles the rest

### Content Schemas

**papers/** — Scholarly/journal articles (appears under "Scholarly Articles" on Ideas page)
```yaml
---
title: "Article Title"
date: "YYYY-MM-DD"           # Publication date (use -01-01 if only year known)
venue: "Journal Name"         # Journal or conference
citation: "Full citation string (Journal Name, Year)"
type: "Journal Article"       # or "Conference Paper", "Working Paper"
summary: "One-paragraph description."
authors:                      # Optional, include if co-authored
  - "Kevin Werbach"
  - "Co-Author Name"
tags:
  - "AI Governance"           # Use existing tags from the site
links:                        # Optional
  external: "https://..."     # Link to published version
  pdf: "/path/to/file.pdf"   # Local PDF if available
---
```

**essays/** — Book chapters and essays (appears under "Book Chapters and Essays")
```yaml
---
title: "Chapter/Essay Title"
date: "YYYY-MM-DD"
publication: "Book Title (Publisher)"
type: "essay"
summary: "One-paragraph description."
authors:
  - "Kevin Werbach"
tags:
  - "Blockchain"
---
```

**press/** — General and trade press (appears under "General and Trade Press")
```yaml
---
title: "Article Headline"
date: "YYYY-MM-DD"
publication: "Outlet Name"    # e.g., "CNN", "Wired", "The Atlantic"
summary: "One-paragraph description."
links:
  external: "https://..."     # Link to published article
tags:
  - "Tech Policy"
---
```

**policy/** — White papers and reports (appears under "White Papers and Reports")
```yaml
---
title: "Report Title"
date: "YYYY-MM-DD"
publication: "Issuing Organization"  # e.g., "World Economic Forum"
summary: "One-paragraph description."
tags:
  - "AI Governance"
  - "Tech Policy"
links:
  external: "https://..."
---
```

**testimony/** — Government testimony
```yaml
---
title: "Testimony Title"
date: "YYYY-MM-DD"
venue: "Committee/Body Name"
summary: "One-paragraph description."
tags:
  - "Tech Policy"
links:
  external: "https://..."
---
```

**books/** — Books
```yaml
---
title: "Book Title"
date: "YYYY-MM-DD"
publisher: "Publisher Name"
summary: "One-paragraph description."
coverImage: "/filename.jpg"   # Image in repo root
tags:
  - "Blockchain"
links:
  amazon: "https://..."
  publisher: "https://..."
---
```

**media/** — Podcast episodes, media appearances
```yaml
---
title: "Episode or Appearance Title"
date: "YYYY-MM-DD"
publication: "Show/Outlet Name"
type: "podcast" | "video" | "interview"
summary: "One-paragraph description."
tags:
  - "AI Governance"
links:
  external: "https://..."
---
```

**projects/** — Research projects
```yaml
---
title: "Project Name"
date: "YYYY-MM-DD"
summary: "One-paragraph description."
image: "/image.png"
tags:
  - "AI Governance"
links:
  external: "https://..."
---
```

### Valid Tags

Use existing tags to maintain consistency. Current tags on the site:
- AI Governance
- Blockchain
- China
- DAOs
- Decentralized Finance
- Future of Education
- Gamification
- Tech Business
- Tech Policy
- Telecom

Add new tags only if the item genuinely doesn't fit any existing category.

## Git Workflow

- **Default branch:** `main` (deploys automatically on push)
- One logical change per commit
- Commit message format for content: `Add [type]: "Title"` (e.g., `Add paper: "Agents, Incorporated"`)
- Do not commit secrets, `.env` files, or API keys
- The `src-site/` directory is excluded from rsync deploy — only the built output ships

## Development

```bash
cd src-site
npm install
npm run dev          # Local dev server
npm run build        # Production build to src-site/dist/
```

## Things NOT to Touch

- **Legacy HTML directories** (about-old/, auditorium/, barebones/, digitalshow/, web/, whirrled/, etc.) — these are preserved historical pages from 1995–2003
- **assets/** directory at repo root — generated by the build, overwritten on deploy
- **index.html** at repo root — generated, overwritten on deploy
- **deploy.yml** rsync filter rules — these protect other sites hosted on the same server
- **.htaccess** files — routing rules for Apache

## Notes for Claude

- When asked to "add an article" or "add a new paper," create the markdown file, commit, and push. The deploy pipeline handles everything else.
- If the user provides a URL, use it for the `links.external` field.
- If the user says "press" or "op-ed" or "column," it goes in `press/`.
- If the user says "paper" or "article" in an academic context, it goes in `papers/`.
- If the user says "chapter" or "essay" or "book chapter," it goes in `essays/`.
- If the user says "report" or "white paper" or "policy brief," it goes in `policy/`.
- Dates: use the actual publication date if known. If only the year is known, use `YYYY-01-01`.
- Always confirm with the user before pushing if there's any ambiguity about which category something belongs in.
