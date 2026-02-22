#!/usr/bin/env node

/**
 * Search Index Builder
 * 
 * Walks through /content directory and builds a JSON search index
 * for use with Fuse.js on the frontend
 * 
 * Usage: npm run build:search
 */

import { readdirSync, readFileSync, writeFileSync, statSync } from 'fs';
import { join, dirname } from 'path';
import { fileURLToPath } from 'url';
import matter from 'gray-matter';

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

// Get content directory - use resolve to handle spaces correctly
const contentDir = join(__dirname, '../../content');
const outputPath = join(__dirname, '../../public/search-index.json');

// Helper to recursively get all .md files
function getAllMarkdownFiles(dir, fileList = []) {
  const files = readdirSync(dir);
  
  files.forEach(file => {
    const filePath = join(dir, file);
    const stat = statSync(filePath);
    
    if (stat.isDirectory()) {
      fileList = getAllMarkdownFiles(filePath, fileList);
    } else if (file.endsWith('.md')) {
      fileList.push(filePath);
    }
  });
  
  return fileList;
}

// Determine content type from file path
function getContentType(filePath) {
  if (filePath.includes('/papers/')) return 'paper';
  if (filePath.includes('/essays/')) return 'essay';
  if (filePath.includes('/policy/')) return 'policy';
  if (filePath.includes('/projects/')) return 'project';
  if (filePath.includes('/books/')) return 'book';
  if (filePath.includes('/teaching/')) return 'course';
  if (filePath.includes('/podcast/')) return 'podcast';
  if (filePath.includes('/media/press/')) return 'press';
  if (filePath.includes('/media/video/')) return 'video';
  return 'other';
}

// Generate URL path from file path
function getUrlPath(filePath, contentType) {
  const fileName = filePath.split('/').pop().replace('.md', '');
  
  switch (contentType) {
    case 'paper':
    case 'essay':
    case 'policy':
      return `/ideas/${fileName}`;
    case 'project':
      return `/projects/${fileName}`;
    case 'book':
      return `/books/${fileName}`;
    case 'course':
      return `/teaching/${fileName}`;
    case 'podcast':
      return `/podcast/${fileName}`;
    case 'press':
    case 'video':
      return `/media/${fileName}`;
    default:
      return `/${fileName}`;
  }
}

// Extract text content from markdown (strip markdown syntax)
function extractTextContent(markdown) {
  return markdown
    .replace(/^#{1,6}\s+/gm, '') // Remove headers
    .replace(/\*\*(.+?)\*\*/g, '$1') // Remove bold
    .replace(/\*(.+?)\*/g, '$1') // Remove italic
    .replace(/\[(.+?)\]\(.+?\)/g, '$1') // Remove links, keep text
    .replace(/```[\s\S]*?```/g, '') // Remove code blocks
    .replace(/`(.+?)`/g, '$1') // Remove inline code
    .replace(/\n{3,}/g, '\n\n') // Normalize line breaks
    .trim();
}

// Build search index
function buildSearchIndex() {
  console.log('Building search index...\n');
  
  const markdownFiles = getAllMarkdownFiles(contentDir);
  console.log(`Found ${markdownFiles.length} markdown files\n`);
  
  const searchIndex = [];
  let processed = 0;
  let skipped = 0;
  
  markdownFiles.forEach(filePath => {
    try {
      const fileContent = readFileSync(filePath, 'utf8');
      const { data: frontmatter, content } = matter(fileContent);
      
      // Skip if no title
      if (!frontmatter.title) {
        skipped++;
        return;
      }
      
      const contentType = getContentType(filePath);
      const urlPath = getUrlPath(filePath, contentType);
      
      // Extract first 300 chars of content for preview
      const textContent = extractTextContent(content);
      const preview = textContent.substring(0, 300) + (textContent.length > 300 ? '...' : '');
      
      // Build search entry
      const entry = {
        id: filePath.split('/').pop().replace('.md', ''),
        title: frontmatter.title || 'Untitled',
        summary: frontmatter.summary || preview,
        content: textContent,
        type: contentType,
        url: urlPath,
        date: frontmatter.date || '',
        tags: frontmatter.tags || [],
        topics: frontmatter.topics || [],
        // Additional metadata
        author: frontmatter.author || 'Kevin Werbach',
        outlet: frontmatter.outlet || '',
        venue: frontmatter.venue || frontmatter.journal || '',
        year: frontmatter.year || (frontmatter.date ? new Date(frontmatter.date).getFullYear().toString() : ''),
      };
      
      // Remove empty fields
      Object.keys(entry).forEach(key => {
        if (entry[key] === '' || (Array.isArray(entry[key]) && entry[key].length === 0)) {
          delete entry[key];
        }
      });
      
      searchIndex.push(entry);
      processed++;
      
      console.log(`✓ Indexed: ${entry.type} - ${entry.title}`);
      
    } catch (error) {
      console.error(`✗ Failed to process ${filePath}:`, error.message);
      skipped++;
    }
  });
  
  // Sort by date (newest first)
  searchIndex.sort((a, b) => {
    const dateA = a.date ? new Date(a.date) : new Date(0);
    const dateB = b.date ? new Date(b.date) : new Date(0);
    return dateB - dateA;
  });
  
  // Write to file
  const output = {
    generated: new Date().toISOString(),
    count: searchIndex.length,
    index: searchIndex
  };
  
  writeFileSync(outputPath, JSON.stringify(output, null, 2), 'utf8');
  
  console.log(`\n✓ Complete! Indexed ${processed} items, skipped ${skipped}`);
  console.log(`Search index written to: public/search-index.json`);
  console.log(`Index size: ${(JSON.stringify(output).length / 1024).toFixed(2)} KB\n`);
  
  // Print statistics
  const typeCounts = searchIndex.reduce((acc, item) => {
    acc[item.type] = (acc[item.type] || 0) + 1;
    return acc;
  }, {});
  
  console.log('Content breakdown:');
  Object.entries(typeCounts)
    .sort((a, b) => b[1] - a[1])
    .forEach(([type, count]) => {
      console.log(`  ${type}: ${count}`);
    });
  
  return searchIndex;
}

// Main execution
function main() {
  try {
    const index = buildSearchIndex();
    console.log(`\n✓ Search index ready for use with Fuse.js!`);
  } catch (error) {
    console.error('Fatal error:', error);
    process.exit(1);
  }
}

// Run the script
main();
