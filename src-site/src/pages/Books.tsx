import { useState, useEffect } from 'react';
import { Helmet } from 'react-helmet-async';
import PageHero from '../components/PageHero';
import { getAllContent } from '../lib/content';
import { markdownToHtml } from '../lib/markdown';
import type { ContentItem } from '../lib/content';

export default function Books() {
  const [books, setBooks] = useState<ContentItem[]>([]);
  const [booksHtml, setBooksHtml] = useState<{ [key: string]: string }>({});
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    async function loadBooks() {
      try {
        const items = await getAllContent('books');
        setBooks(items.sort((a, b) => a.title.localeCompare(b.title)));

        // Convert markdown to HTML for each book
        const htmlMap: { [key: string]: string } = {};
        for (const book of items) {
          htmlMap[book.slug] = await markdownToHtml(book.content);
        }
        setBooksHtml(htmlMap);
      } catch (error) {
        console.error('Error loading books:', error);
      } finally {
        setLoading(false);
      }
    }

    loadBooks();
  }, []);

  return (
    <>
      <Helmet>
        <title>Books | Kevin Werbach</title>
        <meta name="description" content="Published books by Kevin Werbach on blockchain, gamification, and emerging technology. Including 'The Blockchain and the New Architecture of Trust' and 'For the Win'." />
        <link rel="canonical" href="https://kevinwerbach.com/books" />
        <meta property="og:title" content="Books | Kevin Werbach" />
        <meta property="og:description" content="Published books by Kevin Werbach on blockchain, gamification, and emerging technology." />
        <meta property="og:url" content="https://kevinwerbach.com/books" />
        <meta property="og:type" content="website" />
      </Helmet>
      <div className="bg-black min-h-screen text-white">
      <PageHero title="Books" subtitle="Published Works" />
      
      <div id="main-content" className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        {loading ? (
          <div className="text-center py-12 text-beige-700">Loading books...</div>
        ) : books.length === 0 ? (
          <div className="text-center py-12 text-beige-700">No books found.</div>
        ) : (
          <div className="space-y-12">
            {books.map((book) => (
              <article key={book.slug} className="border-b border-english_violet-400 pb-12 last:border-b-0">
                <div className="flex flex-col md:flex-row gap-8">
                  {/* Book Cover Image */}
                  {book.coverImage && (
                    <div className="shrink-0">
                      <img 
                        src={book.coverImage} 
                        alt={`Cover of ${book.title}`}
                        loading="lazy"
                        className="w-48 h-auto rounded-lg shadow-xl"
                      />
                    </div>
                  )}
                  
                  {/* Book Content */}
                  <div className="flex-1">
                    <h2 className="text-3xl font-bold mb-4 text-white">{book.title}</h2>
                    
                    {book.year && (
                      <p className="text-beige-700 mb-4">{book.year}</p>
                    )}
                    
                    {book.summary && (
                      <p className="text-xl text-beige-700 mb-6">{book.summary}</p>
                    )}

                    <div 
                      className="prose prose-lg prose-invert prose-headings:text-white prose-p:text-beige-700 prose-strong:text-white prose-em:text-beige-700 prose-li:text-beige-700 mb-6"
                      dangerouslySetInnerHTML={{ __html: booksHtml[book.slug] || '' }}
                    />

                    {/* Buy Links */}
                    {book.buy_links && book.buy_links.length > 0 && (
                      <div className="flex gap-4 flex-wrap">
                        {book.buy_links.map((link) => (
                          <a
                            key={link.store}
                            href={link.url}
                            target="_blank"
                            rel="noopener noreferrer"
                            className="px-4 py-2 bg-teal-500 text-white rounded hover:bg-teal-400 font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 focus:ring-offset-black"
                          >
                            Buy on {link.store}
                          </a>
                        ))}
                      </div>
                    )}
                    
                    {/* Fallback to old links structure */}
                    {book.links && !book.buy_links && (
                      <div className="flex gap-4 flex-wrap">
                        {book.links.external && (
                          <a
                            href={book.links.external}
                            target="_blank"
                            rel="noopener noreferrer"
                            className="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 focus:ring-offset-black"
                          >
                            Buy Now
                          </a>
                        )}
                        {book.links.pdf && (
                          <a
                            href={book.links.pdf}
                            target="_blank"
                            rel="noopener noreferrer"
                            className="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-600 font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-gray-600 focus:ring-offset-2 focus:ring-offset-black"
                          >
                            📄 PDF
                          </a>
                        )}
                      </div>
                    )}
                  </div>
                </div>
              </article>
            ))}
          </div>
        )}
      </div>
    </div>
    </>
  );
}
