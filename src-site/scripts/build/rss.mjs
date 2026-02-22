import { readdir, readFile, writeFile } from 'fs/promises';
import { join } from 'path';
import matter from 'gray-matter';

const SITE_URL = 'https://kevinwerbach.com';
const CONTENT_DIR = join(process.cwd(), 'content');
const IDEAS_OUTPUT = join(process.cwd(), 'public', 'rss-ideas.xml');
const PODCAST_OUTPUT = join(process.cwd(), 'public', 'rss-podcast.xml');

async function getAllMarkdownFiles(dir, baseType) {
  const entries = await readdir(dir, { withFileTypes: true });
  const files = [];

  for (const entry of entries) {
    const fullPath = join(dir, entry.name);
    if (entry.isDirectory()) {
      files.push(...await getAllMarkdownFiles(fullPath, baseType));
    } else if (entry.name.endsWith('.md')) {
      const content = await readFile(fullPath, 'utf-8');
      const { data, content: markdown } = matter(content);
      const slug = entry.name.replace('.md', '');
      
      files.push({
        slug,
        type: baseType,
        title: data.title || 'Untitled',
        date: data.date || new Date().toISOString(),
        summary: data.summary || data.description || '',
        authors: data.authors || ['Kevin Werbach'],
        content: markdown.substring(0, 500) // First 500 chars
      });
    }
  }

  return files;
}

function escapeXml(text) {
  if (!text) return '';
  return text
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&apos;');
}

function generateRssItem(item, urlPath) {
  const pubDate = new Date(item.date).toUTCString();
  const link = `${SITE_URL}${urlPath}`;
  
  return `    <item>
      <title>${escapeXml(item.title)}</title>
      <link>${link}</link>
      <guid isPermaLink="true">${link}</guid>
      <pubDate>${pubDate}</pubDate>
      <description>${escapeXml(item.summary)}</description>
      ${item.authors.map(author => `<author>${escapeXml(author)}</author>`).join('\n      ')}
    </item>`;
}

async function generateIdeasRss() {
  console.log('Generating Ideas RSS feed...');

  // Get papers, essays, and policy documents
  const types = ['papers', 'essays', 'policy'];
  const allItems = [];

  for (const type of types) {
    const dir = join(CONTENT_DIR, type);
    try {
      const files = await getAllMarkdownFiles(dir, type);
      allItems.push(...files);
    } catch (error) {
      console.warn(`Warning: Could not read ${type} directory:`, error.message);
    }
  }

  // Sort by date, most recent first
  allItems.sort((a, b) => new Date(b.date) - new Date(a.date));

  // Take top 20
  const recentItems = allItems.slice(0, 20);

  const rssItems = recentItems.map(item => 
    generateRssItem(item, `/ideas/${item.slug}`)
  ).join('\n');

  const xml = `<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
  <channel>
    <title>Kevin Werbach - Ideas</title>
    <link>${SITE_URL}/ideas</link>
    <description>Research papers, essays, and policy work by Kevin Werbach</description>
    <language>en-us</language>
    <lastBuildDate>${new Date().toUTCString()}</lastBuildDate>
    <atom:link href="${SITE_URL}/rss-ideas.xml" rel="self" type="application/rss+xml" />
${rssItems}
  </channel>
</rss>`;

  await writeFile(IDEAS_OUTPUT, xml, 'utf-8');
  console.log(`✓ Ideas RSS feed generated with ${recentItems.length} items`);
  console.log(`  Output: ${IDEAS_OUTPUT}`);
}

async function generatePodcastRss() {
  console.log('Generating Podcast RSS feed...');

  const dir = join(CONTENT_DIR, 'podcast');
  let episodes = [];

  try {
    episodes = await getAllMarkdownFiles(dir, 'podcast');
  } catch (error) {
    console.warn('Warning: Could not read podcast directory:', error.message);
    return;
  }

  // Sort by date, most recent first
  episodes.sort((a, b) => new Date(b.date) - new Date(a.date));

  const rssItems = episodes.map(item => 
    generateRssItem(item, `/podcast/${item.slug}`)
  ).join('\n');

  const xml = `<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd">
  <channel>
    <title>Kevin Werbach Podcast</title>
    <link>${SITE_URL}/podcast</link>
    <description>Conversations on technology, policy, and innovation with Kevin Werbach</description>
    <language>en-us</language>
    <lastBuildDate>${new Date().toUTCString()}</lastBuildDate>
    <atom:link href="${SITE_URL}/rss-podcast.xml" rel="self" type="application/rss+xml" />
    <itunes:author>Kevin Werbach</itunes:author>
    <itunes:summary>Conversations on technology, policy, and innovation</itunes:summary>
    <itunes:owner>
      <itunes:name>Kevin Werbach</itunes:name>
    </itunes:owner>
    <itunes:explicit>no</itunes:explicit>
    <itunes:category text="Technology" />
    <itunes:category text="Business" />
${rssItems}
  </channel>
</rss>`;

  await writeFile(PODCAST_OUTPUT, xml, 'utf-8');
  console.log(`✓ Podcast RSS feed generated with ${episodes.length} episodes`);
  console.log(`  Output: ${PODCAST_OUTPUT}`);
}

async function generateAllRss() {
  await generateIdeasRss();
  await generatePodcastRss();
  console.log('✓ All RSS feeds generated successfully');
}

generateAllRss().catch(error => {
  console.error('Error generating RSS feeds:', error);
  process.exit(1);
});
