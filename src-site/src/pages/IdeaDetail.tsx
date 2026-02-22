import { useParams, Link } from 'react-router-dom';
import { useEffect, useState } from 'react';
import { Helmet } from 'react-helmet-async';
import Prose from '../components/Prose';
import { getContentBySlug } from '../lib/content';
import { markdownToHtml } from '../lib/markdown';
import { generateScholarlyArticleSchema, getSiteUrl } from '../lib/seo';
import type { ContentItem } from '../lib/content';

export default function IdeaDetail() {
  const { slug } = useParams<{ slug: string }>();
  const [idea, setIdea] = useState<ContentItem | null>(null);
  const [htmlContent, setHtmlContent] = useState<string>('');
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string>('');

  const siteUrl = getSiteUrl();

  useEffect(() => {
    async function loadIdea() {
      if (!slug) {
        setError('No slug provided');
        setLoading(false);
        return;
      }

      try {
        // Try to find in papers, essays, or policy
        let content = await getContentBySlug('papers', slug);
        if (!content) content = await getContentBySlug('essays', slug);
        if (!content) content = await getContentBySlug('policy', slug);

        if (!content) {
          setError('Content not found');
          setLoading(false);
          return;
        }

        setIdea(content);
        const html = await markdownToHtml(content.content);
        setHtmlContent(html);
      } catch (err) {
        console.error('Error loading idea:', err);
        setError('Error loading content');
      } finally {
        setLoading(false);
      }
    }

    loadIdea();
  }, [slug]);

  if (loading) {
    return (
      <div className="bg-black min-h-screen text-white">
        <div id="main-content" className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
          <div className="text-center text-beige-700">Loading...</div>
        </div>
      </div>
    );
  }

  if (error || !idea) {
    return (
      <div className="bg-black min-h-screen text-white">
        <div id="main-content" className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
          <div className="text-center text-beige-700">{error || 'Content not found'}</div>
          <div className="text-center mt-4">
            <Link to="/ideas" className="text-citron hover:text-citron-300 transition-colors">
              Back to Ideas
            </Link>
          </div>
        </div>
      </div>
    );
  }

  const canonicalUrl = `${siteUrl}/ideas/${idea.slug}`;
  const articleSchema = generateScholarlyArticleSchema(idea);
  const pageTitle = `${idea.title} - Kevin Werbach`;
  const pageDescription = idea.summary || `Research paper by Kevin Werbach: ${idea.title}`;

  return (
    <>
      <Helmet>
        <title>{pageTitle}</title>
        <meta name="description" content={pageDescription} />
        <link rel="canonical" href={canonicalUrl} />
        <meta property="og:title" content={idea.title} />
        <meta property="og:description" content={pageDescription} />
        <meta property="og:url" content={canonicalUrl} />
        <meta property="og:type" content="article" />
        {idea.date && <meta property="article:published_time" content={idea.date} />}
        {idea.authors && idea.authors.map(author => (
          <meta key={author} property="article:author" content={author} />
        ))}
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:creator" content="@kwerb" />
        <script type="application/ld+json">
          {JSON.stringify(articleSchema)}
        </script>
      </Helmet>
      <div className="bg-black min-h-screen text-white">
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
          <article>
            <header className="mb-12">
              <Link 
                to="/ideas" 
                className="text-citron hover:text-citron-300 mb-6 inline-flex items-center gap-2 text-sm font-medium transition-colors"
              >
                <span>←</span> Back to Ideas
              </Link>
              <h1 className="text-4xl md:text-5xl font-bold mb-6 text-white leading-tight">{idea.title}</h1>
            
            {idea.authors && idea.authors.length > 0 && (
              <p className="text-lg text-beige-700 mb-3">
                {idea.authors.join(', ')}
              </p>
            )}
            
            {idea.publication && (
              <p className="text-beige-700 italic mb-3 text-base">{idea.publication}</p>
            )}
            
            <p className="text-gray-500 mb-6 text-sm">
              {new Date(idea.date).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
              })}
            </p>

            {(idea.topics || idea.tags) && (
              <div className="flex gap-2 mt-6 flex-wrap">
                {[...(idea.topics || []), ...(idea.tags || [])].map((tag) => (
                  <span key={tag} className="px-3 py-1 bg-english_violet-500 text-beige-700 rounded-full text-sm border border-english_violet-300">
                    {tag}
                  </span>
                ))}
              </div>
            )}

            {idea.links && (
              <div className="flex gap-4 mt-8 flex-wrap">
                {idea.links.pdf && (
                  <a 
                    href={idea.links.pdf} 
                    target="_blank" 
                    rel="noopener noreferrer"
                    className="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 focus:ring-offset-black"
                  >
                    📄 PDF
                  </a>
                )}
                {idea.links.ssrn && (
                  <a 
                    href={idea.links.ssrn} 
                    target="_blank" 
                    rel="noopener noreferrer"
                    className="px-4 py-2 bg-english_violet-500 text-white rounded hover:bg-gray-700 font-semibold transition-colors border border-english_violet-300 focus:outline-none focus:ring-2 focus:ring-gray-600 focus:ring-offset-2 focus:ring-offset-black"
                  >
                    SSRN
                  </a>
                )}
                {idea.links.doi && (
                  <a 
                    href={idea.links.doi} 
                    target="_blank" 
                    rel="noopener noreferrer"
                    className="px-4 py-2 bg-english_violet-500 text-white rounded hover:bg-gray-700 font-semibold transition-colors border border-english_violet-300 focus:outline-none focus:ring-2 focus:ring-gray-600 focus:ring-offset-2 focus:ring-offset-black"
                  >
                    DOI
                  </a>
                )}
                {idea.links.external && (
                  <a 
                    href={idea.links.external} 
                    target="_blank" 
                    rel="noopener noreferrer"
                    className="px-4 py-2 bg-english_violet-500 text-white rounded hover:bg-gray-700 font-semibold transition-colors border border-english_violet-300 focus:outline-none focus:ring-2 focus:ring-gray-600 focus:ring-offset-2 focus:ring-offset-black"
                  >
                    External Link
                  </a>
                )}
              </div>
            )}
          </header>
          
          {/* Abstract Section with Enhanced Academic Styling */}
          <div className="mb-16">
            <div className="bg-english_violet-600/50 border border-english_violet-400 rounded-lg p-8 md:p-10">
              <h2 className="text-xl font-semibold uppercase tracking-wide text-beige-700 mb-6 pb-3 border-b border-english_violet-300">
                Abstract
              </h2>
              <Prose className="prose-p:leading-relaxed prose-p:text-justify prose-p:mb-4 prose-headings:font-semibold prose-headings:mt-8 prose-headings:mb-4 prose-headings:text-gray-200 prose-ul:my-4 prose-li:my-2">
                <div dangerouslySetInnerHTML={{ __html: htmlContent }} />
              </Prose>
            </div>
          </div>

          {idea.citation && (
            <div className="mt-12 p-6 md:p-8 bg-english_violet-600/50 border border-english_violet-400 rounded-lg">
              <h3 className="text-xl font-semibold uppercase tracking-wide text-beige-700 mb-4 pb-3 border-b border-english_violet-300">
                Citation
              </h3>
              <p className="text-sm text-beige-700 leading-relaxed font-mono">{idea.citation}</p>
            </div>
          )}
        </article>
      </div>
      </div>
    </>
  );
}
