import { Helmet } from 'react-helmet-async';
import { Mail, ExternalLink } from 'lucide-react';

export default function Contact() {
  return (
    <>
      <Helmet>
        <title>Contact | Kevin Werbach</title>
        <meta name="description" content="Get in touch with Kevin Werbach. Contact information, social media links, and speaking inquiries." />
        <link rel="canonical" href="https://kevinwerbach.com/contact" />
        <meta property="og:title" content="Contact Kevin Werbach" />
        <meta property="og:description" content="Get in touch with Kevin Werbach. Contact information, social media links, and speaking inquiries." />
        <meta property="og:url" content="https://kevinwerbach.com/contact" />
        <meta property="og:type" content="website" />
      </Helmet>
      <div className="bg-black min-h-screen text-white">
        <div id="main-content" className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
          {/* Primary Contact - Email */}
          <section className="mb-12">
            <a
              href="mailto:kevin@werbach.com"
              className="group block bg-gradient-to-br from-citron/20 via-english_violet-600/30 to-black border border-citron/30 rounded-2xl p-8 hover:border-citron/60 transition-all duration-300 hover:-translate-y-1"
            >
              <div className="flex items-center gap-4 mb-3">
                <div className="p-3 bg-citron/20 rounded-xl group-hover:bg-citron/30 transition-colors">
                  <Mail className="w-6 h-6 text-citron" />
                </div>
                <h2 className="text-2xl font-bold text-white">Email</h2>
              </div>
              <p className="text-lg text-beige-300 group-hover:text-citron transition-colors">
                kevin@werbach.com
              </p>
            </a>
          </section>

          {/* Podcast & Newsletter */}
          <section className="mb-12">
            <h2 className="text-lg font-semibold text-beige-700 uppercase tracking-wide mb-6">Subscribe</h2>
            <div className="grid md:grid-cols-2 gap-6">
              {/* Podcast */}
              <div className="bg-gradient-to-br from-teal/20 via-english_violet-600/30 to-black border border-teal/30 rounded-2xl p-6">
                <div className="flex items-center gap-3 mb-4">
                  <div className="p-2.5 bg-teal/20 rounded-xl">
                    <svg className="w-5 h-5 text-teal" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                  </div>
                  <h3 className="text-xl font-bold text-white">Podcast</h3>
                </div>
                <p className="text-beige-400 mb-5 text-sm">The Road to Accountable AI</p>
                <div className="flex flex-wrap gap-3">
                  <a
                    href="https://podcasts.apple.com/us/podcast/the-road-to-accountable-ai/id1739948118"
                    target="_blank"
                    rel="noopener noreferrer"
                    className="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/10 hover:bg-teal/30 rounded-lg text-sm text-beige-300 hover:text-white transition-colors"
                  >
                    Apple <ExternalLink size={12} />
                  </a>
                  <a
                    href="https://open.spotify.com/show/09CrxWHwEMd6HvvSP0Dxm8"
                    target="_blank"
                    rel="noopener noreferrer"
                    className="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/10 hover:bg-teal/30 rounded-lg text-sm text-beige-300 hover:text-white transition-colors"
                  >
                    Spotify <ExternalLink size={12} />
                  </a>
                  <a
                    href="https://www.youtube.com/playlist?list=PLjzmu99ZehPw0J7QTdBCTjAlMhy07z73U"
                    target="_blank"
                    rel="noopener noreferrer"
                    className="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/10 hover:bg-teal/30 rounded-lg text-sm text-beige-300 hover:text-white transition-colors"
                  >
                    YouTube <ExternalLink size={12} />
                  </a>
                </div>
              </div>

              {/* Newsletter */}
              <a
                href="https://accountableai.substack.com"
                target="_blank"
                rel="noopener noreferrer"
                className="group bg-gradient-to-br from-green-500/20 via-english_violet-600/30 to-black border border-green-500/30 rounded-2xl p-6 hover:border-green-500/60 transition-all duration-300"
              >
                <div className="flex items-center gap-3 mb-4">
                  <div className="p-2.5 bg-green-500/20 rounded-xl group-hover:bg-green-500/30 transition-colors">
                    <svg className="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M22.539 8.242H1.46V5.406h21.08v2.836zM1.46 10.812V24L12 18.11 22.54 24V10.812H1.46zM22.54 0H1.46v2.836h21.08V0z"/>
                    </svg>
                  </div>
                  <h3 className="text-xl font-bold text-white">Newsletter</h3>
                </div>
                <p className="text-beige-400 mb-2 text-sm">Accountable AI on Substack</p>
                <p className="text-beige-300 group-hover:text-green-400 transition-colors text-sm flex items-center gap-1.5">
                  Subscribe <ExternalLink size={12} />
                </p>
              </a>
            </div>
          </section>

          {/* Social Links */}
          <section>
            <h2 className="text-lg font-semibold text-beige-700 uppercase tracking-wide mb-6">Social</h2>
            <div className="grid grid-cols-1 sm:grid-cols-3 gap-4">
              {/* LinkedIn */}
              <a
                href="https://www.linkedin.com/in/kevinwerbach/"
                target="_blank"
                rel="noopener noreferrer"
                className="group flex items-center gap-4 bg-gradient-to-br from-[#0A66C2]/30 via-english_violet-600/30 to-black border border-[#0A66C2]/30 rounded-xl p-4 hover:border-[#0A66C2]/60 transition-all duration-300"
              >
                <div className="p-2 bg-[#0A66C2]/20 rounded-lg group-hover:bg-[#0A66C2]/30 transition-colors">
                  <svg className="w-5 h-5 text-[#0A66C2]" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                  </svg>
                </div>
                <div>
                  <p className="font-semibold text-white">LinkedIn</p>
                  <p className="text-sm text-beige-400 group-hover:text-[#0A66C2] transition-colors">kevinwerbach</p>
                </div>
              </a>

              {/* X (Twitter) */}
              <a
                href="https://x.com/kwerb"
                target="_blank"
                rel="noopener noreferrer"
                className="group flex items-center gap-4 bg-gradient-to-br from-gray-400/30 via-english_violet-600/30 to-black border border-gray-400/30 rounded-xl p-4 hover:border-white/60 transition-all duration-300"
              >
                <div className="p-2 bg-white/10 rounded-lg group-hover:bg-white/20 transition-colors">
                  <svg className="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                  </svg>
                </div>
                <div>
                  <p className="font-semibold text-white">X</p>
                  <p className="text-sm text-beige-400 group-hover:text-white transition-colors">@kwerb</p>
                </div>
              </a>

              {/* Bluesky */}
              <a
                href="https://bsky.app/profile/kwerb.com"
                target="_blank"
                rel="noopener noreferrer"
                className="group flex items-center gap-4 bg-gradient-to-br from-[#0085FF]/30 via-english_violet-600/30 to-black border border-[#0085FF]/30 rounded-xl p-4 hover:border-[#0085FF]/60 transition-all duration-300"
              >
                <div className="p-2 bg-[#0085FF]/20 rounded-lg group-hover:bg-[#0085FF]/30 transition-colors">
                  <svg className="w-5 h-5 text-[#0085FF]" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 10.8c-1.087-2.114-4.046-6.053-6.798-7.995C2.566.944 1.561 1.266.902 1.565.139 1.908 0 3.08 0 3.768c0 .69.378 5.65.624 6.479.815 2.736 3.713 3.66 6.383 3.364.136-.02.275-.039.415-.056-.138.022-.276.04-.415.056-3.912.58-7.387 2.005-2.83 7.078 5.013 5.19 6.87-1.113 7.823-4.308.953 3.195 2.05 9.271 7.733 4.308 4.267-4.308 1.172-6.498-2.74-7.078a8.741 8.741 0 0 1-.415-.056c.14.017.279.036.415.056 2.67.297 5.568-.628 6.383-3.364.246-.828.624-5.79.624-6.478 0-.69-.139-1.861-.902-2.206-.659-.298-1.664-.62-4.3 1.24C16.046 4.748 13.087 8.687 12 10.8Z"/>
                  </svg>
                </div>
                <div>
                  <p className="font-semibold text-white">Bluesky</p>
                  <p className="text-sm text-beige-400 group-hover:text-[#0085FF] transition-colors">@kwerb.com</p>
                </div>
              </a>
            </div>
          </section>
        </div>
      </div>
    </>
  );
}
