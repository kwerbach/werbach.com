import type { ContentItem } from './content';

const SITE_URL = 'https://kevinwerbach.com';
const AUTHOR_NAME = 'Kevin Werbach';

export interface PersonSchema {
  '@context': string;
  '@type': string;
  name: string;
  url: string;
  image?: string;
  jobTitle?: string;
  worksFor?: {
    '@type': string;
    name: string;
  };
  sameAs?: string[];
}

export interface ScholarlyArticleSchema {
  '@context': string;
  '@type': string;
  headline: string;
  author: {
    '@type': string;
    name: string;
  }[];
  datePublished: string;
  description?: string;
  url: string;
  publisher?: {
    '@type': string;
    name: string;
  };
  keywords?: string[];
}

export interface BookSchema {
  '@context': string;
  '@type': string;
  name: string;
  author: {
    '@type': string;
    name: string;
  };
  datePublished?: string;
  description?: string;
  url: string;
  isbn?: string;
  publisher?: {
    '@type': string;
    name: string;
  };
}

export interface PodcastEpisodeSchema {
  '@context': string;
  '@type': string;
  name: string;
  description?: string;
  datePublished: string;
  url: string;
  partOfSeries?: {
    '@type': string;
    name: string;
  };
}

export function generatePersonSchema(): PersonSchema {
  return {
    '@context': 'https://schema.org',
    '@type': 'Person',
    name: AUTHOR_NAME,
    url: SITE_URL,
    jobTitle: 'Professor of Legal Studies and Business Ethics',
    worksFor: {
      '@type': 'Organization',
      name: 'The Wharton School, University of Pennsylvania'
    },
    sameAs: [
      'https://twitter.com/kwerb',
      'https://www.linkedin.com/in/kevinwerbach/'
    ]
  };
}

export function generateScholarlyArticleSchema(item: ContentItem): ScholarlyArticleSchema {
  return {
    '@context': 'https://schema.org',
    '@type': 'ScholarlyArticle',
    headline: item.title,
    author: (item.authors || [AUTHOR_NAME]).map(name => ({
      '@type': 'Person',
      name
    })),
    datePublished: item.date,
    description: item.summary,
    url: `${SITE_URL}/ideas/${item.slug}`,
    publisher: item.publication ? {
      '@type': 'Organization',
      name: item.publication
    } : undefined,
    keywords: [...(item.topics || []), ...(item.tags || [])]
  };
}

export function generateBookSchema(item: ContentItem): BookSchema {
  return {
    '@context': 'https://schema.org',
    '@type': 'Book',
    name: item.title,
    author: {
      '@type': 'Person',
      name: AUTHOR_NAME
    },
    datePublished: item.date,
    description: item.summary,
    url: `${SITE_URL}/books`,
    publisher: item.publication ? {
      '@type': 'Organization',
      name: item.publication
    } : undefined
  };
}

export function generatePodcastEpisodeSchema(item: ContentItem): PodcastEpisodeSchema {
  return {
    '@context': 'https://schema.org',
    '@type': 'PodcastEpisode',
    name: item.title,
    description: item.summary,
    datePublished: item.date,
    url: `${SITE_URL}/podcast/${item.slug}`,
    partOfSeries: {
      '@type': 'PodcastSeries',
      name: 'Kevin Werbach Podcast'
    }
  };
}

export function getSiteUrl(): string {
  return SITE_URL;
}
