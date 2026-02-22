import { useState, useEffect } from 'react';
import { Helmet } from 'react-helmet-async';
import PageHero from '../components/PageHero';
import Card from '../components/Card';
import { getAllContent } from '../lib/content';
import type { ContentItem } from '../lib/content';
import { ExternalLink } from 'lucide-react';

export default function Podcast() {
  const [episodes, setEpisodes] = useState<ContentItem[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    async function loadEpisodes() {
      try {
        const items = await getAllContent('podcast');
        setEpisodes(items.sort((a, b) => new Date(b.date).getTime() - new Date(a.date).getTime()));
      } catch (error) {
        console.error('Error loading podcast episodes:', error);
      } finally {
        setLoading(false);
      }
    }

    loadEpisodes();
  }, []);

  return (
    <>
      <Helmet>
        <title>Podcast | Kevin Werbach</title>
        <meta name="description" content="The Road to Accountable AI podcast hosted by Kevin Werbach. Conversations about responsible AI, governance, and the future of artificial intelligence." />
        <link rel="canonical" href="https://kevinwerbach.com/podcast" />
        <meta property="og:title" content="The Road to Accountable AI Podcast" />
        <meta property="og:description" content="Conversations about responsible AI, governance, and the future of artificial intelligence." />
        <meta property="og:url" content="https://kevinwerbach.com/podcast" />
        <meta property="og:type" content="website" />
      </Helmet>
      <div className="bg-black min-h-screen text-white">
      <PageHero title="Podcast" subtitle="The Road to Accountable AI" />
      
      <div id="main-content" className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        {/* Podcast Artwork Hero Section - Large Image */}
        <section className="mb-12">
          <div className="flex flex-col items-center mb-8">
            <div className="w-full max-w-3xl">
              <img 
                src="https://accountableai.net/wp-content/uploads/2024/04/Accountable-AI-artwork-wide-v3.png"
                alt="The Road to Accountable AI Podcast"
                loading="lazy"
                className="w-full rounded-lg shadow-2xl border-2 border-green-600/30"
              />
            </div>
          </div>
          
          {/* Subscribe Buttons */}
          <div className="bg-english_violet-600 border border-english_violet-400 rounded-lg p-8 mb-8">
            <h2 className="text-2xl font-bold text-white mb-4">Subscribe to the Podcast</h2>
            <p className="text-beige-700 mb-6">
              Get the latest episodes delivered to your favorite podcast app.
            </p>
            <div className="flex flex-wrap gap-4">
              <a
                href="https://podcasts.apple.com/us/podcast/the-road-to-accountable-ai/id1739948118"
                target="_blank"
                rel="noopener noreferrer"
                className="inline-flex items-center gap-2 px-6 py-3 bg-linear-to-r from-purple-600 to-pink-600 text-white font-semibold rounded-lg hover:from-purple-700 hover:to-pink-700 transition-all duration-200 shadow-md hover:shadow-lg"
              >
                <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8z"/>
                  <circle cx="12" cy="12" r="3"/>
                  <path d="M12 6c-3.309 0-6 2.691-6 6s2.691 6 6 6 6-2.691 6-6-2.691-6-6-6zm0 10c-2.206 0-4-1.794-4-4s1.794-4 4-4 4 1.794 4 4-1.794 4-4 4z"/>
                </svg>
                Apple Podcasts
                <ExternalLink size={16} />
              </a>
              
              <a
                href="https://open.spotify.com/show/09CrxWHwEMd6HvvSP0Dxm8"
                target="_blank"
                rel="noopener noreferrer"
                className="inline-flex items-center gap-2 px-6 py-3 bg-[#1DB954] text-white font-semibold rounded-lg hover:bg-[#1ed760] transition-all duration-200 shadow-md hover:shadow-lg"
              >
                <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.779-.179-.899-.539-.12-.421.18-.78.54-.9 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.301 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.54.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.721 1.621.539.3.719 1.02.419 1.56-.299.421-1.02.599-1.559.3z"/>
                </svg>
                Spotify
                <ExternalLink size={16} />
              </a>
              
              <a
                href="https://www.youtube.com/playlist?list=PLjzmu99ZehPw0J7QTdBCTjAlMhy07z73U"
                target="_blank"
                rel="noopener noreferrer"
                className="inline-flex items-center gap-2 px-6 py-3 bg-[#FF0000] text-white font-semibold rounded-lg hover:bg-[#cc0000] transition-all duration-200 shadow-md hover:shadow-lg"
              >
                <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                </svg>
                YouTube
                <ExternalLink size={16} />
              </a>
            </div>
          </div>
        </section>

        {loading ? (
          <div className="text-center py-12 text-beige-700">Loading episodes...</div>
        ) : (
          <div className="space-y-6">
            {episodes.map((episode) => (
              <Card
                key={episode.slug}
                title={episode.title}
                summary={episode.summary || ''}
                link={`/podcast/${episode.slug}`}
                tags={episode.tags || []}
                date={episode.date}
                image={episode.thumbnail}
                className="w-full"
              />
            ))}
          </div>
        )}
      </div>
    </div>
    </>
  );
}
