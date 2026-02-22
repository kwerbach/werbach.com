import { Helmet } from 'react-helmet-async';
import { Play, ExternalLink } from 'lucide-react';

const mediaItems = [
  {
    id: 1,
    type: 'video',
    title: 'The Blockchain and the New Architecture of Trust',
    platform: 'Talks at Google',
    date: 'May 8, 2019',
    url: 'https://www.youtube.com/watch?v=F4VvoVu0wiw',
    color: '#F59E0B',
    sortDate: '2019-05-08'
  },
  {
    id: 10,
    type: 'video',
    title: 'AI regulation is tech regulation',
    platform: 'Knowledge@Wharton',
    date: 'December 17, 2024',
    url: 'https://www.youtube.com/watch?v=q-xAXeTeI_E',
    color: '#0EA5E9',
    sortDate: '2024-12-17'
  },
  {
    id: 11,
    type: 'video',
    title: 'Why Accountability Matters in AI Development and Governance',
    platform: 'Knowledge@Wharton',
    date: 'February 11, 2025',
    url: 'https://www.youtube.com/watch?v=9wHciZemrkM',
    color: '#A855F7',
    sortDate: '2025-02-11'
  },
  {
    id: 13,
    type: 'video',
    title: 'The Future of AI Regulation: Protecting Children in the Age of AI',
    platform: 'Knowledge@Wharton',
    date: 'November 30, 2025',
    url: 'https://www.youtube.com/watch?v=FQnAjD82VXY',
    color: '#10B981',
    sortDate: '2025-11-30'
  },
  {
    id: 15,
    type: 'video',
    title: 'Understanding Bitcoin, Smart Contracts and NFTs',
    platform: 'Game Thinking TV',
    date: 'February 4, 2022',
    url: 'https://www.youtube.com/watch?v=-FfnzGPIJ7I',
    color: '#EAB308',
    sortDate: '2022-02-04'
  },
  {
    id: 17,
    type: 'video',
    title: 'How blockchain will impact business',
    platform: 'Knowdeon',
    date: 'June 11, 2019',
    url: 'https://www.youtube.com/watch?v=I4y_rfel-2Q',
    color: '#84CC16',
    sortDate: '2019-06-11'
  },
  {
    id: 6,
    type: 'video',
    title: 'Teaching Gamification: Lessons from MOOCs',
    platform: 'GSummit 2013',
    date: '2013',
    url: 'https://www.youtube.com/watch?v=SHo_kh_txO0',
    color: '#EC4899',
    sortDate: '2013-06-01'
  },
  {
    id: 3,
    type: 'article',
    title: "Technology vs. Trust: Why This Wharton Professor Thinks Blockchain's Time Is Yet to Come",
    platform: 'Philadelphia Inquirer',
    date: 'March 11, 2019',
    url: 'https://www.inquirer.com/business/weed/blockchain-kevin-werbach-wharton-school-mit-press-20190311.html',
    color: '#06B6D4',
    sortDate: '2019-03-11'
  },
  {
    id: 7,
    type: 'article',
    title: 'Blockchain: A Novel Solution to the Problem of Trust',
    platform: 'Philadelphia Inquirer',
    date: 'October 19, 2018',
    url: 'https://www.inquirer.com/philly/blogs/inq-phillydeals/Blockchain-.html',
    color: '#8B5CF6',
    sortDate: '2018-10-19'
  },
  {
    id: 9,
    type: 'article',
    title: "UPenn Professor's Accountable AI Class",
    platform: 'Philadelphia Inquirer',
    date: 'June 11, 2024',
    url: 'https://www.inquirer.com/business/accountable-artificial-intelligence-upenn-class-20240611.html',
    color: '#14B8A6',
    sortDate: '2024-06-11'
  },
  {
    id: 18,
    type: 'video',
    title: 'Can We Trust the Blockchain',
    platform: 'SIEPR',
    date: 'May 30, 2019',
    url: 'https://www.youtube.com/watch?v=gIaItUvF4ZE',
    color: '#F59E0B',
    sortDate: '2019-05-30'
  },
  {
    id: 19,
    type: 'video',
    title: 'Learning from Games for Gamified Learning',
    platform: 'Gamification World Congress',
    date: 'June 13, 2016',
    url: 'https://www.youtube.com/watch?v=RD489AUivDw',
    color: '#06B6D4',
    sortDate: '2016-06-13'
  },
  {
    id: 20,
    type: 'video',
    title: 'Trustless Trust?',
    platform: 'London School of Economics',
    date: 'April 16, 2019',
    url: 'https://www.youtube.com/watch?v=Uj342yXUkCc',
    color: '#8B5CF6',
    sortDate: '2019-04-16'
  },
  {
    id: 21,
    type: 'video',
    title: 'Notes on the State of CryptoGov',
    platform: 'MIT Cryptoeconomic Systems Summit',
    date: 'October 15, 2019',
    url: 'https://www.youtube.com/watch?v=jlQFqQjtrnY',
    color: '#10B981',
    sortDate: '2019-10-15'
  },
  {
    id: 22,
    type: 'video',
    title: 'Big Data, Big Responsibilities',
    platform: 'McGowan Fund Symposium',
    date: 'November 17, 2016',
    url: 'https://www.youtube.com/watch?v=Wq_yK8gUCpg',
    color: '#EC4899',
    sortDate: '2016-11-17'
  },
  {
    id: 23,
    type: 'video',
    title: 'The Siren Song: Algorithmic Governance By Blockchain',
    platform: 'Center for Governance and Markets',
    date: 'October 8, 2020',
    url: 'https://www.youtube.com/watch?v=KfORZ0FOuJY',
    color: '#A855F7',
    sortDate: '2020-10-08'
  },
  {
    id: 24,
    type: 'video',
    title: 'The Power of Game Thinking',
    platform: 'Socialize!',
    date: 'June 2014',
    url: 'https://www.youtube.com/watch?v=pgWgbF67V_c',
    color: '#EAB308',
    sortDate: '2014-06-01'
  },
  {
    id: 25,
    type: 'video',
    title: "Regulating Social Media in Wake of London's Recent Terror Attacks",
    platform: 'CNBC',
    date: 'June 5, 2017',
    url: 'https://www.cnbc.com/video/2017/06/05/regulating-social-media-in-wake-of-londons-recent-terror-attacks.html',
    color: '#0EA5E9',
    sortDate: '2017-06-05'
  },
  {
    id: 26,
    type: 'video',
    title: 'FCC Ruling: What Does it Mean for Consumers?',
    platform: 'WSJ Video',
    date: 'February 26, 2015',
    url: 'https://www.wsj.com/video/fcc-ruling-what-does-it-mean-for-consumers/0F61E493-8782-4BA6-A422-A9FC99F27E4C',
    color: '#84CC16',
    sortDate: '2015-02-26'
  },
  {
    id: 27,
    type: 'video',
    title: 'The Communicators',
    platform: 'CSPAN',
    date: 'June 10, 2014',
    url: 'https://www.c-span.org/clip/the-communicators/communicators-with-kevin-werbach/4504611',
    color: '#14B8A6',
    sortDate: '2014-06-10'
  },
  {
    id: 28,
    type: 'video',
    title: 'Professor Kevin Werbach on Gamification',
    platform: 'Wharton Lifelong Learning Tour',
    date: 'November 12, 2012',
    url: 'https://www.youtube.com/watch?v=-jfgxt4AZIc',
    color: '#F59E0B',
    sortDate: '2012-11-12'
  }
].sort((a, b) => {
  const dateA = new Date(a.sortDate || a.date).getTime();
  const dateB = new Date(b.sortDate || b.date).getTime();
  return dateB - dateA;
});

