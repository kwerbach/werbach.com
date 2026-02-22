import { useState, useEffect } from 'react';
import { Helmet } from 'react-helmet-async';
import PageHero from '../components/PageHero';
import { getAllContent } from '../lib/content';
import { markdownToHtml } from '../lib/markdown';
import type { ContentItem } from '../lib/content';

export default function Teaching() {
  const [courses, setCourses] = useState<ContentItem[]>([]);
  const [coursesHtml, setCoursesHtml] = useState<{ [key: string]: string }>({});
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    async function loadCourses() {
      try {
        const items = await getAllContent('teaching');
        setCourses(items.sort((a, b) => a.title.localeCompare(b.title)));

        // Convert markdown to HTML for each course
        const htmlMap: { [key: string]: string } = {};
        for (const course of items) {
          htmlMap[course.slug] = await markdownToHtml(course.content);
        }
        setCoursesHtml(htmlMap);
      } catch (error) {
        console.error('Error loading courses:', error);
      } finally {
        setLoading(false);
      }
    }

    loadCourses();
  }, []);

  return (
    <>
      <Helmet>
        <title>Teaching | Kevin Werbach</title>
        <meta name="description" content="Courses taught by Kevin Werbach at the Wharton School on emerging technologies, legal analytics, and the intersection of law and business strategy." />
        <link rel="canonical" href="https://kevinwerbach.com/teaching" />
        <meta property="og:title" content="Teaching | Kevin Werbach" />
        <meta property="og:description" content="Courses taught by Kevin Werbach at the Wharton School." />
        <meta property="og:url" content="https://kevinwerbach.com/teaching" />
        <meta property="og:type" content="website" />
      </Helmet>
      <div className="bg-black min-h-screen text-white">
      <PageHero title="Teaching" subtitle="Courses at Wharton" />
      
      <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <section className="mb-12">
          <p className="text-lg text-beige-700 leading-relaxed">
            I teach courses at the Wharton School focused on emerging technologies, 
            legal analytics, and the intersection of law and business strategy.
          </p>
        </section>

        {loading ? (
          <div className="text-center py-12 text-beige-700">Loading courses...</div>
        ) : courses.length === 0 ? (
          <div className="text-center py-12 text-beige-700">No courses found.</div>
        ) : (
          <div className="space-y-12">
            {courses.map((course) => (
              <article key={course.slug} className="border-b border-english_violet-400 pb-12 last:border-b-0">
                <h2 className="text-3xl font-bold mb-4 text-white">{course.title}</h2>
                
                {course.summary && (
                  <p className="text-xl text-beige-700 mb-6">{course.summary}</p>
                )}

                <div 
                  className="prose prose-lg prose-invert prose-headings:text-white prose-p:text-beige-700 prose-strong:text-white prose-li:text-beige-700 mb-6"
                  dangerouslySetInnerHTML={{ __html: coursesHtml[course.slug] || '' }}
                />

                {course.links && course.links.external && (
                  <a
                    href={course.links.external}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 focus:ring-offset-black"
                  >
                    Course Syllabus
                  </a>
                )}
              </article>
            ))}
          </div>
        )}
      </div>
    </div>
    </>
  );
}
