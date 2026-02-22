export interface PressAppearance {
  date: string; // YYYY-MM-DD
  title: string;
  outlet: string;
  type: string; // Article | Podcast | Video | Interview | TV Appearance
  url: string;
}

// Raw list derived from provided CSV attachment (2010-2025)
export const pressAppearances: PressAppearance[] = [
  { date: '2025-09-23', title: 'Operationalize AI Accountability: A Leadership Playbook', outlet: 'Knowledge at Wharton', type: 'Article', url: 'https://knowledge.wharton.upenn.edu/article/operationalize-ai-accountability-a-leadership-playbook/' },
  { date: '2025-02-12', title: 'An Honest Accounting of AI', outlet: 'The Philadelphia Citizen', type: 'Article', url: 'https://thephiladelphiacitizen.org/an-honest-accounting-of-ai/' },
  { date: '2025-02-07', title: 'Why Accountability Matters in AI Development and Governance', outlet: 'Knowledge at Wharton Podcast', type: 'Podcast', url: 'https://knowledge.wharton.upenn.edu/podcast/knowledge-at-wharton-podcast/why-accountability-matters-in-ai-development-and-governance/' },
  { date: '2025-01-21', title: 'Cryptocurrency and Blockchains | Kevin Werbach', outlet: 'Knowledge at Wharton (Ripple Effect)', type: 'Podcast', url: 'https://knowledge.wharton.upenn.edu/podcast/ripple-effect/cryptocurrency-and-blockchains-kevin-werbach/' },
  { date: '2024-12-17', title: 'Even Under Trump, AI Governance Is Here to Stay', outlet: 'Knowledge at Wharton', type: 'Article', url: 'https://knowledge.wharton.upenn.edu/article/even-under-trump-ai-governance-is-here-to-stay/' },
  { date: '2024-12-10', title: 'Regulating AI: Getting the Balance Right', outlet: 'Knowledge at Wharton (Policies That Work)', type: 'Article', url: 'https://knowledge.wharton.upenn.edu/article/regulating-ai-getting-the-balance-right/' },
  { date: '2024-11-15', title: 'AI regulation is tech regulation', outlet: 'Knowledge at Wharton (YouTube Short)', type: 'Video', url: 'https://www.youtube.com/shorts/q-xAXeTeI_E' },
  { date: '2024-04-29', title: 'Wharton professor launches podcast focusing on artificial intelligence', outlet: 'The Daily Pennsylvanian', type: 'Article', url: 'https://www.thedp.com/article/2024/04/werbach-wharton-podcast-artificial-intelligence' },
  { date: '2023-02-21', title: 'How DAOs Could Bring Organizational Trust and Transparency', outlet: 'Knowledge at Wharton (This Week in Business)', type: 'Podcast', url: 'https://knowledge.wharton.upenn.edu/podcast/this-week-in-business/how-daos-could-bring-organizational-trust-and-transparency/' },
  { date: '2022-03-28', title: 'Why the U.S. Government Should Regulate Cryptocurrency', outlet: 'Knowledge at Wharton Podcast', type: 'Podcast', url: 'https://knowledge.wharton.upenn.edu/podcast/knowledge-at-wharton-podcast/why-the-u-s-government-should-regulate-cryptocurrency/' },
  { date: '2022-03-16', title: 'A Conversation on the Future of Gaming and Play', outlet: 'Wharton Global Youth', type: 'Article', url: 'https://globalyouth.wharton.upenn.edu/articles/future-of-the-business-world/kevin-werbach-future-gaming-play/' },
  { date: '2021-06-10', title: 'The Opportunities and Dangers of Decentralizing Finance', outlet: 'Knowledge at Wharton', type: 'Article', url: 'https://knowledge.wharton.upenn.edu/article/opportunities-dangers-decentralizing-finance/' },
  { date: '2020-06-15', title: 'Interview with Professor Kevin Werbach for Blockchain Rules Podcast Series', outlet: 'UCL Centre for Blockchain Technologies (Medium)', type: 'Interview', url: 'https://medium.com/uclcbt/interview-with-professor-kevin-werbach-for-blockchain-rules-podcast-series-7b183c22462b' },
  { date: '2019-05-30', title: 'Can We Trust the Blockchain?', outlet: 'Stanford SIEPR (YouTube)', type: 'Video', url: 'https://www.youtube.com/watch?v=gIaItUvF4ZE' },
  { date: '2019-01-14', title: 'Why the Blockchain Ushers in a New Form of Trust', outlet: 'Knowledge at Wharton Podcast', type: 'Podcast', url: 'https://knowledge.wharton.upenn.edu/podcast/knowledge-at-wharton-podcast/werbach-blockchain/' },
  { date: '2018-12-20', title: 'After the Blockchain Bubble, Part Two', outlet: 'Knowledge at Wharton (This Week in Business)', type: 'Podcast', url: 'https://knowledge.wharton.upenn.edu/podcast/this-week-in-business/after-blockchain-bubble-part-two/' },
  { date: '2018-11-30', title: 'The Blockchain and The New Architecture of Trust', outlet: 'Talks at Google (YouTube)', type: 'Video', url: 'https://www.youtube.com/watch?v=F4VvoVu0wiw' },
  { date: '2018-11-16', title: 'How the Blockchain Will Impact the Financial Sector', outlet: 'Knowledge at Wharton', type: 'Article', url: 'https://knowledge.wharton.upenn.edu/article/blockchain-will-impact-financial-sector/' },
  { date: '2018-06-20', title: 'Why Blockchain Isn’t a Revolution', outlet: 'Knowledge at Wharton', type: 'Article', url: 'https://knowledge.wharton.upenn.edu/article/blockchain-isnt-revolution/' },
  { date: '2017-12-19', title: 'Internet Policy 20 Years Later: Did the U.S. Get It Right?', outlet: 'Knowledge at Wharton', type: 'Article', url: 'https://knowledge.wharton.upenn.edu/article/internet-policy-20-years-later-u-s-get-right/' },
  { date: '2017-06-05', title: "Regulating social media in wake of London's recent terror attacks", outlet: 'CNBC (via Werbach.com videos)', type: 'TV Appearance', url: 'https://werbach.com/videos.html' },
  { date: '2017-03-03', title: "The FCC Helped Make the Internet Great: Now, It’s Walking Away", outlet: 'Knowledge at Wharton', type: 'Article', url: 'https://knowledge.wharton.upenn.edu/article/fcc-helped-make-internet-great-now-walking-away/' },
  { date: '2017-02-03', title: 'How to Regulate Innovation — Without Killing It', outlet: 'Knowledge at Wharton', type: 'Article', url: 'https://knowledge.wharton.upenn.edu/article/how-to-regulate-innovation-without-killing-it/' },
  { date: '2015-06-26', title: 'How Gamification ‘Taps into What Makes Us Human’', outlet: 'Knowledge at Wharton', type: 'Article', url: 'https://knowledge.wharton.upenn.edu/article/how-gamification-taps-into-what-makes-us-human/' },
  { date: '2015-02-26', title: 'What Does Net Neutrality Mean for Consumers?', outlet: 'Wall Street Journal Live (via Werbach.com videos)', type: 'TV Appearance', url: 'https://werbach.com/videos.html' },
  { date: '2014-07-23', title: 'Communicators with Kevin Werbach: FCC Open Internet Policy', outlet: 'C-SPAN', type: 'TV Appearance', url: 'https://www.c-span.org/program/public-affairs-event/fcc-open-internet-policy/347981' },
  { date: '2014-03-05', title: 'Most Wanted: ‘Next Generation Thinking’ to Combat Cyber Crime', outlet: 'Knowledge at Wharton', type: 'Article', url: 'https://knowledge.wharton.upenn.edu/article/wanted-combat-cyber-crime/' },
  { date: '2013-01-16', title: 'From Fitbit to Fitocracy: The Rise of Health Care Gamification', outlet: 'Knowledge at Wharton', type: 'Article', url: 'https://knowledge.wharton.upenn.edu/article/fitbit-to-fitocracy-the-rise-of-health-care-gamification/' },
  { date: '2012-08-22', title: 'MOOC Brigade: Back to School, 26 Years Later', outlet: 'TIME', type: 'Article', url: 'https://nation.time.com/2012/08/22/mooc-brigade-back-to-school-26-years-later/' },
  { date: '2012-05-23', title: 'The Facebook IPO: What Went Wrong?', outlet: 'Knowledge at Wharton', type: 'Article', url: 'https://knowledge.wharton.upenn.edu/article/the-facebook-ipo-what-went-wrong/' },
  { date: '2011-10-12', title: 'Life after Steve Jobs: What’s Next for Apple?', outlet: 'Knowledge at Wharton Podcast', type: 'Podcast', url: 'https://knowledge.wharton.upenn.edu/podcast/knowledge-at-wharton-podcast/life-steve-jobs-whats-next-apple/' },
  { date: '2011-04-01', title: 'Business and Government in the Network Age (BizTalks 2011)', outlet: 'Wharton (YouTube)', type: 'Video', url: 'https://www.youtube.com/watch?v=e9vTMaHwZ48' },
  { date: '2011-03-16', title: 'In Search of the Perfect Search: Can Google Beat Attempts to ‘Game’ the System?', outlet: 'Knowledge at Wharton', type: 'Article', url: 'https://knowledge.wharton.upenn.edu/article/in-search-of-the-perfect-search-can-google-beat-attempts-to-game-the-system/' },
  { date: '2011-01-19', title: 'For AT&T, Is There Life after the Verizon iPhone?', outlet: 'Knowledge at Wharton', type: 'Article', url: 'https://knowledge.wharton.upenn.edu/article/for-att-is-there-life-after-the-verizon-iphone/' },
  { date: '2010-07-28', title: 'Why Network Neutrality Is Good for Business', outlet: 'Harvard Business Review', type: 'Article', url: 'https://hbr.org/2010/07/why-network-neutrality-is-good' }
];

// Utility: sorted list (descending)
export const sortedPressAppearances = [...pressAppearances].sort(
  (a, b) => new Date(b.date).getTime() - new Date(a.date).getTime()
);

// Utility: group by year
export function groupPressByYear(list: PressAppearance[] = sortedPressAppearances): Record<string, PressAppearance[]> {
  return list.reduce<Record<string, PressAppearance[]>>((acc, item) => {
    const year = item.date.slice(0, 4);
    acc[year] = acc[year] || [];
    acc[year].push(item);
    return acc;
  }, {});
}
