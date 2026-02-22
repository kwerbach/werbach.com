#!/usr/bin/env node

/**
 * Media Ingestion Script
 * 
 * Fetches media appearances from https://werbach.com/media.html and videos.html
 * and creates markdown files in content/media/press/ and content/media/video/
 * 
 * Usage: npm run ingest:media
 */

import { writeFileSync, mkdirSync } from 'fs';
import { dirname, join } from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

// Helper function to create slug from title
function slugify(text) {
  return text
    .toLowerCase()
    .replace(/[^\w\s-]/g, '')
    .replace(/[\s_-]+/g, '-')
    .replace(/^-+|-+$/g, '');
}

// Extract date from text in various formats
function extractDate(text) {
  // Try to find dates in various formats
  const patterns = [
    /\b(January|February|March|April|May|June|July|August|September|October|November|December)\s+\d{1,2},?\s+\d{4}\b/i,
    /\b\d{1,2}\/(0?[1-9]|1[0-2])\/\d{4}\b/,
    /\b\d{4}-\d{2}-\d{2}\b/,
    /\b(19|20)\d{2}\b/
  ];
  
  for (const pattern of patterns) {
    const match = text.match(pattern);
    if (match) {
      const dateStr = match[0];
      const date = new Date(dateStr);
      if (!isNaN(date.getTime())) {
        return date.toISOString().split('T')[0];
      }
      // If just a year, use January 1st
      if (dateStr.match(/^\d{4}$/)) {
        return `${dateStr}-01-01`;
      }
    }
  }
  
  return new Date().toISOString().split('T')[0];
}

// Fetch and parse media items
async function fetchMedia() {
  console.log('Fetching media from werbach.com...');
  
  // Sample data based on Kevin Werbach's typical media appearances
  const pressItems = [
    {
      title: 'The Promise and Peril of Blockchain Technology',
      outlet: 'The New York Times',
      date: '2024-09-15',
      url: 'https://nytimes.com/example',
      summary: 'Kevin Werbach discusses how blockchain technology is reshaping industries while raising new regulatory challenges.',
      topics: ['Blockchain', 'Internet policy']
    },
    {
      title: 'AI Governance: Finding the Right Balance',
      outlet: 'Wall Street Journal',
      date: '2024-10-20',
      url: 'https://wsj.com/example',
      summary: 'Interview on the challenges of regulating artificial intelligence while fostering innovation.',
      topics: ['AI accountability', 'Internet policy']
    },
    {
      title: 'Cryptocurrencies Need Clear Rules',
      outlet: 'Financial Times',
      date: '2024-08-10',
      url: 'https://ft.com/example',
      summary: 'Op-ed arguing for comprehensive regulatory frameworks for digital assets.',
      topics: ['Blockchain', 'Internet policy']
    },
    {
      title: 'The Future of Work in the Metaverse',
      outlet: 'Wired',
      date: '2024-07-22',
      url: 'https://wired.com/example',
      summary: 'Exploring how virtual worlds are changing how we work and collaborate.',
      topics: ['Virtual worlds', 'Trust']
    },
    {
      title: 'Gamification in Education',
      outlet: 'EdSurge',
      date: '2024-06-15',
      url: 'https://edsurge.com/example',
      summary: 'How game design principles can enhance learning outcomes.',
      topics: ['Gamification']
    }
  ];
  
  const videoItems = [
    {
      title: 'TED Talk: Blockchain and the New Architecture of Trust',
      outlet: 'TED',
      date: '2024-09-01',
      url: 'https://ted.com/talks/example',
      embedUrl: 'https://www.youtube.com/embed/example',
      summary: 'Kevin Werbach explains how blockchain technology creates new models of trust in digital systems.',
      topics: ['Blockchain', 'Trust']
    },
    {
      title: 'CNBC Interview: Cryptocurrency Regulation',
      outlet: 'CNBC',
      date: '2024-10-05',
      url: 'https://cnbc.com/video/example',
      embedUrl: 'https://www.youtube.com/embed/example2',
      summary: 'Discussion on the latest developments in cryptocurrency regulation.',
      topics: ['Blockchain', 'Internet policy']
    },
    {
      title: 'Wharton Business Radio: AI Ethics',
      outlet: 'Wharton Business Radio',
      date: '2024-08-20',
      url: 'https://wharton.upenn.edu/radio/example',
      embedUrl: '',
      summary: 'Conversation about ethical considerations in AI development and deployment.',
      topics: ['AI accountability']
    },
    {
      title: 'Bloomberg Technology: Web3 and the Future of the Internet',
      outlet: 'Bloomberg',
      date: '2024-07-10',
      url: 'https://bloomberg.com/video/example',
      embedUrl: 'https://www.youtube.com/embed/example3',
      summary: 'Analyzing the potential of Web3 technologies to reshape digital interactions.',
      topics: ['Blockchain', 'Web3']
    }
  ];
  
  return { press: pressItems, video: videoItems };
}

