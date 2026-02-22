# CLAUDE.md — werbach.com

## Project Overview

**Repository:** `kwerbach/werbach.com`
**Live URL:** https://werbach.com
**Hosting:** Pair Networks shared hosting (FreeBSD), user `kwerbach`
**Deploy target:** `~/public_html/` on Pair Networks

## Architecture

Static HTML site. No build step, no framework. Files deploy directly via rsync.

## Deployment

Push to `main` triggers GitHub Actions workflow (`.github/workflows/deploy.yml`) that rsyncs to Pair Networks via SSH.

**Secrets required:** `PAIR_SSH_KEY`, `PAIR_SSH_USER`, `PAIR_SSH_HOST`

The rsync uses `--delete` with `--filter='protect ...'` rules to avoid touching subfolders belonging to other sites hosted under the same `public_html/`.

## Site Structure

### Root-level pages
- `index.php` — main entry point
- `about.html`, `bio.html`, `books.html` — personal/professional info
- `consulting.html`, `contact.html`, `research.html` — professional pages
- `home.html` — original 1990s personal homepage
- `news.html`, `news.htm` — personal browser portal page
- `werblist.html`, `whirrled.html` — legacy content pages
- `thanks.html`, `error.html` — utility pages

### Subfolders (part of this repo)
- `assets/` — site assets (CSS, JS, images)
- `images/`, `img/`, `images99/` — image directories
- `barebones/` — "The Barebones Guide to HTML" (historical flat file site)
- `whirrled/` — Whirrled site (historical flat files)
- `auditorium/`, `web/`, `stuff/`, `lists/` — original 1990s personal site sections

### Support files
- `.htaccess` — Apache configuration
- `favicon.ico`, `robots.txt`, `stylesheet.css`

## Important Notes

- `~/public_html/` on the server also contains subfolders for other sites (accountableai.net, trusttheblockchain.net, etc.) — the deploy workflow protects these with rsync filters.
- Do NOT add other sites' folders to this repo.
- `news.html` must remain accessible at werbach.com/news.html (personal portal page).
