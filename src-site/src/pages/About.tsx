import { Helmet } from 'react-helmet-async';
import Prose from '../components/Prose';
import { Download } from 'lucide-react';

export default function About() {
  const handleDownloadBio = () => {
    const a = document.createElement('a');
    a.href = '/KW%20mini%20bio.pdf';
    a.download = 'Kevin-Werbach-Bio.pdf';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
  };

  const handleDownloadPhoto = () => {
    const a = document.createElement('a');
    a.href = 'https://knowledge.wharton.upenn.edu/wp-content/uploads/2014/12/Kevin_Werbach_3760_1665-crop-2.jpg';
    a.download = 'Kevin-Werbach-Photo.jpg';
    a.target = '_blank';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
  };

  const handleDownloadCV = () => {
    const a = document.createElement('a');
    a.href = '/Werbach%20CV%202026.pdf';
    a.download = 'Kevin-Werbach-CV-2026.pdf';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
  };

  return (
    <>
      <Helmet>
        <title>About | Kevin Werbach</title>
        <meta name="description" content="Kevin Werbach is a professor at the Wharton School, University of Pennsylvania, specializing in emerging technologies, blockchain, and gamification." />
        <link rel="canonical" href="https://kevinwerbach.com/about" />
        <meta property="og:title" content="About Kevin Werbach" />
        <meta property="og:description" content="Kevin Werbach is a professor at the Wharton School, University of Pennsylvania, specializing in emerging technologies, blockchain, and gamification." />
        <meta property="og:url" content="https://kevinwerbach.com/about" />
        <meta property="og:type" content="profile" />
      </Helmet>
      <div className="bg-black min-h-screen text-white">
      <div id="main-content" className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div className="grid md:grid-cols-3 gap-12 mb-16">
          <div className="md:col-span-1">
            <div className="sticky top-8">
              <div className="rounded-lg shadow-2xl overflow-hidden bg-black">
                <img
                  src="https://knowledge.wharton.upenn.edu/wp-content/uploads/2014/12/Kevin_Werbach_3760_1665-crop-2.jpg"
                  alt="Kevin Werbach, Professor at Wharton School"
                  className="w-full h-auto object-cover object-top"
                  style={{ maxHeight: '600px' }}
                />
              </div>
              <div className="mt-6 text-center">
                <h3 className="text-lg font-semibold text-white mb-1">Kevin Werbach</h3>
                <p className="text-sm text-beige-700">Liem Sioe Liong/First Pacific Company Professor</p>
                <p className="text-sm text-beige-700">Professor of Legal Studies & Business Ethics</p>
                <p className="text-sm text-beige-700">Chairperson, Legal Studies and Business Ethics</p>
                <p className="text-sm text-beige-700">Wharton School, University of Pennsylvania</p>
              </div>
              
              {/* Download Section */}
              <div className="mt-6 space-y-3">
                <button
                  onClick={handleDownloadBio}
                  className="w-full flex items-center justify-center gap-2 px-4 py-3 bg-teal-500 text-white font-semibold rounded-lg hover:bg-teal-400 transition-colors focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 focus:ring-offset-black"
                >
                  <Download size={20} />
                  Download Bio
                </button>
                <button
                  onClick={handleDownloadCV}
                  className="w-full flex items-center justify-center gap-2 px-4 py-3 bg-yellow-500 text-black font-semibold rounded-lg hover:bg-yellow-400 transition-colors focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 focus:ring-offset-black"
                >
                  <Download size={20} />
                  Download CV
                </button>
                <button
                  onClick={handleDownloadPhoto}
                  className="w-full flex items-center justify-center gap-2 px-4 py-3 bg-english_violet-500 text-white font-semibold rounded-lg hover:bg-english_violet-400 transition-colors border border-english_violet-400 focus:outline-none focus:ring-2 focus:ring-english_violet-500 focus:ring-offset-2 focus:ring-offset-black"
                >
                  <Download size={20} />
                  Download Photo
                </button>
              </div>
            </div>
          </div>

          <div className="md:col-span-2">
            <Prose className="space-y-6">
              <p>
                Kevin Werbach has spent three decades exploring significant trends in emerging technology, including legal and ethical aspects of artificial intelligence; regulatory and financial implications of blockchain and digital assets; application of digital game design principles to business; and the evolving societal impacts of the internet. He is currently the Liem Sioe Liong/First Pacific Company Professor and Chair of the Department of Legal Studies and Business Ethics at the Wharton School of the University of Pennsylvania, where he directs both the Wharton Accountable AI Lab and the Wharton Blockchain and Digital Asset Project.
              </p>
              <p>
                Werbach served on the Obama Administration's Presidential Transition Team, has been an advisor to multiple US federal agencies, and has testified before both houses of the U.S. Congress. He founded the Supernova Group, a technology consulting firm, which organized the CEO-level Supernova technology conference for nine years. He is regularly quoted and featured in major media outlets including The New York Times, Wall Street Journal, Financial Times, Bloomberg, Forbes, The Economist, Wired, and TechCrunch. He has appeared on television networks including CNN, CNBC, CBS, and Bloomberg TV as an expert commentator on technology policy and business strategy.
              </p>
              <p>
                He has published dozens of scholarly and popular articles and five books, including The Blockchain and the New Architecture of Trust, For the Win: The Power of Gamification and Game Thinking in Business, Education, Government, and Social Impact, the forthcoming Foundations of Decentralized Organizations, and After the Digital Tornado: Networks, Algorithms, Humanity. He is the host of the podcast The Road to Accountable AI, co-chair of the World Economic Forum's Global Futures Council on Decentralized Finance, and academic director of Wharton's executive education program, Strategies for Accountable AI. He created one of the most successful massive open online courses, with nearly half a million enrollments, and he was named Wharton's first-ever Iron Prof in 2010.
              </p>
              <p>
                Werbach has long been an influential thinker on how the decentralizing forces of the internet and related technologies transform both society and business, calling for new approaches in governance, law, and strategy. Prior to joining Wharton, he edited the influential technology newsletter Release 1.0, and co-organized the seminal technology conference PC Forum with Esther Dyson. Earlier, helped develop the U.S. Government's widely-praised Internet policies in the Clinton Administration, as Counsel for New Technology Policy at the Federal Communications Commission and a member of the White House Working Group on E-Commerce.
              </p>
              <p>
                He received his JD, magna cum laude, from Harvard Law School, where he was Publishing Editor of the Harvard Law Review, and his undergraduate degree, summa cum laude, from the University of California, Berkeley.
              </p>
            </Prose>
          </div>
        </div>
      </div>
    </div>
    </>
  );
}
