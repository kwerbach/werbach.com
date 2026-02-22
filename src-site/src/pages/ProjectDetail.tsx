import { useParams, Link } from 'react-router-dom';
import { useEffect, useState } from 'react';
import Prose from '../components/Prose';
import { Helmet } from 'react-helmet-async';
import { getContentBySlug } from '../lib/content';
import { markdownToHtml } from '../lib/markdown';
import type { ContentItem } from '../lib/content';

export default function ProjectDetail() {
  const { slug } = useParams<{ slug: string }>();
  const [project, setProject] = useState<ContentItem | null>(null);
  const [htmlContent, setHtmlContent] = useState<string>('');
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string>('');

  useEffect(() => {
    async function loadProject() {
      if (!slug) {
        setError('No slug provided');
        setLoading(false);
        return;
      }

      try {
        const content = await getContentBySlug('projects', slug);

        if (!content) {
          setError('Project not found');
          setLoading(false);
          return;
        }

        setProject(content);
        const html = await markdownToHtml(content.content);
        setHtmlContent(html);
      } catch (err) {
        console.error('Error loading project:', err);
        setError('Error loading content');
      } finally {
        setLoading(false);
      }
    }

    loadProject();
  }, [slug]);

  if (loading) {
    return (
      <div id="main-content" className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div className="text-center text-gray-500">Loading...</div>
      </div>
    );
  }

  if (error || !project) {
    return (
      <div id="main-content" className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div className="text-center text-gray-500">{error || 'Project not found'}</div>
        <div className="text-center mt-4">
          <Link to="/projects" className="text-blue-600 hover:text-blue-700">
            Back to Projects
          </Link>
        </div>
      </div>
    );
  }

  const isAccountableAI = slug === 'accountable-ai';

  return (
    <div className="bg-black min-h-screen text-white">
      <Helmet>
        <title>{project.title} | Research Initiative</title>
        {project.summary && <meta name="description" content={project.summary} />}
        <meta property="og:title" content={project.title} />
        {project.summary && <meta property="og:description" content={project.summary} />}
      </Helmet>
      {isAccountableAI && (
        <section className="relative overflow-hidden border-b border-english_violet-400">
          <div className="absolute inset-0 bg-linear-to-br from-green-950/40 via-black to-black" />
          <div className="absolute inset-0 opacity-20 mix-blend-overlay pointer-events-none" style={{backgroundImage:'radial-gradient(circle at 20% 30%, rgba(34,197,94,0.25), transparent 55%)'}} />
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-20 relative">
            <Link to="/projects" className="text-citron-300 hover:text-green-300 mb-8 inline-flex items-center gap-2 text-sm font-medium transition-colors">
              <svg className="w-4 h-4" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24"><path d="M19 12H5m0 0l7 7m-7-7l7-7"/></svg>
              <span>Back to Projects</span>
            </Link>
            <div className="mb-10">
              <h1 className="text-4xl md:text-6xl font-bold tracking-tight mb-6 bg-linear-to-r from-white via-gray-100 to-gray-300 bg-clip-text text-transparent">{project.title}</h1>
              <p className="text-xl md:text-2xl text-beige-700 leading-relaxed max-w-4xl mb-4">
                Advancing the Responsible and Trustworthy Use of AI in Business and Society
              </p>
            </div>
            
            <div className="grid md:grid-cols-3 gap-6 mb-12 max-w-6xl">
              {[
                {
                  icon: <svg className="w-6 h-6" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>,
                  title:'Research & Scholarship',
                  body:'Cutting-edge academic work on algorithmic bias, explainability, governance models, regulatory approaches, and the social impact of AI systems.'
                },
                {
                  icon: <svg className="w-6 h-6" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>,
                  title:'Practical Frameworks',
                  body:'Assessment tools, governance templates, audit methodologies, and implementation guides that organizations can adapt to their specific contexts.'
                },
                {
                  icon: <svg className="w-6 h-6" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>,
                  title:'Executive Education',
                  body:'World-class programs bringing Wharton expertise to business leaders through live sessions, case studies, and capstone projects.'
                }
              ].map(box => (
                <div key={box.title} className="bg-english_violet-600/80 backdrop-blur-sm border border-english_violet-300/60 rounded-xl p-6 hover:border-green-500/50 hover:bg-english_violet-600/90 transition-all duration-300 group">
                  <div className="text-citron-300 mb-3 group-hover:text-green-300 transition-colors">{box.icon}</div>
                  <h3 className="font-semibold text-white mb-2 text-base">{box.title}</h3>
                  <p className="text-sm text-beige-700 leading-relaxed">{box.body}</p>
                </div>
              ))}
            </div>
            
            {project.links?.external && (
              <div className="flex flex-wrap gap-3">
                <a href={project.links.external} target="_blank" rel="noopener noreferrer" className="inline-flex items-center gap-2 px-6 py-3 rounded-lg bg-green-600 hover:bg-green-500 font-semibold text-white shadow-lg shadow-green-600/30 transition-all hover:shadow-green-600/50 hover:scale-105">
                  <svg className="w-5 h-5" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24"><path d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                  <span>Lab Website</span>
                </a>
                {project.links?.conference && (
                  <a href={project.links.conference} target="_blank" rel="noopener noreferrer" className="px-5 py-3 rounded-lg bg-english_violet-500/90 hover:bg-gray-700 text-gray-100 text-sm font-medium border border-gray-600/50 hover:border-gray-500 transition-all">Research Conference</a>
                )}
                {project.links?.execed && (
                  <a href={project.links.execed} target="_blank" rel="noopener noreferrer" className="px-5 py-3 rounded-lg bg-english_violet-500/90 hover:bg-gray-700 text-gray-100 text-sm font-medium border border-gray-600/50 hover:border-gray-500 transition-all">Exec Ed Program</a>
                )}
                {project.links?.podcast && (
                  <a href={project.links.podcast} target="_blank" rel="noopener noreferrer" className="px-5 py-3 rounded-lg bg-english_violet-500/90 hover:bg-gray-700 text-gray-100 text-sm font-medium border border-gray-600/50 hover:border-gray-500 transition-all">Podcast</a>
                )}
              </div>
            )}
          </div>
        </section>
      )}
      <div id="main-content" className={`mx-auto px-4 sm:px-6 lg:px-8 ${isAccountableAI ? 'max-w-7xl py-16' : 'max-w-4xl py-16'}`}>
        {!isAccountableAI && (
          <header className="mb-12">
            <Link 
              to="/projects" 
              className="text-citron hover:text-citron-300 mb-6 inline-flex items-center gap-2 text-sm font-medium transition-colors"
            >
              <svg className="w-4 h-4" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24"><path d="M19 12H5m0 0l7 7m-7-7l7-7"/></svg>
              <span>Back to Projects</span>
            </Link>
            <h1 className="text-4xl md:text-5xl font-bold mb-6 text-white leading-tight">{project.title}</h1>
            {project.summary && (
              <p className="text-xl text-beige-700 mb-8 leading-relaxed">{project.summary}</p>
            )}
          </header>
        )}
        <article className="relative">
          {isAccountableAI && (
            <div className="mb-16">
              <div className="grid lg:grid-cols-3 gap-8 mb-12">
                <div className="lg:col-span-2 space-y-6">
                  <div className="bg-linear-to-br from-gray-900/90 to-gray-900/70 border border-english_violet-300/60 rounded-xl p-8 shadow-2xl">
                    <div className="flex items-start gap-4 mb-4">
                      <div className="bg-green-600/10 p-3 rounded-lg">
                        <svg className="w-6 h-6 text-citron-300" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                      </div>
                      <div className="flex-1">
                        <h2 className="text-2xl font-bold text-white mb-3">The Challenge</h2>
                        <p className="text-beige-700 leading-relaxed">
                          AI adoption is racing ahead of institutional capacity to oversee it. Organizations worldwide face new regulatory obligations (EU AI Act, U.S. Executive Orders) and ethical concerns, yet many boards and teams still lack actionable governance playbooks.
                        </p>
                      </div>
                    </div>
                  </div>
                  
                  <div className="bg-linear-to-br from-gray-900/90 to-gray-900/70 border border-english_violet-300/60 rounded-xl p-8 shadow-2xl">
                    <div className="flex items-start gap-4">
                      <div className="bg-green-600/10 p-3 rounded-lg">
                        <svg className="w-6 h-6 text-citron-300" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                      </div>
                      <div className="flex-1">
                        <h2 className="text-2xl font-bold text-white mb-3">Our Approach</h2>
                        <p className="text-beige-700 leading-relaxed mb-4">
                          Leveraging Wharton's unique combination of legal expertise, business acumen, and global reach, the Lab serves as a hub where policymakers, industry leaders, and academics collaborate to address AI's most pressing challenges.
                        </p>
                        <div className="grid sm:grid-cols-3 gap-4 mt-6">
                          {[
                            {label: 'AI Governance', desc: 'Organizational frameworks & controls'},
                            {label: 'AI Regulation', desc: 'Policy analysis & compliance'},
                            {label: 'AI Ethics', desc: 'Normative & behavioral considerations'}
                          ].map(pillar => (
                            <div key={pillar.label} className="bg-black/30 border border-english_violet-300/40 rounded-lg p-4">
                              <div className="text-citron-300 font-semibold text-sm mb-1">{pillar.label}</div>
                              <div className="text-beige-700 text-xs">{pillar.desc}</div>
                            </div>
                          ))}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div className="space-y-6">
                  <div className="bg-linear-to-br from-green-950/40 to-gray-900/70 border border-green-700/40 rounded-xl p-6 shadow-xl">
                    <h3 className="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                      <svg className="w-5 h-5 text-citron-300" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                      Quick Facts
                    </h3>
                    <div className="space-y-3 text-sm">
                      <div className="flex items-start gap-3">
                        <div className="text-citron-300 mt-0.5">•</div>
                        <div className="text-beige-700">Interdisciplinary research on AI governance, regulation, and ethics</div>
                      </div>
                      <div className="flex items-start gap-3">
                        <div className="text-citron-300 mt-0.5">•</div>
                        <div className="text-beige-700">7+ affiliated faculty from law, business, operations, and data science</div>
                      </div>
                      <div className="flex items-start gap-3">
                        <div className="text-citron-300 mt-0.5">•</div>
                        <div className="text-beige-700">Annual Accountable AI Research Conference</div>
                      </div>
                      <div className="flex items-start gap-3">
                        <div className="text-citron-300 mt-0.5">•</div>
                        <div className="text-beige-700">9-week Executive Education program with live sessions</div>
                      </div>
                      <div className="flex items-start gap-3">
                        <div className="text-citron-300 mt-0.5">•</div>
                        <div className="text-beige-700">Weekly podcast featuring global AI policy experts</div>
                      </div>
                    </div>
                  </div>
                  
                  <div className="bg-english_violet-600/70 border border-english_violet-300/60 rounded-xl p-6">
                    <h3 className="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                      <svg className="w-5 h-5 text-citron-300" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                      Get Involved
                    </h3>
                    <div className="space-y-3">
                      {project.links?.execed && (
                        <a href={project.links.execed} target="_blank" rel="noopener noreferrer" className="flex items-center justify-between px-4 py-3 rounded-lg bg-green-600 hover:bg-green-500 text-white font-medium text-sm transition-all group">
                          <span>Exec Ed Program</span>
                          <svg className="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24"><path d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                      )}
                      {project.links?.conference && (
                        <a href={project.links.conference} target="_blank" rel="noopener noreferrer" className="flex items-center justify-between px-4 py-3 rounded-lg bg-english_violet-500/80 hover:bg-gray-700 text-gray-100 font-medium text-sm transition-all border border-english_violet-300/50 group">
                          <span>Research Conference</span>
                          <svg className="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24"><path d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                      )}
                      {project.links?.podcast && (
                        <a href={project.links.podcast} target="_blank" rel="noopener noreferrer" className="flex items-center justify-between px-4 py-3 rounded-lg bg-english_violet-500/80 hover:bg-gray-700 text-gray-100 font-medium text-sm transition-all border border-english_violet-300/50 group">
                          <span>Listen to Podcast</span>
                          <svg className="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24"><path d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                      )}
                      {project.links?.newsletter && (
                        <a href={project.links.newsletter} target="_blank" rel="noopener noreferrer" className="flex items-center justify-between px-4 py-3 rounded-lg bg-english_violet-500/80 hover:bg-gray-700 text-gray-100 font-medium text-sm transition-all border border-english_violet-300/50 group">
                          <span>Subscribe</span>
                          <svg className="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24"><path d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                      )}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          )}
          <div className={`rounded-xl border border-english_violet-300/60 bg-linear-to-br from-gray-900/80 to-gray-900/60 backdrop-blur-sm shadow-2xl ${isAccountableAI ? 'p-8 md:p-12' : 'p-8 md:p-10'}`}>
            <Prose>
              <div dangerouslySetInnerHTML={{ __html: htmlContent }} />
            </Prose>
          </div>
          {isAccountableAI && (
            <div className="mt-12 bg-linear-to-br from-gray-900/90 to-gray-900/70 border border-english_violet-300/60 rounded-xl p-8 shadow-2xl">
              <h3 className="text-2xl font-bold mb-6 text-white flex items-center gap-3">
                <svg className="w-6 h-6 text-citron-300" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24"><path d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                Resources & Links
              </h3>
              <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                {Object.entries(project.links || {}).filter(([k])=>k!=='pdf').map(([key,val]) => (
                  <a key={key} href={String(val)} target="_blank" rel="noopener noreferrer" className="group flex items-center gap-3 rounded-lg border border-english_violet-300/50 bg-english_violet-500/50 px-5 py-4 hover:border-green-500/60 hover:bg-english_violet-500/80 transition-all">
                    <svg className="w-5 h-5 text-citron-300 group-hover:text-green-300 shrink-0" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    <span className="text-sm text-gray-200 group-hover:text-white font-medium">{key.charAt(0).toUpperCase()+key.slice(1).replace(/_/g,' ')}</span>
                  </a>
                ))}
              </div>
            </div>
          )}
        </article>
      </div>
    </div>
  );
}
