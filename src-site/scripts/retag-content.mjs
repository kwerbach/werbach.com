#!/usr/bin/env node
import { readFileSync, writeFileSync, readdirSync, statSync } from 'fs';
import { join, extname } from 'path';

// Mapping of old tags to new core themes
const tagMapping = {
  // AI themes
  'ai': ['AI'],
  'artificial intelligence': ['AI'],
  'machine learning': ['AI'],
  'ai accountability': ['AI Governance'],
  'ai governance': ['AI Governance'],
  'ai ethics': ['AI Governance'],
  'responsible ai': ['AI Governance'],
  'accountability': ['AI Governance'],
  
  // Blockchain/Crypto themes
  'blockchain': ['Digital Asset Regulation'],
  'cryptocurrency': ['Digital Asset Regulation'],
  'crypto': ['Digital Asset Regulation'],
  'bitcoin': ['Digital Asset Regulation'],
  'ethereum': ['Digital Asset Regulation'],
  'web3': ['Digital Asset Regulation'],
  'digital assets': ['Digital Asset Regulation'],
  'trust': ['Digital Asset Regulation'],
  
  // DeFi
  'defi': ['Decentralized Finance'],
  'decentralized finance': ['Decentralized Finance'],
  'finance': ['Decentralized Finance'],
  'financial technology': ['Decentralized Finance'],
  
  // DAOs
  'dao': ['DAOs'],
  'daos': ['DAOs'],
  'decentralized autonomous organizations': ['DAOs'],
  'decentralized governance': ['DAOs'],
  
  // Tech Policy
  'tech policy': ['Tech Policy'],
  'technology policy': ['Tech Policy'],
  'internet policy': ['Tech Policy'],
  'regulation': ['Tech Policy'],
  'policy': ['Tech Policy'],
  'platform governance': ['Tech Policy'],
  'digital rights': ['Tech Policy'],
  'net neutrality': ['Tech Policy'],
  'privacy': ['Tech Policy'],
  'data privacy': ['Tech Policy'],
  'networks': ['Tech Policy'],
  'internet': ['Tech Policy'],
  'telecommunications': ['Tech Policy'],
  
  // Gamification
  'gamification': ['Gamification'],
  'game design': ['Gamification'],
  'games': ['Gamification'],
  'motivation': ['Gamification'],
  'engagement': ['Gamification'],
  
  // China
  'china': ['China'],
  'chinese technology': ['China']
};

// Determine tags based on content
function inferTagsFromContent(frontmatter, content) {
  const tags = new Set();
  const text = `${frontmatter.title || ''} ${frontmatter.summary || ''} ${content}`.toLowerCase();
  
  // Check for specific keywords
  if (text.match(/\b(dao|daos|decentralized autonomous)\b/i)) tags.add('DAOs');
  if (text.match(/\b(defi|decentralized finance)\b/i)) tags.add('Decentralized Finance');
  if (text.match(/\b(china|chinese)\b/i)) tags.add('China');
  if (text.match(/\b(gamif|game design)\b/i)) tags.add('Gamification');
  if (text.match(/\b(ai governance|ai accountability|responsible ai|ai ethics)\b/i)) tags.add('AI Governance');
  if (text.match(/\b(artificial intelligence|machine learning)\b/i) && !tags.has('AI Governance')) tags.add('AI');
  if (text.match(/\b(blockchain|cryptocurrency|bitcoin|ethereum|web3)\b/i)) {
    if (text.match(/\b(regulation|policy|law|legal)\b/i)) {
      tags.add('Digital Asset Regulation');
    } else if (text.match(/\b(finance|defi|trading)\b/i)) {
      tags.add('Decentralized Finance');
    } else {
      tags.add('Digital Asset Regulation');
    }
  }
  if (text.match(/\b(internet policy|tech policy|regulation|platform governance|net neutrality|privacy|telecommunications)\b/i)) {
    tags.add('Tech Policy');
  }
  
  return Array.from(tags);
}

