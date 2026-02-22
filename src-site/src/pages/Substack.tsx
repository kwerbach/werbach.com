import { Helmet } from 'react-helmet-async';
import { ArrowUpRight } from 'lucide-react';
import PageHero from '../components/PageHero';

const SUBSTACK_URL = 'https://accountableai.substack.com';

export default function Substack() {
  return (
    <>
      <Helmet>
        <title>Substack | Kevin Werbach</title>
        <meta name="description" content="Accountable AI Substack by Kevin Werbach. Newsletter essays, field notes, and frameworks for responsible AI leadership." />
        <link rel="canonical" href="https://kevinwerbach.com/substack" />
        <meta property="og:title" content="Accountable AI Substack" />
        <meta property="og:description" content="Newsletter essays, field notes, and frameworks for responsible AI leadership." />
        <meta property="og:url" content="https://kevinwerbach.com/substack" />
        <meta property="og:type" content="website" />
      </Helmet>
      <div className="bg-black min-h-screen text-white">
      <PageHero
        title="Accountable AI on Substack"
        subtitle="Newsletter essays, field notes, and frameworks for responsible AI leadership."
      />

      <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-12">
        <section className="bg-linear-to-br from-green-600/20 via-green-500/10 to-transparent border border-green-500/30 rounded-2xl p-10 flex flex-col gap-6 lg:flex-row lg:items-center">
          <div className="flex-1 space-y-4">
            <p className="text-lg text-gray-200">
              The Accountable AI Substack brings together regulatory updates, implementation playbooks, and original analysis on
              how organizations can deploy AI responsibly. Subscribers receive deep dives on policy developments, interviews
              with practitioners, and behind-the-scenes insights from the Wharton Accountable AI Lab.
            </p>
            <ul className="grid sm:grid-cols-2 gap-3 text-sm text-beige-700">
              {[
                'Actionable guidance for executives and boards',
                'Breakdowns of emerging AI regulations',
                'Tools for building trustworthy AI programs',
                'Highlights from the Road to Accountable AI podcast',
              ].map(point => (
                <li key={point} className="flex items-start gap-2">
                  <span className="mt-1 h-2 w-2 rounded-full bg-green-400" aria-hidden="true" />
                  <span>{point}</span>
                </li>
              ))}
            </ul>
          </div>
          <div className="flex flex-col items-center gap-4 w-full lg:w-auto">
            <a
              href={SUBSTACK_URL}
              target="_blank"
              rel="noopener noreferrer"
              className="inline-flex items-center justify-center gap-3 w-full lg:w-auto px-8 py-4 text-lg font-semibold rounded-xl bg-green-500 text-black hover:bg-green-400 transition focus:outline-none focus-visible:ring-2 focus-visible:ring-green-300 focus-visible:ring-offset-2 focus-visible:ring-offset-black"
            >
              Subscribe on Substack
              <ArrowUpRight aria-hidden="true" />
            </a>
            <p className="text-sm text-beige-700 text-center">
              Free and paid tiers available. New issues delivered directly to your inbox.
            </p>
          </div>
        </section>
      </div>
    </div>
    </>
  );
}
