import { Link, useLocation } from 'react-router-dom';
import { useEffect, useState } from 'react';

const navLinks = [
  { to: '/ideas', label: 'Ideas', external: false },
  { to: '/courses', label: 'Courses', external: false },
  { to: '/speaking', label: 'Speaking', external: false },
  { to: '/media', label: 'Media', external: false },
  { to: '/about', label: 'About', external: false },
  { to: '/contact', label: 'Contact', external: false },
];

export default function Nav() {
  const [mobileOpen, setMobileOpen] = useState(false);
  const location = useLocation();

  const isActiveLink = (path: string) => {
    if (path === '/') {
      return location.pathname === '/';
    }
    return location.pathname === path || location.pathname.startsWith(`${path}/`);
  };
  useEffect(() => {
    // Prefetch top routes on mount for better performance
    const prefetchRoutes = ['/ideas', '/media', '/about'];
    prefetchRoutes.forEach(route => {
      const link = document.createElement('link');
      link.rel = 'prefetch';
      link.href = route;
      document.head.appendChild(link);
    });
    return () => {
      // ensure body scrolling restored if component unmounts
      document.body.style.overflow = '';
    };
  }, []);

  return (
    <nav className="sticky top-0 z-50 bg-black" aria-label="Main navigation">
      {/* Skip to content link for accessibility */}
      <a
        href="#main-content"
        className="sr-only focus:not-sr-only focus:absolute focus:top-2 focus:left-2 focus:z-50 px-4 py-2 bg-teal-500 text-white rounded shadow-lg"
      >
        Skip to main content
      </a>
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex justify-between h-16">
          <div className="flex">
            <Link
              to="/"
              className="flex items-center text-xl font-bold text-white tracking-wide focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/60 focus-visible:ring-offset-2 focus-visible:ring-offset-black transition-colors"
              aria-label="Kevin Werbach - Home"
            >
              <span className="tracking-wide">KEVIN WERBACH</span>
            </Link>
          </div>
          {/* Desktop nav */}
          <div className="hidden md:flex items-center space-x-8">
            {navLinks.map(({ to, label, external }) => {
              if (external) {
                return (
                  <a
                    key={to}
                    href={to}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="inline-flex h-10 items-center px-4 rounded-md border border-white/10 text-white hover:border-white/40 hover:bg-white/5 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/60 transition-colors"
                  >
                    {label}
                  </a>
                );
              }

              const active = isActiveLink(to);
              return (
                <Link
                  key={to}
                  to={to}
                  className={`inline-flex h-10 items-center px-4 rounded-md border focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/60 transition-colors ${active ? 'bg-white text-black border-white shadow-[0_0_12px_rgba(255,255,255,0.35)]' : 'border-white/10 text-white hover:border-white/40 hover:bg-white/5'}`}
                  aria-current={active ? 'page' : undefined}
                >
                  {label}
                </Link>
              );
            })}
            <div className="mt-6">
              <SubscribeCTA />
            </div>
          </div>
          {/* Mobile menu button */}
          <div className="flex items-center md:hidden">
            <button
              type="button"
              className="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-citron hover:bg-white/10 focus:outline-none focus:ring-0"
              aria-controls="mobile-menu"
              aria-expanded={mobileOpen}
              onClick={() => {
                const next = !mobileOpen;
                setMobileOpen(next);
              }}
            >
              <span className="sr-only">Open main menu</span>
              {/* Icon: Hamburger/X */}
              {mobileOpen ? (
                <svg className="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                </svg>
              ) : (
                <svg className="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" />
                </svg>
              )}
            </button>
          </div>
        </div>
      </div>
      {/* Mobile menu panel */}
      <div id="mobile-menu" className={`md:hidden ${mobileOpen ? 'block' : 'hidden'} absolute inset-x-0 top-16 bg-black/95 backdrop-blur-sm z-30`}>
        <div className="space-y-1 px-4 pb-4 pt-2">
          {navLinks.map(({ to, label, external }) => {
            if (external) {
              return (
                <a
                  key={to}
                  href={to}
                  target="_blank"
                  rel="noopener noreferrer"
                  className="block px-3 py-2 text-base font-medium text-white hover:bg-white/10"
                  onClick={() => setMobileOpen(false)}
                >
                  {label}
                </a>
              );
            }

            const active = isActiveLink(to);
            return (
              <Link
                key={to}
                to={to}
                className={`block px-3 py-2 text-base font-medium rounded-md border transition ${active ? 'bg-white text-black border-white' : 'text-white border-transparent hover:border-white/40 hover:bg-white/10'}`}
                aria-current={active ? 'page' : undefined}
                onClick={() => setMobileOpen(false)}
              >
                {label}
              </Link>
            );
          })}
        </div>
      </div>
    </nav>
  );
}

type SubscribeCTAProps = {
  compact?: boolean;
  onSelect?: () => void;
  className?: string;
};

function SubscribeCTA({ compact = false, onSelect, className }: SubscribeCTAProps) {
  const containerWidth = compact ? 'w-full max-w-xs' : 'w-full max-w-[11rem]';

  const handleClick = () => {
    if (onSelect) {
      onSelect();
    }
  };

  return (
    <div className={`${containerWidth} flex flex-col items-center text-white ${className ?? ''}`}>
      <div className="relative rounded-lg overflow-hidden shadow-[0_8px_22px_rgba(0,0,0,0.4)]">
        <img
          src="/uploads/subscribe-now2.jpg"
          alt="Subscribe Now"
          className="block h-12 w-auto object-contain"
          loading="lazy"
        />
        {/* Clickable overlay for Podcast (left side, bottom half only) */}
        <a
          href="https://accountableai.net/"
          target="_blank"
          rel="noopener noreferrer"
          className="absolute bottom-0 left-0 w-1/2 h-1/2 cursor-pointer"
          style={{ zIndex: 10 }}
          onClick={handleClick}
          aria-label="Podcast"
        />
        {/* Clickable overlay for Substack (right side, bottom half only) */}
        <a
          href="https://accountableai.substack.com/"
          target="_blank"
          rel="noopener noreferrer"
          className="absolute bottom-0 right-0 w-1/2 h-1/2 cursor-pointer"
          style={{ zIndex: 10 }}
          onClick={handleClick}
          aria-label="Substack"
        />
      </div>
    </div>
  );
}
