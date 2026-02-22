import { Helmet } from 'react-helmet-async';
import { motion } from 'framer-motion';

export default function Speaking() {
  return (
    <>
      <Helmet>
        <title>Speaking | Kevin Werbach</title>
        <meta name="description" content="Kevin Werbach is an experienced speaker on emerging technologies, blockchain, gamification, and AI. Available for conferences, corporate events, and executive programs." />
        <link rel="canonical" href="https://kevinwerbach.com/speaking" />
        <meta property="og:title" content="Speaking | Kevin Werbach" />
        <meta property="og:description" content="Kevin Werbach is an experienced speaker on emerging technologies, blockchain, gamification, and AI." />
        <meta property="og:url" content="https://kevinwerbach.com/speaking" />
        <meta property="og:type" content="website" />
      </Helmet>
      <div className="bg-black min-h-screen text-white">
      <div id="main-content" className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <motion.div
          initial={{ opacity: 0, y: 15 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.5 }}
          className="mb-12"
        >
          <div className="rounded-2xl overflow-hidden border border-beige-900/40 shadow-2xl shadow-black/40">
            <div className="aspect-[16/7] relative">
              <div className="absolute inset-0 bg-gradient-to-tr from-black/40 via-transparent to-black/5" />
              <img
                src="/uploads/regtech-24-cropped.png"
                alt="Kevin Werbach speaking at Reg@Tech 2024"
                className="w-full h-full object-cover object-center scale-[1.02]"
                loading="lazy"
              />
            </div>
          </div>
        </motion.div>

        <section className="mb-12">
          <div className="prose prose-lg prose-invert max-w-none mb-8">
            <p className="text-lg text-beige-700 leading-relaxed mb-6">
              I enjoy engaging with audiences around the world on the business, legal, and social implications of emerging technologies. Over the past three decades, I've had the privilege of speaking at conferences, corporate events, academic gatherings, and executive education programs across four continents, from Silicon Valley boardrooms to policy forums in Brussels, Aspen, and Davos; from innovation hubs in Seattle, Singapore, and São Paulo to university lecture halls in Palo Alto and Beijing.
            </p>

            <p className="text-lg text-beige-700 leading-relaxed mb-6">
              My approach combines rigorous academic research with practical insights drawn from my experience as an entrepreneur, government advisor, and consultant. Whether I'm delivering a keynote to thousands at a major industry conference or facilitating an intimate executive workshop, I strive to make complex technological concepts accessible and actionable, helping leaders understand not just what's happening in the tech landscape, but why it matters and what to do about it.
            </p>

            <p className="text-lg text-beige-700 leading-relaxed mb-6">
              I'm actively involved in Wharton Executive Education programs worldwide, working with senior leaders and boards to navigate digital transformation, blockchain adoption, AI governance, and technology policy challenges. These programs bring together diverse perspectives from different industries and regions, creating rich dialogues about how technology is reshaping business and society.
            </p>

            <p className="text-lg text-beige-700 leading-relaxed mb-6">
              My presentations are designed to be thought-provoking and interactive, moving beyond buzzwords and hype to explore the underlying principles and practical implications of technological change. I welcome opportunities to tailor talks to specific industries, organizational challenges, or regional contexts.
            </p>

            <p className="text-lg text-beige-700 leading-relaxed mb-6">
              For speaking inquiries, please visit my speaker bureau,{' '}
              <a
                href="https://sternstrategy.com/speakers/kevin-werbach/"
                target="_blank"
                rel="noopener noreferrer"
                className="text-citron hover:text-citron-300 underline"
              >
                Stern Strategy Group
              </a>
              , to review topics and submit booking requests.
            </p>

            <p className="text-lg text-beige-700 leading-relaxed mb-8">
              In addition to public speaking, I've had the privilege of advising Fortune 500 organizations on technology-related matters through my consulting firm, Supernova Group, and serving as an expert witness in several legal and regulatory matters involving emerging technologies. Please contact me directly at{' '}
              <a
                href="mailto:kevin@werbach.com"
                className="text-citron hover:text-citron-300 underline"
              >
                kevin@werbach.com
              </a>
              {' '}for inquiries in these areas.
            </p>
          </div>

          <h2 className="text-2xl font-bold mb-4 text-white">Speaking Topics</h2>
          <ul className="list-disc list-inside space-y-2 text-beige-700 mb-8">
            <li>AI Governance and Accountability</li>
            <li>Blockchain and the Future of Trust</li>
            <li>Gamification and Behavioral Design</li>
            <li>Technology Policy and Regulation</li>
          </ul>
        </section>
      </div>
    </div>
    </>
  );
}
