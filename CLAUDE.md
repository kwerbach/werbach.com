# CLAUDE.md — werbach.com

## Project Overview

**Repository:** `kwerbach/werbach.com`
**Live URL:** https://werbach.com
**Hosting:** Pair Networks shared hosting (FreeBSD), user `kwerbach`
**Deploy target:** `~/public_html/` on Pair Networks

## Architecture

The modern site is a **Vite + React + TypeScript + Tailwind CSS** single-page application.

- **Source code:** `src-site/` directory (React components, content data, build config)
- **Build output:** `src-site/dist/` (generated, not committed)
- **Legacy files:** Root directory also contains legacy HTML pages, images, and subfolders from old versions of the site

## Deployment

Push to `main` triggers GitHub Actions workflow (`.github/workflows/deploy.yml`) that:
1. Installs Node.js 20
2. Runs `npm ci && npm run build` in `src-site/`
3. Copies built output (assets, index.html, images, PDFs) to repo root
4. Rsyncs everything to Pair Networks via SSH

**Secrets required:** `PAIR_SSH_KEY`, `PAIR_SSH_USER`, `PAIR_SSH_HOST`

The rsync uses `--delete` with `--filter='protect ...'` rules to avoid touching subfolders belonging to other sites hosted under the same `public_html/`.

## Adding New Content

### To add a new article to the Ideas page:

Most Ideas page content (Scholarly Articles, Book Chapters/Essays, White Papers, General Press, Testimony, Events) comes from **TypeScript data arrays** in `src-site/src/data/publications.ts`.

1. Open `src-site/src/data/publications.ts`
2. Find the appropriate array (e.g., `scholarlyArticles`, `bookChaptersAndEssays`, `generalAndTradePress`, etc.)
3. Add a new entry at the **top** of the array:
   ```typescript
   { title: "Paper Title", publication: "Journal Name", year: "2026", link: "https://...", tags: ["AI Governance"] },
   ```
4. Commit and push to `main` — the site will auto-build and deploy

**Available tags:** `Telecommunications`, `Tech Policy`, `Blockchain`, `Gamification`, `AI Governance`, `Tech Business`, `Future of Education`, `Decentralized Finance`, `DAOs`, `China`, `Other`

**Data types:**
- `PublicationItem`: `{ title, publication, year, link?, tags? }`
- `EventItem`: `{ title, location, year, link?, tags? }` (for the Events section)

### To add a new book:

Create a new Markdown file in `src-site/content/books/` with YAML frontmatter (see existing files for format).

### To update the CV:

1. Replace the PDF file in `src-site/public/` (e.g., `Werbach CV 2027.pdf`)
2. Update the filename reference in `src-site/src/pages/About.tsx` (the `handleDownloadCV` function)
3. Commit and push

### To update the Media/Press page:

Edit `src-site/src/data/pressAppearances.ts`

## Content Architecture

| Ideas Page Section | Data Source | File |
|---|---|---|
| Books | Markdown files | `src-site/content/books/*.md` |
| Projects | Markdown files (filtered) | `src-site/content/projects/*.md` |
| Scholarly Articles | TypeScript array | `src-site/src/data/publications.ts` → `scholarlyArticles` |
| Book Chapters and Essays | TypeScript array | `src-site/src/data/publications.ts` → `bookChaptersAndEssays` |
| White Papers and Reports | TypeScript array | `src-site/src/data/publications.ts` → `whitePapersAndReports` |
| General and Trade Press | TypeScript array | `src-site/src/data/publications.ts` → `generalAndTradePress` |
| Invited Testimony | TypeScript array | `src-site/src/data/publications.ts` → `invitedTestimony` |
| Events | TypeScript array | `src-site/src/data/publications.ts` → `events` |

## Site Structure

### Source site (`src-site/`)
- `src/` — React components, pages, data files
- `content/` — Markdown content files (books, essays, papers, etc.)
- `public/` — Static assets copied to dist (images, PDFs, etc.)
- `package.json` — Build config (Vite + React + TypeScript)

### Root-level legacy pages
- `about.html`, `bio.html`, `books.html` — old personal/professional info
- `home.html` — original 1990s personal homepage
- `news.html` — personal browser portal page (must remain accessible)
- `barebones/` — "The Barebones Guide to HTML" (historical)
- Various other legacy HTML files and directories

### Support files
- `.htaccess` — Apache configuration (SPA fallback, HTTPS redirect, PHP blocking)
- `favicon.ico`, `robots.txt`, `stylesheet.css`

## Important Notes

- `~/public_html/` on the server also contains subfolders for other sites (accountableai.net, trusttheblockchain.net, digitaltornado.net, etc.) — the deploy workflow protects these with rsync filters.
- Do NOT add other sites' folders to this repo.
- `news.html` must remain accessible at werbach.com/news.html (personal portal page).
- The `.htaccess` includes SPA fallback (`RewriteRule ^ /index.html`) for React Router client-side routing.
- `src-site/node_modules/` and `src-site/dist/` are gitignored.