export default function Media() {
  return (
    <div className="bg-black min-h-screen text-white">
      <Helmet>
        <title>Kevin Werbach | In The Media</title>
        <meta
          name="description"
          content="Professor of Legal Studies & Business Ethics at The Wharton School. Media appearances on Bloomberg, CNBC, C-SPAN, and more."
        />
      </Helmet>

      <div id="main-content" className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 auto-rows-auto">
          {mediaItems.map((item) => (
            <a
              key={item.id}
              href={item.url}
              target="_blank"
              rel="noopener noreferrer"
              className="group"
            >
              <div className="relative bg-gradient-to-br from-[var(--card-color)]/85 via-[#443850]/80 to-black rounded-2xl p-6 shadow-lg shadow-[var(--card-color)]/70 transition-all duration-300 hover:shadow-2xl hover:shadow-[var(--card-color)]/95 hover:-translate-y-1 hover:scale-[1.02] min-h-[200px] flex flex-col justify-between"
                style={{ '--card-color': item.color } as React.CSSProperties}
              >
                <div className="absolute inset-0 bg-gradient-to-br from-[var(--card-color)]/90 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-2xl"
                  style={{ '--card-color': item.color } as React.CSSProperties}
                />

                <div className="relative">
                  {/* Type Badge */}
                  <div className="mb-4">
                    <div className="inline-flex items-center gap-2 px-3 py-1 bg-white/10 rounded-lg">
                      {item.type === 'video' ? (
                        <Play size={16} className="text-white" />
                      ) : (
                        <ExternalLink size={16} className="text-white" />
                      )}
                      <span className="text-xs font-semibold uppercase tracking-wide">
                        {item.type}
                      </span>
                    </div>
                  </div>

                  {/* Title */}
                  <h3 className="text-lg font-bold leading-tight text-white mb-4">
                    {item.title}
                  </h3>

                  {/* Platform and Date */}
                  <div className="text-sm text-beige-300">
                    <p className="font-semibold">{item.platform}</p>
                    <p className="text-beige-400">{item.date}</p>
                  </div>
                </div>
              </div>
            </a>
          ))}
        </div>
      </div>
    </div>
  );
}
