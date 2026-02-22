import { Helmet } from 'react-helmet-async';
import { Link } from 'react-router-dom';
import { motion } from 'framer-motion';
import { useState, useEffect } from 'react';
import { generatePersonSchema, getSiteUrl } from '../lib/seo';

const themes = [
  {
    title: 'Telecom',
    description: 'Spectrum policy, broadband access, and telecom regulation',
    color: '#F97316',
    tag: 'Telecommunications',
    x: 20,
    y: 25,
    radius: 9
  },
  {
    title: 'Tech Policy',
    description: 'Internet regulation, platform governance, and digital rights',
    color: '#7C3AED',
    tag: 'Tech Policy',
    x: 50,
    y: 15,
    radius: 10
  },
  {
    title: 'Blockchain',
    description: 'Distributed ledger innovation, crypto markets, and policy',
    color: '#22C55E',
    tag: 'Blockchain',
    x: 80,
    y: 30,
    radius: 12
  },
  {
    title: 'Gamification',
    description: 'Game design principles applied to business and society',
    color: '#EC4899',
    tag: 'Gamification',
    x: 15,
    y: 60,
    radius: 7
  },
  {
    title: 'AI Governance',
    description: 'Frameworks for responsible AI development and deployment',
    color: '#4F46E5',
    tag: 'AI Governance',
    x: 45,
    y: 50,
    radius: 9
  },
  {
    title: 'Tech Business',
    description: 'Technology strategy, innovation, and digital transformation',
    color: '#FACC15',
    tag: 'Tech Business',
    x: 35,
    y: 70,
    radius: 8
  },
  {
    title: 'Future of Education',
    description: 'Technology-enabled learning and educational innovation',
    color: '#10B981',
    tag: 'Future of Education',
    x: 65,
    y: 45,
    radius: 9
  },
  {
    title: 'Decentralized Finance',
    description: 'DeFi protocols, risks, and regulatory challenges',
    color: '#0EA5E9',
    tag: 'Decentralized Finance',
    x: 75,
    y: 65,
    radius: 11
  },
  {
    title: 'DAOs',
    description: 'Decentralized autonomous organizations and governance',
    color: '#06B6D4',
    tag: 'DAOs',
    x: 50,
    y: 80,
    radius: 8
  },
  {
    title: 'China',
    description: 'China\'s technology policy and digital economy',
    color: '#DC2626',
    tag: 'China',
    x: 85,
    y: 50,
    radius: 6
  }
];

// Network connections between related topics
const connections = [
  { from: 'Telecommunications', to: 'Tech Policy' },
  { from: 'Telecommunications', to: 'Tech Business' },
  { from: 'AI Governance', to: 'Tech Policy' },
  { from: 'AI Governance', to: 'Future of Education' },
  { from: 'Tech Policy', to: 'Blockchain' },
  { from: 'Blockchain', to: 'Decentralized Finance' },
  { from: 'Decentralized Finance', to: 'DAOs' },
  { from: 'DAOs', to: 'Tech Business' },
  { from: 'Tech Policy', to: 'China' },
  { from: 'Tech Business', to: 'China' },
  { from: 'Gamification', to: 'AI Governance' },
  { from: 'Gamification', to: 'Tech Policy' },
  { from: 'Gamification', to: 'Future of Education' },
  { from: 'Future of Education', to: 'Tech Business' }
];