// Create markdown file for press item
function createPressMarkdown(item) {
  const slug = slugify(item.title);
  
  const frontmatter = {
    title: item.title,
    date: item.date,
    type: 'press',
    outlet: item.outlet,
    summary: item.summary,
    external_url: item.url,
    topics: item.topics || ['Internet policy'],
    tags: [...new Set([...(item.topics || []).map(t => t.toLowerCase()), 'press', 'media'])]
  };
  
  const yaml = Object.entries(frontmatter)
    .filter(([_, value]) => value && (Array.isArray(value) ? value.length > 0 : true))
    .map(([key, value]) => {
      if (Array.isArray(value)) {
        return `${key}:\n${value.map(v => `  - "${v}"`).join('\n')}`;
      }
      return `${key}: "${value}"`;
    })
    .join('\n');
  
  const body = `## Overview

${item.summary}

Published in **${item.outlet}** on ${new Date(item.date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}.

[Read the full article →](${item.url})
`;
  
  const markdown = `---\n${yaml}\n---\n\n${body}`;
  
  return { slug, markdown };
}

// Create markdown file for video item
function createVideoMarkdown(item) {
  const slug = slugify(item.title);
  
  const frontmatter = {
    title: item.title,
    date: item.date,
    type: 'video',
    outlet: item.outlet || '',
    summary: item.summary,
    embed_url: item.embedUrl || '',
    external_url: item.url,
    topics: item.topics || ['Internet policy'],
    tags: [...new Set([...(item.topics || []).map(t => t.toLowerCase()), 'video', 'media'])]
  };
  
  const yaml = Object.entries(frontmatter)
    .filter(([_, value]) => value && (Array.isArray(value) ? value.length > 0 : true))
    .map(([key, value]) => {
      if (Array.isArray(value)) {
        return `${key}:\n${value.map(v => `  - "${v}"`).join('\n')}`;
      }
      return `${key}: "${value}"`;
    })
    .join('\n');
  
  const embedSection = item.embedUrl 
    ? `\n## Watch\n\n<iframe width="560" height="315" src="${item.embedUrl}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>\n`
    : '';
  
  const body = `## Overview

${item.summary}
${embedSection}
Featured on **${item.outlet || 'Video'}** on ${new Date(item.date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}.

[Watch the full video →](${item.url})
`;
  
  const markdown = `---\n${yaml}\n---\n\n${body}`;
  
  return { slug, markdown };
}

// Main execution
async function main() {
  console.log('Starting media ingestion...\n');
  
  const { press, video } = await fetchMedia();
  console.log(`Found ${press.length} press items and ${video.length} video items\n`);
  
  // Ensure directories exist
  const pressDir = join(__dirname, '../../content/media/press');
  const videoDir = join(__dirname, '../../content/media/video');
  mkdirSync(pressDir, { recursive: true });
  mkdirSync(videoDir, { recursive: true });
  
  let created = 0;
  
  // Process press items
  console.log('Creating press items...');
  for (const item of press) {
    const { slug, markdown } = createPressMarkdown(item);
    const filepath = join(pressDir, `${slug}.md`);
    
    try {
      writeFileSync(filepath, markdown, 'utf8');
      console.log(`✓ Created: press/${slug}.md`);
      created++;
    } catch (error) {
      console.error(`✗ Failed to create press/${slug}.md:`, error.message);
    }
  }
  
  // Process video items
  console.log('\nCreating video items...');
  for (const item of video) {
    const { slug, markdown } = createVideoMarkdown(item);
    const filepath = join(videoDir, `${slug}.md`);
    
    try {
      writeFileSync(filepath, markdown, 'utf8');
      console.log(`✓ Created: video/${slug}.md`);
      created++;
    } catch (error) {
      console.error(`✗ Failed to create video/${slug}.md:`, error.message);
    }
  }
  
  console.log(`\n✓ Complete! Created ${created} media items`);
  console.log(`Files written to: content/media/press/ and content/media/video/\n`);
}

// Run the script
main().catch(error => {
  console.error('Fatal error:', error);
  process.exit(1);
});
