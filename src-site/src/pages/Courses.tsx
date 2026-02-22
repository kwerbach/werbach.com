import { Helmet } from 'react-helmet-async';
import { ExternalLink } from 'lucide-react';
import { motion } from 'framer-motion';

const courses = [
  {
    title: 'Coursera Gamification MOOC',
    role: 'Creator',
    url: 'https://www.coursera.org/learn/gamification',
    available: true,
    description:
      'One of Coursera\'s earliest blockbuster courses, explaining how to harness game design principles to drive motivation, engagement, and behavior change across business contexts.',
    color: '#EC4899',
  },
  {
    title: 'Coursera AI Strategy & Governance',
    role: 'Contributor',
    url: 'https://www.coursera.org/learn/wharton-ai-strategy-governance',
    available: true,
    description:
      'A practical roadmap for executives who need to align artificial intelligence initiatives with responsible governance, regulatory expectations, and measurable business outcomes.',
    color: '#4F46E5',
  },
  {
    title: 'Economics of Blockchain and Digital Assets',
    role: 'Faculty Director',
    url: null,
    available: false,
    note: 'No longer offered',
    description:
      'Offered from 2021-23, this Wharton online program used theoretical frameworks, real-world applications, and case studies to equip leaders for blockchain and digital assets. A follow-on edition focused on Business in the Metaverse Economy.',
    color: '#22C55E',
  },
  {
    title: 'Wharton Strategies for Accountable AI',
    role: 'Faculty Director',
    url: 'https://executiveeducation.wharton.upenn.edu/for-individuals/all-programs/strategies-for-accountable-ai/',
    available: true,
    description:
      'Practical guidance for deploying responsible, safe, trustworthy, ethical, and legally compliant AI systems. Topics include accuracy and transparency, fairness and bias mitigation, human/AI interaction, privacy, data integrity, and cybersecurity so enterprises can unlock AI\'s value while protecting their reputation.',
    color: '#1673FF',
  },
  {
    title: 'Emeritus Chief Technology Officer Program',
    role: 'Contributor',
    url: 'https://emeritus.org/course-preview/chief-technology-officer-program/',
    available: true,
    description:
      'A multi-module journey for CTOs and senior technology leaders covering strategy, architecture, innovation, and talent leadership with hands-on projects and coaching.',
    color: '#7C3AED',
  },
  {
    title: 'Emeritus Technology Acceleration Program',
    role: 'Contributor',
    url: 'https://online-execed.wharton.upenn.edu/technology-acceleration-program',
    available: true,
    description:
      'An executive program focused on modernizing digital capabilities, bridging business and engineering priorities, and accelerating transformation initiatives across the enterprise.',
    color: '#0EA5E9',
  },
];

export default function Courses() {
  return (
    <>
      <Helmet>
        <title>Courses | Kevin Werbach</title>
        <meta name="description" content="Online courses and executive education programs by Kevin Werbach on gamification, blockchain, AI governance, and emerging technologies." />
        <link rel="canonical" href="https://kevinwerbach.com/courses" />
        <meta property="og:title" content="Courses | Kevin Werbach" />
        <meta property="og:description" content="Online courses and executive education programs by Kevin Werbach on gamification, blockchain, AI governance, and emerging technologies." />
        <meta property="og:url" content="https://kevinwerbach.com/courses" />
        <meta property="og:type" content="website" />
      </Helmet>
      <div className="bg-black min-h-screen text-white">
      <div id="main-content" className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <motion.div
          initial={{ opacity: 0, y: 15 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.5 }}
          className="mb-12"
        >
          <div className="max-w-4xl mx-auto rounded-2xl overflow-hidden border border-beige-900/40 shadow-2xl shadow-black/40">
            <div className="aspect-[16/7] relative">
              <div className="absolute inset-0 bg-gradient-to-tr from-black/40 via-transparent to-black/5" />
              <img
                src="/uploads/werbach-online-exec-ed.jpg"
                alt="Kevin Werbach speaking to executive education participants"
                className="w-full h-full object-cover object-center scale-[1.02]"
                loading="lazy"
              />
            </div>
          </div>
        </motion.div>

        {/* Introduction Section */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.6 }}
          className="mb-10 text-center md:text-left"
        >
          <div className="text-lg text-beige-700 leading-relaxed space-y-5 max-w-3xl md:max-w-none mx-auto md:mx-0">
            <p>
              At Wharton, Werbach has taught highly popular courses on blockchain, AI governance, responsibility in business, and gamification to MBA students and undergraduates. Recognized for his innovative use of technology-informed pedagogy, he has received the Aspen Institute Ideas Worth Teaching Award (2021), the UBRI Educator Award for Outstanding Blockchain Teacher (2020), the Wharton Teaching Commitment and Curricular Innovation Award (2012), and multiple Wharton Teaching Excellence Awards. He regularly lectures in Wharton open enrollment and custom corporate executive education programs, helping business leaders understand how to navigate technological and regulatory disruption.
            </p>
            <p>
              He is also the creator and instructor of several successful online courses for executives and lifelong learners:
            </p>
          </div>
        </motion.div>

        {/* Courses Grid */}
        <div className="grid md:grid-cols-2 gap-6">
          {courses.map((course, index) => (
            <motion.div
              key={index}
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.5, delay: index * 0.1 }}
              className="group relative bg-linear-to-br from-english_violet-600/20 to-transparent border rounded-xl p-6 hover:shadow-xl transition-all duration-300"
              style={{
                borderColor: `${course.color}40`,
              }}
              whileHover={{ y: -4 }}
            >
              {/* Top accent line */}
              <div
                className="absolute top-0 left-0 right-0 h-1 rounded-t-xl"
                style={{
                  background: `linear-gradient(90deg, ${course.color}, transparent)`,
                }}
              />

              <div className="flex items-start justify-between gap-4 mb-4">
                {/* Role */}
                <div>
                  <span
                    className="text-sm font-semibold px-3 py-1 rounded-full"
                    style={{
                      backgroundColor: `${course.color}20`,
                      color: course.color,
                    }}
                  >
                    {course.role}
                  </span>
                </div>

                {/* Status indicator */}
                {!course.available && course.note && (
                  <span className="text-xs text-beige-600 italic px-2 py-1 bg-beige-900/30 rounded">
                    {course.note}
                  </span>
                )}
              </div>

              {/* Course Title */}
              <h3 className="text-xl font-bold text-white mb-3 group-hover:text-citron transition-colors">
                {course.title}
              </h3>

              <p className="text-sm text-beige-500 leading-relaxed mb-4">
                {course.description}
              </p>

              {/* Action Button */}
              {course.url && (
                <a
                  href={course.url}
                  target="_blank"
                  rel="noopener noreferrer"
                  className="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg font-semibold transition-all duration-300 hover:scale-105"
                  style={{
                    backgroundColor: course.color,
                    color: '#000',
                  }}
                >
                  View Course
                  <ExternalLink size={16} />
                </a>
              )}
            </motion.div>
          ))}
        </div>
      </div>
    </div>
    </>
  );
}