export default function Home() {
  const personSchema = generatePersonSchema();
  const siteUrl = getSiteUrl();
  const [hoveredNode, setHoveredNode] = useState<string | null>(null);
  const [chargePosition, setChargePosition] = useState(0);
  const [currentConnectionIndex, setCurrentConnectionIndex] = useState(0);

  // Animate charge along network connections
  useEffect(() => {
    const interval = setInterval(() => {
      setChargePosition((prev) => {
        if (prev >= 1) {
          // Move to next connection
          setCurrentConnectionIndex((prevIndex) => (prevIndex + 1) % connections.length);
          return 0;
        }
        return prev + 0.02;
      });
    }, 50);

    return () => clearInterval(interval);
  }, []);

  return (
    <>
      <Helmet>
        <title>Kevin Werbach - Wharton Professor | Blockchain, AI & Tech Policy Expert</title>
        <meta 
          name="description" 
          content="Kevin Werbach is the Liem Sioe Liong/First Pacific Company Professor at Wharton School. Leading expert on blockchain, cryptocurrency, AI, gamification, and technology policy. Author of The Blockchain and the New Architecture of Trust." 
        />
        <link rel="canonical" href={siteUrl} />
        <meta property="og:title" content="Kevin Werbach - Wharton Professor | Blockchain, AI & Tech Policy Expert" />
        <meta property="og:description" content="Tenured Professor at Wharton School, expert on blockchain, cryptocurrency, AI, and technology policy. Author and globally recognized thought leader." />
        <meta property="og:url" content={siteUrl} />
        <meta property="og:type" content="website" />
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:creator" content="@kwerb" />
        <script type="application/ld+json">
          {JSON.stringify(personSchema)}
        </script>
      </Helmet>

      <div className="min-h-screen bg-[#020617] text-white">
        {/* Hero section with network */}
        <div className="container mx-auto px-4 pt-20 pb-16">
          <div className="flex flex-col lg:flex-row items-center lg:items-start justify-between gap-12">
            {/* Network visualization */}
            <div className="flex-1 w-full">
              <div className="relative w-full" style={{ height: '500px', minHeight: '500px' }}>
              {/* SVG for connection lines */}
              <svg className="absolute inset-0 w-full h-full pointer-events-none" style={{ zIndex: 1 }}>
                {connections.map((conn, i) => {
                  const fromNode = themes.find(t => t.tag === conn.from);
                  const toNode = themes.find(t => t.tag === conn.to);
                  if (!fromNode || !toNode) return null;
                  
                  const isActiveConnection = i === currentConnectionIndex;
                  const x1 = parseFloat(fromNode.x.toString());
                  const y1 = parseFloat(fromNode.y.toString());
                  const x2 = parseFloat(toNode.x.toString());
                  const y2 = parseFloat(toNode.y.toString());
                  
                  // Calculate charge position along the line
                  const chargeCx = isActiveConnection ? x1 + (x2 - x1) * chargePosition : -100;
                  const chargeCy = isActiveConnection ? y1 + (y2 - y1) * chargePosition : -100;
                  
                  return (
                    <g key={i}>
                      <motion.line
                        x1={`${fromNode.x}%`}
                        y1={`${fromNode.y}%`}
                        x2={`${toNode.x}%`}
                        y2={`${toNode.y}%`}
                        stroke="#468189"
                        strokeWidth="2"
                        strokeOpacity="0.6"
                        strokeDasharray="4 4"
                        initial={{ pathLength: 0 }}
                        animate={{ pathLength: 1 }}
                        transition={{ duration: 2, ease: "easeInOut" }}
                      />
                      {/* Animated charge */}
                      {isActiveConnection && (
                        <motion.circle
                          cx={`${chargeCx}%`}
                          cy={`${chargeCy}%`}
                          r="4"
                          fill="#bbbe64"
                          initial={{ opacity: 0 }}
                          animate={{ opacity: [0, 1, 1, 0] }}
                          transition={{ duration: 2, times: [0, 0.1, 0.9, 1] }}
                        >
                          <animate
                            attributeName="r"
                            values="4;6;4"
                            dur="1s"
                            repeatCount="indefinite"
                          />
                        </motion.circle>
                      )}
                    </g>
                  );
                })}
              </svg>
              
              {/* Topic nodes */}
              {themes.map((theme) => (
                <motion.div
                  key={theme.tag}
                  className="absolute"
                  style={{
                    left: `${theme.x}%`,
                    top: `${theme.y}%`,
                    zIndex: hoveredNode === theme.tag ? 20 : 10
                  }}
                  animate={{
                    x: [0, theme.radius, -theme.radius, theme.radius, 0],
                    y: [0, -theme.radius, theme.radius, -theme.radius, 0],
                  }}
                  transition={{
                    duration: 20 + theme.radius,
                    repeat: Infinity,
                    ease: "easeInOut",
                    delay: Math.random() * 5
                  }}
                >
                  <Link
                    to={`/ideas?tags=${encodeURIComponent(theme.tag)}`}
                    className="block group"
                    style={{
                      transform: 'translate(-50%, -50%)',
                    }}
                    onMouseEnter={() => setHoveredNode(theme.tag)}
                    onMouseLeave={() => setHoveredNode(null)}
                  >
                    {/* Node */}
                    <motion.div
                      className="px-3 py-1 sm:px-4 sm:py-2 rounded-full bg-black/90 backdrop-blur border-2 transition-all duration-300"
                      style={{
                        borderColor: theme.color,
                        boxShadow: hoveredNode === theme.tag 
                          ? `0 0 20px ${theme.color}40`
                          : `0 0 10px ${theme.color}20`,
                        minWidth: '84px',
                        maxWidth: '150px'
                      }}
                      whileHover={{ scale: 1.1 }}
                    >
                      <span
                        className="block text-[0.68rem] sm:text-sm font-semibold leading-tight text-center tracking-tight"
                        style={{
                          color: theme.color,
                          lineHeight: 1.15
                        }}
                      >
                        {theme.title}
                      </span>
                    </motion.div>
                    
                    {/* Tooltip on hover */}
                    {hoveredNode === theme.tag && (
                      <motion.div
                        initial={{ opacity: 0, y: 10 }}
                        animate={{ opacity: 1, y: 0 }}
                        className="absolute top-full mt-2 left-1/2 -translate-x-1/2 bg-english_violet-900 border border-teal-500/30 rounded-lg px-3 py-2 shadow-lg"
                        style={{ minWidth: '200px', maxWidth: '280px', zIndex: 30 }}
                      >
                        <p className="text-xs text-beige-200">{theme.description}</p>
                      </motion.div>
                    )}
                  </Link>
                </motion.div>
              ))}
              </div>
            </div>
          </div>
        </div>
      </div>
    </>
  );
}
