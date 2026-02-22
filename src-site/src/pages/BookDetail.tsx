import { useParams, Link } from 'react-router-dom';
import { useEffect, useState } from 'react';
import { Helmet } from 'react-helmet-async';
import Prose from '../components/Prose';
import { getContentBySlug } from '../lib/content';
import { markdownToHtml } from '../lib/markdown';
import { generateBookSchema, getSiteUrl } from '../lib/seo';
import type { ContentItem } from '../lib/content';

export default function BookDetail() {
  const { slug } = useParams<{ slug: string }>();
  const [book, setBook] = useState<ContentItem | null>(null);
  const [htmlContent, setHtmlContent] = useState<string>('');
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string>('');

  const siteUrl = getSiteUrl();

  useEffect(() => {
    async function loadBook() {
      if (!slug) {
        setError('No slug provided');
        setLoading(false);
        return;
      }

      try {
        const content = await getContentBySlug('books', slug);

        if (!content) {
          setError('Book not found');
          setLoading(false);
          return;
        }

        setBook(content);
        const html = await markdownToHtml(content.content);
        setHtmlContent(html);
      } catch (err) {
        console.error('Error loading book:', err);
        setError('Error loading content');
      } finally {
        setLoading(false);
      }
    }

    loadBook();
  }, [slug]);

  if (loading) {
    return (
      <div className="bg-black min-h-screen text-white">
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
          <div className="text-center text-beige-700">Loading...</div>
        </div>
      </div>
    );
  }

  if (error || !book) {
    return (
      <div className="bg-black min-h-screen text-white">
        <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
          <div className="text-center text-beige-700">{error || 'Book not found'}</div>
          <div className="text-center mt-4">
            <Link to="/ideas" className="text-citron hover:text-citron-300 transition-colors">
              Back to Ideas
            </Link>
          </div>
        </div>
      </div>
    );
  }

  const canonicalUrl = `${siteUrl}/ideas/books/${book.slug}`;
  const bookSchema = generateBookSchema(book);
  const pageTitle = `${book.title} - Kevin Werbach`;
  const pageDescription = book.summary || `Book by Kevin Werbach: ${book.title}`;
  const amazonLink = book.buy_links?.find(link => link.store === 'Amazon')?.url;

  return (
    <>
      <Helmet>
        <title>{pageTitle}</title>
        <meta name="description" content={pageDescription} />
        <link rel="canonical" href={canonicalUrl} />
        <meta property="og:title" content={book.title} />
        <meta property="og:description" content={pageDescription} />
        <meta property="og:url" content={canonicalUrl} />
        <meta property="og:type" content="book" />
        {book.coverImage && <meta property="og:image" content={book.coverImage} />}
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:creator" content="@kwerb" />
        <script type="application/ld+json">
          {JSON.stringify(bookSchema)}
        </script>
      </Helmet>
      <div className="bg-black min-h-screen text-white">
        <div id="main-content" className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
          <article>
            <Link 
              to="/ideas" 
              className="text-citron hover:text-citron-300 mb-6 inline-flex items-center gap-2 text-sm font-medium transition-colors"
            >
              <span>←</span> Back to Ideas
            </Link>

            <div className="grid md:grid-cols-3 gap-12 mt-6">
              {/* Book Cover and Buy Links */}
              <div className="md:col-span-1">
                <div className="sticky top-8">
                  {book.coverImage ? (
                    <img 
                      src={book.coverImage} 
                      alt={`Cover of ${book.title}`}
                      loading="lazy"
                      className="w-full rounded-lg shadow-2xl mb-6"
                    />
                  ) : (
                    <div className="aspect-2/3 bg-english_violet-500 rounded-lg flex items-center justify-center mb-6">
                      <div className="text-center p-8">
                        <div className="text-6xl mb-4">📖</div>
                        <h3 className="text-lg font-bold text-white">
                          {book.title}
                        </h3>
                      </div>
                    </div>
                  )}
                  
                  {book.publisher && (
                    <p className="text-beige-700 mb-2">
                      <span className="font-semibold text-white">Publisher:</span> {book.publisher}
                    </p>
                  )}
                  
                  {book.year && (
                    <p className="text-beige-700 mb-6">
                      <span className="font-semibold text-white">Year:</span> {book.year}
                    </p>
                  )}

                  {/* Buy Links */}
                  {book.buy_links && book.buy_links.length > 0 && (
                    <div className="space-y-3">
                      {amazonLink && (
                        <a
                          href={amazonLink}
                          target="_blank"
                          rel="noopener noreferrer"
                          className="flex items-center justify-center gap-2 w-full px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 focus:ring-offset-black"
                        >
                          <span>📚</span>
                          Buy on Amazon
                        </a>
                      )}
                      {book.buy_links.filter(link => link.store !== 'Amazon').map((link) => (
                        <a
                          key={link.store}
                          href={link.url}
                          target="_blank"
                          rel="noopener noreferrer"
                          className="flex items-center justify-center gap-2 w-full px-4 py-3 bg-english_violet-500 text-white rounded-lg hover:bg-gray-700 font-semibold transition-colors border border-english_violet-300 focus:outline-none focus:ring-2 focus:ring-gray-600 focus:ring-offset-2 focus:ring-offset-black"
                        >
                          {link.store}
                        </a>
                      ))}
                    </div>
                  )}
                </div>
              </div>

              {/* Book Content */}
              <div className="md:col-span-2">
                <header className="mb-8">
                  <h1 className="text-4xl md:text-5xl font-bold mb-4 text-white leading-tight">
                    {book.title}
                  </h1>
                  
                  {book.summary && (
                    <p className="text-xl text-beige-700 mb-6 leading-relaxed">
                      {book.summary}
                    </p>
                  )}

                  {(book.topics || book.tags) && (
                    <div className="flex gap-2 flex-wrap">
                      {[...(book.topics || []), ...(book.tags || [])].map((tag) => (
                        <span 
                          key={tag} 
                          className="px-3 py-1 bg-english_violet-500 text-beige-700 rounded-full text-sm border border-english_violet-300"
                        >
                          {tag}
                        </span>
                      ))}
                    </div>
                  )}
                </header>
                
                <div className="border-l-4 border-green-600 pl-6 py-4 bg-english_violet-600 rounded-r-lg">
                  <Prose>
                    <div dangerouslySetInnerHTML={{ __html: htmlContent }} />
                  </Prose>
                </div>
              </div>
            </div>
          </article>
        </div>
      </div>
    </>
  );
}
