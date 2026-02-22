import { useEffect, useState } from 'react';
import { Helmet } from 'react-helmet-async';
import PageHero from '../components/PageHero';
import Card from '../components/Card';
import { getAllContent } from '../lib/content';
import type { ContentItem } from '../lib/content';

const PROJECT_EXTERNAL_LINKS: Record<string, string> = {
  'accountable-ai': 'https://whr.tn/accountable-ai-lab',
  'bdap': 'https://bdap.wharton.upenn.edu'
};

export default function Projects() {
  const [currentProjects, setCurrentProjects] = useState<ContentItem[]>([]);
  const [pastProjects, setPastProjects] = useState<ContentItem[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    async function loadProjects() {
      try {
        const items = await getAllContent('projects');
        
        // Separate current and past projects based on status field
        const current = items.filter(p => !p.status || p.status !== 'past').sort((a, b) => a.title.localeCompare(b.title));
        const past = items.filter(p => p.status === 'past').sort((a, b) => {
          // Sort past projects by date, newest first
          const dateA = new Date(a.date || '2000-01-01').getTime();
          const dateB = new Date(b.date || '2000-01-01').getTime();
          return dateB - dateA;
        });
        
        setCurrentProjects(current);
        setPastProjects(past);
      } catch (error) {
        console.error('Error loading projects:', error);
      } finally {
        setLoading(false);
      }
    }

    loadProjects();
  }, []);

  return (
    <>
      <Helmet>
        <title>Projects | Kevin Werbach</title>
        <meta name="description" content="Research projects and initiatives led by Kevin Werbach, including the Wharton Accountable AI Lab and Blockchain and Digital Asset Project." />
        <link rel="canonical" href="https://kevinwerbach.com/projects" />
        <meta property="og:title" content="Projects | Kevin Werbach" />
        <meta property="og:description" content="Research projects and initiatives led by Kevin Werbach." />
        <meta property="og:url" content="https://kevinwerbach.com/projects" />
        <meta property="og:type" content="website" />
      </Helmet>
      <div className="bg-black min-h-screen text-white">
      <PageHero title="Projects" subtitle="Research Initiatives and Collaborations" />
      
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        {loading ? (
          <div className="text-center py-12 text-beige-700">Loading projects...</div>
        ) : (
          <>
            {/* Current Projects */}
            {currentProjects.length > 0 && (
              <section className="mb-16">
                <h2 className="text-3xl font-bold text-white mb-8">Current Projects</h2>
                <div className="grid md:grid-cols-2 gap-8">
                  {currentProjects.map((project) => {
                    const linkTarget = PROJECT_EXTERNAL_LINKS[project.slug] || `/projects/${project.slug}`;
                    return (
                      <Card
                        key={project.slug}
                        title={project.title}
                        summary={project.summary || ''}
                        link={linkTarget}
                        tags={project.tags || []}
                      />
                    );
                  })}
                </div>
              </section>
            )}

            {/* Past Projects */}
            {pastProjects.length > 0 && (
              <section>
                <h2 className="text-3xl font-bold text-white mb-8">Past Projects & Events</h2>
                <div className="grid md:grid-cols-2 gap-8">
                  {pastProjects.map((project) => {
                    const linkTarget = PROJECT_EXTERNAL_LINKS[project.slug] || `/projects/${project.slug}`;
                    return (
                      <Card
                        key={project.slug}
                        title={project.title}
                        summary={project.summary || ''}
                        link={linkTarget}
                        tags={project.tags || []}
                      />
                    );
                  })}
                </div>
              </section>
            )}

            {currentProjects.length === 0 && pastProjects.length === 0 && (
              <div className="text-center py-12 text-beige-700">No projects found.</div>
            )}
          </>
        )}
      </div>
    </div>
    </>
  );
}
