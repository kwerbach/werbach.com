import { BrowserRouter, Routes, Route, useLocation } from 'react-router-dom';
import { useEffect, useState } from 'react';
import { HelmetProvider } from 'react-helmet-async';
import Nav from './components/Nav';
import Footer from './components/Footer';
import Home from './pages/Home';
import Ideas from './pages/Ideas';
import IdeaDetail from './pages/IdeaDetail';
import BookDetail from './pages/BookDetail';
import Projects from './pages/Projects';
import ProjectDetail from './pages/ProjectDetail';
import Teaching from './pages/Teaching';
import Courses from './pages/Courses';
import Speaking from './pages/Speaking';
import Podcast from './pages/Podcast';
import PodcastDetail from './pages/PodcastDetail';
import Substack from './pages/Substack';
import Media from './pages/Media';
import About from './pages/About';
import Contact from './pages/Contact';

function TopProgress() {
  const [progress, setProgress] = useState(0);
  return (
  <div className="fixed top-0 left-0 right-0 h-0.5 z-50 pointer-events-none">
      <div
        className="h-full bg-teal-500 transition-all duration-300"
        style={{ width: `${progress}%` }}
      />
      {/* Imperative API via custom event */}
      <ProgressController onSet={setProgress} />
    </div>
  );
}

function ProgressController({ onSet }: { onSet: (v: number) => void }) {
  useEffect(() => {
    function handler(e: Event) {
      const custom = e as CustomEvent<number>;
      onSet(custom.detail);
    }
    window.addEventListener('app:progress', handler);
    return () => window.removeEventListener('app:progress', handler);
  }, [onSet]);
  return null;
}

function RouteChangeTracker() {
  const location = useLocation();
  useEffect(() => {
    // Kick off progress
    window.dispatchEvent(new CustomEvent('app:progress', { detail: 15 }));
    const step1 = setTimeout(() => window.dispatchEvent(new CustomEvent('app:progress', { detail: 45 })), 120);
    const step2 = setTimeout(() => window.dispatchEvent(new CustomEvent('app:progress', { detail: 70 })), 320);
    // Simulate completion once idle
    const done = setTimeout(() => window.dispatchEvent(new CustomEvent('app:progress', { detail: 100 })), 650);
    const reset = setTimeout(() => window.dispatchEvent(new CustomEvent('app:progress', { detail: 0 })), 1200);
    return () => { clearTimeout(step1); clearTimeout(step2); clearTimeout(done); clearTimeout(reset); };
  }, [location]);
  return null;
}

function App() {
  return (
    <HelmetProvider>
      <BrowserRouter>
        <div className="min-h-screen flex flex-col bg-black">
          <TopProgress />
          <RouteChangeTracker />
          {/* Skip to main content link for keyboard navigation */}
          <a 
            href="#main-content" 
            className="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:bg-teal-500 focus:text-white focus:px-4 focus:py-2 focus:rounded focus:outline-none focus:ring-2 focus:ring-teal-400"
          >
            Skip to main content
          </a>
          <Nav />
          <main id="main-content" className="grow" tabIndex={-1}>
            <Routes>
              <Route path="/" element={<Home />} />
            <Route path="/ideas" element={<Ideas />} />
            <Route path="/ideas/:slug" element={<IdeaDetail />} />
            <Route path="/ideas/books/:slug" element={<BookDetail />} />
            <Route path="/projects" element={<Projects />} />
            <Route path="/projects/:slug" element={<ProjectDetail />} />
            <Route path="/teaching" element={<Teaching />} />
            <Route path="/courses" element={<Courses />} />
            <Route path="/speaking" element={<Speaking />} />
            <Route path="/podcast" element={<Podcast />} />
            <Route path="/podcast/:slug" element={<PodcastDetail />} />
            <Route path="/substack" element={<Substack />} />
            <Route path="/media" element={<Media />} />
            <Route path="/about" element={<About />} />
            <Route path="/contact" element={<Contact />} />
          </Routes>
        </main>
        <Footer />
      </div>
    </BrowserRouter>
    </HelmetProvider>
  );
}

export default App;

