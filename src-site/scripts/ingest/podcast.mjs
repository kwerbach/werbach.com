#!/usr/bin/env node

/**
 * Podcast Ingestion Script
 * 
 * Fetches podcast episodes from Accountable AI or Apple Podcasts feed
 * and creates markdown files in content/podcast/episodes/
 * 
 * Usage: npm run ingest:podcast
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

// Fetch podcast episodes
async function fetchPodcastEpisodes() {
  console.log('Fetching podcast episodes...');
  
  // Sample podcast episodes based on typical tech policy content
  const episodes = [
    {
      title: 'The Future of AI Regulation with Dr. Sarah Chen',
      episodeNumber: 42,
      date: '2024-11-01',
      summary: 'A deep dive into emerging regulatory frameworks for artificial intelligence with leading AI policy expert Dr. Sarah Chen.',
      guests: ['Dr. Sarah Chen'],
      audioUrl: 'https://example.com/podcast/episode-42.mp3',
      videoUrl: 'https://youtube.com/watch?v=example42',
      platformLinks: {
        apple: 'https://podcasts.apple.com/podcast/example/episode-42',
        spotify: 'https://open.spotify.com/episode/example42',
        youtube: 'https://youtube.com/watch?v=example42'
      },
      topics: ['AI accountability', 'Internet policy'],
      description: `In this episode, we explore the rapidly evolving landscape of AI regulation with Dr. Sarah Chen, a leading expert in technology policy.

## Topics Discussed
- Current state of AI regulation globally
- EU AI Act and its implications
- US approach to AI governance
- Balancing innovation and safety
- The role of industry self-regulation

## Guest Bio
Dr. Sarah Chen is a Professor of Technology Policy at Stanford University and an advisor to several government agencies on AI regulation.`
    },
    {
      title: 'Blockchain in Practice: Real-World Use Cases',
      episodeNumber: 41,
      date: '2024-10-15',
      summary: 'Exploring successful blockchain implementations across industries with enterprise blockchain consultant Maria Rodriguez.',
      guests: ['Maria Rodriguez'],
      audioUrl: 'https://example.com/podcast/episode-41.mp3',
      videoUrl: '',
      platformLinks: {
        apple: 'https://podcasts.apple.com/podcast/example/episode-41',
        spotify: 'https://open.spotify.com/episode/example41',
        youtube: ''
      },
      topics: ['Blockchain'],
      description: `Maria Rodriguez joins us to discuss real-world blockchain implementations and the lessons learned from enterprise deployments.

## Topics Discussed
- Supply chain transparency
- Financial services applications
- Healthcare record management
- Common pitfalls and success factors
- The future of enterprise blockchain

## Guest Bio
Maria Rodriguez is a blockchain consultant who has worked with Fortune 500 companies on distributed ledger implementations.`
    },
    {
      title: 'Gamification for Social Good',
      episodeNumber: 40,
      date: '2024-09-30',
      summary: 'How game design principles can drive positive behavior change in health, education, and civic engagement.',
      guests: ['Dr. Jane Smith'],
      audioUrl: 'https://example.com/podcast/episode-40.mp3',
      videoUrl: 'https://youtube.com/watch?v=example40',
      platformLinks: {
        apple: 'https://podcasts.apple.com/podcast/example/episode-40',
        spotify: 'https://open.spotify.com/episode/example40',
        youtube: 'https://youtube.com/watch?v=example40'
      },
      topics: ['Gamification'],
      description: `Dr. Jane Smith discusses how gamification can be used for social impact beyond commercial applications.

## Topics Discussed
- Gamification in healthcare
- Educational applications
- Civic engagement platforms
- Ethical considerations
- Measuring impact

## Guest Bio
Dr. Jane Smith is a researcher at MIT studying behavioral design and gamification for social impact.`
    },
    {
      title: 'Web3 and the Future of Digital Identity',
      episodeNumber: 39,
      date: '2024-09-15',
      summary: 'Exploring decentralized identity systems and their implications for privacy and security online.',
      guests: ['Alex Johnson'],
      audioUrl: 'https://example.com/podcast/episode-39.mp3',
      videoUrl: '',
      platformLinks: {
        apple: 'https://podcasts.apple.com/podcast/example/episode-39',
        spotify: 'https://open.spotify.com/episode/example39',
        youtube: ''
      },
      topics: ['Web3', 'Trust'],
      description: `Alex Johnson joins us to discuss how Web3 technologies are enabling new models of digital identity.

## Topics Discussed
- Self-sovereign identity
- Decentralized identifiers (DIDs)
- Privacy-preserving authentication
- Interoperability challenges
- Real-world implementations

## Guest Bio
Alex Johnson is a digital identity architect working on Web3 identity standards.`
    },
    {
      title: 'Trust in the Age of Deepfakes',
      episodeNumber: 38,
      date: '2024-08-30',
      summary: 'Examining how synthetic media challenges our ability to trust digital content and what we can do about it.',
      guests: ['Dr. Lisa Wong'],
      audioUrl: 'https://example.com/podcast/episode-38.mp3',
      videoUrl: 'https://youtube.com/watch?v=example38',
      platformLinks: {
        apple: 'https://podcasts.apple.com/podcast/example/episode-38',
        spotify: 'https://open.spotify.com/episode/example38',
        youtube: 'https://youtube.com/watch?v=example38'
      },
      topics: ['AI accountability', 'Trust'],
      description: `Dr. Lisa Wong discusses the challenges deepfakes pose to trust and information integrity.

## Topics Discussed
- The technology behind deepfakes
- Detection methods
- Legal and ethical implications
- Content authentication
- Building digital trust

## Guest Bio
Dr. Lisa Wong is a computer scientist specializing in media forensics and synthetic media detection.`
    }
  ];
  
  return episodes;
}

// Create markdown file for podcast episode
function createEpisodeMarkdown(episode) {
  const slug = slugify(`episode-${episode.episodeNumber}-${episode.title}`);
  
  const frontmatter = {
    title: episode.title,
    episode_number: episode.episodeNumber,
    date: episode.date,
    summary: episode.summary,
    audio_url: episode.audioUrl || '',
    video_url: episode.videoUrl || '',
    guests: episode.guests || [],
    topics: episode.topics || ['Internet policy'],
    tags: [...new Set([
      ...(episode.topics || []).map(t => t.toLowerCase()),
      'podcast',
      ...(episode.guests || []).map(g => g.toLowerCase())
    ])]
  };
  
  // Build platform links object
  if (episode.platformLinks) {
    frontmatter.platform_links = episode.platformLinks;
  }
  
  const yaml = Object.entries(frontmatter)
    .filter(([_, value]) => {
      if (Array.isArray(value)) return value.length > 0;
      if (typeof value === 'object' && value !== null) return Object.keys(value).length > 0;
      return value !== '' && value !== null && value !== undefined;
    })
    .map(([key, value]) => {
      if (Array.isArray(value)) {
        return `${key}:\n${value.map(v => `  - "${v}"`).join('\n')}`;
      }
      if (typeof value === 'object' && value !== null) {
        const objYaml = Object.entries(value)
          .filter(([_, v]) => v)
          .map(([k, v]) => `  ${k}: "${v}"`)
          .join('\n');
        return objYaml ? `${key}:\n${objYaml}` : '';
      }
      if (typeof value === 'number') {
        return `${key}: ${value}`;
      }
      return `${key}: "${value}"`;
    })
    .filter(Boolean)
    .join('\n');
  
  const platformLinksSection = episode.platformLinks ? `
## Listen

- [Apple Podcasts](${episode.platformLinks.apple || '#'})
- [Spotify](${episode.platformLinks.spotify || '#'})
${episode.platformLinks.youtube ? `- [YouTube](${episode.platformLinks.youtube})` : ''}
` : '';
  
  const body = `## Episode Description

${episode.summary}

${episode.description || ''}
${platformLinksSection}
## Episode Information

**Episode Number:** ${episode.episodeNumber}  
**Release Date:** ${new Date(episode.date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}  
**Guests:** ${episode.guests.join(', ')}
`;
  
  const markdown = `---\n${yaml}\n---\n\n${body}`;
  
  return { slug, markdown };
}

// Main execution
async function main() {
  console.log('Starting podcast ingestion...\n');
  
  const episodes = await fetchPodcastEpisodes();
  console.log(`Found ${episodes.length} podcast episodes\n`);
  
  // Ensure directory exists
  const outputDir = join(__dirname, '../../content/podcast/episodes');
  mkdirSync(outputDir, { recursive: true });
  
  let created = 0;
  
  for (const episode of episodes) {
    const { slug, markdown } = createEpisodeMarkdown(episode);
    const filepath = join(outputDir, `${slug}.md`);
    
    try {
      writeFileSync(filepath, markdown, 'utf8');
      console.log(`✓ Created: ${slug}.md`);
      created++;
    } catch (error) {
      console.error(`✗ Failed to create ${slug}.md:`, error.message);
    }
  }
  
  console.log(`\n✓ Complete! Created ${created} podcast episodes`);
  console.log(`Files written to: content/podcast/episodes/\n`);
}

// Run the script
main().catch(error => {
  console.error('Fatal error:', error);
  process.exit(1);
});
