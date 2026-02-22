import { useParams, Link } from 'react-router-dom';
import { useEffect, useState } from 'react';
import { Helmet } from 'react-helmet-async';
import Prose from '../components/Prose';
import { getContentBySlug } from '../lib/content';
import { markdownToHtml } from '../lib/markdown';
import { generatePodcastEpisodeSchema, getSiteUrl } from '../lib/seo';
import type { ContentItem } from '../lib/content';

export default function PodcastDetail() {
  const { slug } = useParams<{ slug: string }>();
  const [episode, setEpisode] = useState<ContentItem | null>(null);
  const [htmlContent, setHtmlContent] = useState<string>('');
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string>('');

  const siteUrl = getSiteUrl();

  useEffect(() => {
    async function loadEpisode() {
      if (!slug) {
        setError('No slug provided');
        setLoading(false);
        return;
      }

      try {
        const content = await getContentBySlug('podcast', slug);

        if (!content) {
          setError('Episode not found');
          setLoading(false);
          return;
        }

        setEpisode(content);
        const html = await markdownToHtml(content.content);
        setHtmlContent(html);
      } catch (err) {
        console.error('Error loading episode:', err);
        setError('Error loading content');
      } finally {
        setLoading(false);
      }
    }

    loadEpisode();
  }, [slug]);

  if (loading) {
    return (
      <div id="main-content" className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div className="text-center text-gray-500">Loading...</div>
      </div>
    );
  }

  if (error || !episode) {
    return (
      <div id="main-content" className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div className="text-center text-gray-500">{error || 'Episode not found'}</div>
        <div className="text-center mt-4">
          <Link to="/podcast" className="text-blue-600 hover:text-blue-700">
            Back to Podcast
          </Link>
        </div>
      </div>
    );
  }

  const canonicalUrl = `${siteUrl}/podcast/${episode.slug}`;
  const episodeSchema = generatePodcastEpisodeSchema(episode);
  const pageTitle = `${episode.title} - Kevin Werbach Podcast`;
  const pageDescription = episode.summary || `Podcast episode: ${episode.title}`;

  return (
    <>
      <Helmet>
        <title>{pageTitle}</title>
        <meta name="description" content={pageDescription} />
        <link rel="canonical" href={canonicalUrl} />
        <meta property="og:title" content={episode.title} />
        <meta property="og:description" content={pageDescription} />
        <meta property="og:url" content={canonicalUrl} />
        <meta property="og:type" content="article" />
        {episode.date && <meta property="article:published_time" content={episode.date} />}
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:creator" content="@kwerb" />
        <script type="application/ld+json">
          {JSON.stringify(episodeSchema)}
        </script>
      </Helmet>
      <div id="main-content" className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <article>
          <header className="mb-8">
            <Link 
            to="/podcast" 
            className="text-blue-600 hover:text-blue-700 mb-4 inline-block"
          >
            ← Back to Podcast
          </Link>
          <h1 className="text-4xl font-bold mb-4">{episode.title}</h1>
          
          <p className="text-gray-500 mb-4">
            {new Date(episode.date).toLocaleDateString('en-US', {
              year: 'numeric',
              month: 'long',
              day: 'numeric'
            })}
          </p>

          {episode.tags && episode.tags.length > 0 && (
            <div className="flex gap-2 mb-6 flex-wrap">
              {episode.tags.map((tag) => (
                <span key={tag} className="px-3 py-1 bg-gray-100 text-gray-700 rounded text-sm">
                  {tag}
                </span>
              ))}
            </div>
          )}

          {episode.links && (
            <div className="bg-gray-50 p-6 rounded-lg mb-8">
              <h3 className="font-semibold mb-4">Listen on:</h3>
              <div className="flex gap-4 flex-wrap">
                {episode.links.external && (
                  <a 
                    href={episode.links.external} 
                    target="_blank" 
                    rel="noopener noreferrer"
                    className="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-semibold"
                  >
                    🎧 Listen
                  </a>
                )}
              </div>
            </div>
          )}
        </header>
        
        <Prose>
          <div dangerouslySetInnerHTML={{ __html: htmlContent }} />
        </Prose>
      </article>
    </div>
    </>
  );
}
