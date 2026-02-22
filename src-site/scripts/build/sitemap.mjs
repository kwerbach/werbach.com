import { readdir, readFile, writeFile } from 'fs/promises';
import { join } from 'path';
import matter from 'gray-matter';

const SITE_URL = 'https://kevinwerbach.com';
const CONTENT_DIR = join(process.cwd(), 'content');
const OUTPUT_FILE = join(process.cwd(), 'public', 'sitemap.xml');

const STATIC_PAGES = [
  { url: '/', priority: '1.0', changefreq: 'weekly' },
  { url: '/ideas', priority: '0.9', changefreq: 'weekly' },
  { url: '/projects', priority: '0.8', changefreq: 'monthly' },
  { url: '/books', priority: '0.8', changefreq: 'monthly' },
  { url: '/teaching', priority: '0.7', changefreq: 'monthly' },
  { url: '/speaking', priority: '0.7', changefreq: 'monthly' },
  { url: '/podcast', priority: '0.9', changefreq: 'weekly' },
  { url: '/media', priority: '0.8', changefreq: 'weekly' },
  { url: '/about', priority: '0.6', changefreq: 'monthly' },
  { url: '/contact', priority: '0.5', changefreq: 'yearly' }
];

async function getAllMarkdownFiles(dir, baseType) {
  const entries = await readdir(dir, { withFileTypes: true });
  const files = [];

  for (const entry of entries) {
    const fullPath = join(dir, entry.name);
    if (entry.isDirectory()) {
      files.push(...await getAllMarkdownFiles(fullPath, baseType));
    } else if (entry.name.endsWith('.md')) {
      const content = await readFile(fullPath, 'utf-8');
      const { data } = matter(content);
      const slug = entry.name.replace('.md', '');
      
      files.push({
        slug,
        type: baseType,
        date: data.date || new Date().toISOString(),
        priority: '0.7',
        changefreq: 'monthly'
      });
    }
  }

  return files;
}

async function generateSitemap() {
  console.log('Generating sitemap.xml...');

  // Get all content files
  const contentTypes = ['papers', 'essays', 'policy', 'projects', 'podcast'];
  const contentUrls = [];

  for (const type of contentTypes) {
    const dir = join(CONTENT_DIR, type);
    try {
      const files = await getAllMarkdownFiles(dir, type);
      
      for (const file of files) {
        let urlPath;
        if (type === 'papers' || type === 'essays' || type === 'policy') {
          urlPath = `/ideas/${file.slug}`;
        } else if (type === 'projects') {
          urlPath = `/projects/${file.slug}`;
        } else if (type === 'podcast') {
          urlPath = `/podcast/${file.slug}`;
        }

        if (urlPath) {
          contentUrls.push({
            url: urlPath,
            lastmod: file.date,
            priority: file.priority,
            changefreq: file.changefreq
          });
        }
      }
    } catch (error) {
      console.warn(`Warning: Could not read ${type} directory:`, error.message);
    }
  }

  // Combine static and content URLs
  const allUrls = [
    ...STATIC_PAGES.map(page => ({
      url: page.url,
      lastmod: new Date().toISOString(),
      priority: page.priority,
      changefreq: page.changefreq
    })),
    ...contentUrls
  ];

  // Generate XML
  const xml = `<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
${allUrls.map(item => `  <url>
    <loc>${SITE_URL}${item.url}</loc>
    <lastmod>${item.lastmod.split('T')[0]}</lastmod>
    <changefreq>${item.changefreq}</changefreq>
    <priority>${item.priority}</priority>
  </url>`).join('\n')}
</urlset>`;

  // Write sitemap
  await writeFile(OUTPUT_FILE, xml, 'utf-8');
  
  console.log(`✓ Sitemap generated with ${allUrls.length} URLs`);
  console.log(`  - ${STATIC_PAGES.length} static pages`);
  console.log(`  - ${contentUrls.length} content pages`);
  console.log(`  Output: ${OUTPUT_FILE}`);
}

generateSitemap().catch(error => {
  console.error('Error generating sitemap:', error);
  process.exit(1);
});
