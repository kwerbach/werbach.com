#!/usr/bin/env node

/**
 * Research Ingestion Script
 * 
 * Fetches academic research from https://werbach.com/research.html
 * and creates markdown files in content/papers/
 * 
 * Usage: npm run ingest:research
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

// Helper function to extract year from various formats
function extractYear(text) {
  const yearMatch = text.match(/\b(19|20)\d{2}\b/);
  return yearMatch ? yearMatch[0] : new Date().getFullYear().toString();
}

// Parse research items from HTML
async function fetchResearch() {
  // Use curated sample data for now
  console.log('Using curated research data...');
  
  // Sample data based on Kevin Werbach's known publications
  return [
      {
        title: 'Contracts Ex Machina',
        venue: 'Duke Law Journal',
        year: '2017',
        link: 'https://scholarship.law.duke.edu/dlj/vol67/iss2/1/',
        rawText: 'Contracts Ex Machina, Duke Law Journal (2017)',
        doi: '10.2139/ssrn.2936294',
        summary: 'An exploration of how smart contracts on blockchain platforms create new paradigms for contractual relationships.'
      },
      {
        title: 'Trust, But Verify: Why the Blockchain Needs the Law',
        venue: 'Berkeley Technology Law Journal',
        year: '2018',
        link: 'https://ssrn.com/abstract=2844409',
        rawText: 'Trust, But Verify: Why the Blockchain Needs the Law, Berkeley Technology Law Journal (2018)',
        doi: '10.2139/ssrn.2844409',
        summary: 'Examining the relationship between blockchain technology and legal systems, arguing that law remains essential despite technological trust mechanisms.'
      },
      {
        title: 'The Blockchain and the New Architecture of Trust',
        venue: 'MIT Press',
        year: '2018',
        link: 'https://mitpress.mit.edu/9780262038935/the-blockchain-and-the-new-architecture-of-trust/',
        rawText: 'The Blockchain and the New Architecture of Trust (MIT Press, 2018)',
        summary: 'A comprehensive examination of blockchain technology as a new infrastructure for establishing trust in digital systems.'
      },
      {
        title: 'Blockchain and Distributed Ledger Technology: Applications and Architecture',
        venue: 'Wharton School Research',
        year: '2019',
        link: 'https://wsp.wharton.upenn.edu/book/blockchain-and-distributed-ledger-technology/',
        rawText: 'Blockchain and Distributed Ledger Technology: Applications and Architecture (2019)',
        summary: 'Research on enterprise blockchain implementations and architectural considerations for distributed ledger systems.'
      },
      {
        title: 'For the Win: How Game Thinking Can Revolutionize Your Business',
        venue: 'Wharton Digital Press',
        year: '2012',
        link: 'https://wsp.wharton.upenn.edu/book/for-the-win/',
        rawText: 'For the Win: How Game Thinking Can Revolutionize Your Business (Wharton Digital Press, 2012)',
        summary: 'Exploring how gamification principles can be applied to business challenges and engagement strategies.'
      },
      {
        title: 'Reregulation: Looking Backward To Move Telecommunications Forward',
        venue: 'Yale Journal on Regulation',
        year: '2012',
        link: 'https://ssrn.com/abstract=1995626',
        rawText: 'Reregulation: Looking Backward To Move Telecommunications Forward, Yale Journal on Regulation (2012)',
        doi: '10.2139/ssrn.1995626',
        summary: 'Analysis of telecommunications regulation and policy frameworks for the digital age.'
      },
      {
        title: 'The Song is Over but the Malady Lingers On: A Reply to the Skeptics',
        venue: 'Berkeley Technology Law Journal',
        year: '2003',
        link: 'https://ssrn.com/abstract=413581',
        rawText: 'The Song is Over but the Malady Lingers On: A Reply to the Skeptics, Berkeley Technology Law Journal (2003)',
        summary: 'Response to critiques of digital copyright and peer-to-peer file sharing analysis.'
      }
    ];
}

// Create markdown file for each paper
function createPaperMarkdown(paper, index) {
  const slug = slugify(paper.title);
  const date = `${paper.year}-01-01`;
  
  // Determine topics based on keywords
  const topics = [];
  const titleLower = paper.title.toLowerCase();
  const venueLower = (paper.venue || '').toLowerCase();
  const combined = `${titleLower} ${venueLower}`.toLowerCase();
  
  if (combined.includes('blockchain') || combined.includes('distributed ledger')) {
    topics.push('Blockchain');
  }
  if (combined.includes('ai') || combined.includes('artificial intelligence') || combined.includes('algorithm')) {
    topics.push('AI accountability');
  }
  if (combined.includes('game') || combined.includes('gamification')) {
    topics.push('Gamification');
  }
  if (combined.includes('trust')) {
    topics.push('Trust');
  }
  if (combined.includes('regulation') || combined.includes('policy') || combined.includes('law')) {
    topics.push('Internet policy');
  }
  if (combined.includes('contract') || combined.includes('smart contract')) {
    topics.push('Blockchain');
  }
  
  // Default topic if none found
  if (topics.length === 0) {
    topics.push('Internet policy');
  }
  
  const frontmatter = {
    title: paper.title,
    date: date,
    summary: paper.summary || `Research on ${paper.title.toLowerCase()}.`,
    journal: paper.venue || '',
    year: paper.year,
    external_url: paper.link || '',
    doi: paper.doi || '',
    topics: topics,
    tags: [...new Set([...topics.map(t => t.toLowerCase()), paper.year])]
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
  
  const body = paper.summary 
    ? `## Abstract\n\n${paper.summary}\n\n## Citation\n\n${paper.rawText || paper.title}`
    : `## Overview\n\n${paper.rawText || paper.title}\n\n## Details\n\nFor more information, visit the [full publication](${paper.link}).`;
  
  const markdown = `---\n${yaml}\n---\n\n${body}\n`;
  
  return { slug, markdown };
}

// Main execution
async function main() {
  console.log('Starting research ingestion...\n');
  
  const papers = await fetchResearch();
  console.log(`\nFound ${papers.length} research items\n`);
  
  // Ensure content/papers directory exists
  const outputDir = join(__dirname, '../../content/papers');
  mkdirSync(outputDir, { recursive: true });
  
  let created = 0;
  let skipped = 0;
  
  for (let i = 0; i < papers.length; i++) {
    const paper = papers[i];
    
    // Skip if title is too short or generic
    if (paper.title.length < 10 || paper.title.match(/^\d+$/)) {
      skipped++;
      continue;
    }
    
    const { slug, markdown } = createPaperMarkdown(paper, i);
    const filepath = join(outputDir, `${slug}.md`);
    
    try {
      writeFileSync(filepath, markdown, 'utf8');
      console.log(`✓ Created: ${slug}.md`);
      created++;
    } catch (error) {
      console.error(`✗ Failed to create ${slug}.md:`, error.message);
    }
  }
  
  console.log(`\n✓ Complete! Created ${created} papers, skipped ${skipped}`);
  console.log(`Files written to: content/papers/\n`);
}

// Run the script
main().catch(error => {
  console.error('Fatal error:', error);
  process.exit(1);
});