// Parse frontmatter and convert tags
function processFile(filePath) {
  const content = readFileSync(filePath, 'utf-8');
  const match = content.match(/^---\n([\s\S]*?)\n---\n([\s\S]*)$/);
  
  if (!match) {
    console.log(`Skipping ${filePath} - no frontmatter`);
    return;
  }
  
  const [, frontmatterText, bodyContent] = match;
  const lines = frontmatterText.split('\n');
  const frontmatter = {};
  let currentKey = null;
  let currentArray = [];
  
  // Parse YAML-like frontmatter
  for (const line of lines) {
    if (line.match(/^(\w+):/)) {
      if (currentKey && currentArray.length > 0) {
        frontmatter[currentKey] = currentArray;
      }
      const [, key] = line.match(/^(\w+):\s*(.*)$/);
      currentKey = key;
      currentArray = [];
      
      // Check if value is on same line
      const valueMatch = line.match(/^(\w+):\s*(.+)$/);
      if (valueMatch && valueMatch[2]) {
        const value = valueMatch[2].trim();
        if (value.startsWith('[')) {
          // JSON array format
          try {
            frontmatter[key] = JSON.parse(value);
          } catch {
            frontmatter[key] = value;
          }
        } else if (value.startsWith('"') || !value.startsWith('-')) {
          frontmatter[key] = value.replace(/^["']|["']$/g, '');
          currentKey = null;
        }
      }
    } else if (line.trim().startsWith('-')) {
      const value = line.trim().substring(1).trim().replace(/^["']|["']$/g, '');
      currentArray.push(value);
    }
  }
  
  if (currentKey && currentArray.length > 0) {
    frontmatter[currentKey] = currentArray;
  }
  
  // Collect old tags
  const oldTags = new Set();
  if (frontmatter.topics) {
    (Array.isArray(frontmatter.topics) ? frontmatter.topics : [frontmatter.topics]).forEach(t => oldTags.add(t.toLowerCase()));
  }
  if (frontmatter.tags) {
    (Array.isArray(frontmatter.tags) ? frontmatter.tags : [frontmatter.tags])
      .filter(t => !t.match(/^\d{4}$/)) // Skip year tags
      .forEach(t => oldTags.add(t.toLowerCase()));
  }
  
  // Map to new tags
  const newTags = new Set();
  oldTags.forEach(oldTag => {
    if (tagMapping[oldTag]) {
      tagMapping[oldTag].forEach(t => newTags.add(t));
    }
  });
  
  // Infer additional tags from content
  const inferredTags = inferTagsFromContent(frontmatter, bodyContent);
  inferredTags.forEach(t => newTags.add(t));
  
  // If no tags found, try harder
  if (newTags.size === 0) {
    console.log(`⚠️  No tags found for ${filePath}, inferring from content...`);
    const text = `${frontmatter.title || ''} ${frontmatter.summary || ''} ${bodyContent}`.toLowerCase();
    if (text.includes('gamif')) newTags.add('Gamification');
    if (text.includes('blockchain') || text.includes('crypto')) newTags.add('Digital Asset Regulation');
    if (text.includes('policy') || text.includes('regulation')) newTags.add('Tech Policy');
    if (text.includes('ai') || text.includes('artificial intelligence')) newTags.add('AI');
  }
  
  const finalTags = Array.from(newTags).sort();
  
  if (finalTags.length === 0) {
    console.log(`❌ Could not determine tags for ${filePath}`);
    return;
  }
  
  // Rebuild frontmatter with new tags
  const newLines = [];
  let skipNext = false;
  let inTopics = false;
  let inTags = false;
  
  for (let i = 0; i < lines.length; i++) {
    const line = lines[i];
    
    if (line.startsWith('topics:')) {
      inTopics = true;
      inTags = false;
      skipNext = true;
      continue;
    } else if (line.startsWith('tags:')) {
      inTags = true;
      inTopics = false;
      skipNext = true;
      continue;
    } else if (line.match(/^(\w+):/)) {
      inTopics = false;
      inTags = false;
      skipNext = false;
    }
    
    if (inTopics || inTags) {
      if (line.trim().startsWith('-')) {
        continue; // Skip old tag entries
      } else {
        inTopics = false;
        inTags = false;
      }
    }
    
    if (!skipNext) {
      newLines.push(line);
    }
    skipNext = false;
  }
  
  // Add tags field at appropriate position (after summary/journal/year if present)
  const insertIndex = newLines.findIndex(line => 
    line.startsWith('external_url:') || 
    line.startsWith('doi:') || 
    line.startsWith('coverImage:') ||
    line.startsWith('buy_links:')
  );
  
  const tagsLines = ['tags:'].concat(finalTags.map(tag => `  - "${tag}"`));
  
  if (insertIndex !== -1) {
    newLines.splice(insertIndex, 0, ...tagsLines);
  } else {
    newLines.push(...tagsLines);
  }
  
  const newFrontmatter = newLines.join('\n');
  const newContent = `---\n${newFrontmatter}\n---\n${bodyContent}`;
  
  writeFileSync(filePath, newContent, 'utf-8');
  console.log(`✅ ${filePath}: ${finalTags.join(', ')}`);
}

// Recursively process directory
function processDirectory(dirPath) {
  const items = readdirSync(dirPath);
  
  for (const item of items) {
    const fullPath = join(dirPath, item);
    const stat = statSync(fullPath);
    
    if (stat.isDirectory()) {
      processDirectory(fullPath);
    } else if (extname(fullPath) === '.md') {
      try {
        processFile(fullPath);
      } catch (error) {
        console.error(`Error processing ${fullPath}:`, error.message);
      }
    }
  }
}

// Run the script
const contentDir = join(process.cwd(), 'content');
console.log('Starting content retagging...\n');
processDirectory(contentDir);
console.log('\n✨ Retagging complete!');
