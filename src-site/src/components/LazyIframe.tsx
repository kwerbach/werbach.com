import { useState, useEffect } from 'react';
import clsx from 'clsx';

interface LazyIframeProps {
  src: string;
  title: string;
  aspectRatio?: string; // e.g., "16/9" or "4/3"
  className?: string;
  allow?: string;
}

export default function LazyIframe({ 
  src, 
  title, 
  aspectRatio = '16/9', 
  className,
  allow
}: LazyIframeProps) {
  const [isInView, setIsInView] = useState(false);
  const [isLoaded, setIsLoaded] = useState(false);

  useEffect(() => {
    const observer = new IntersectionObserver(
      ([entry]) => {
        if (entry.isIntersecting) {
          setIsInView(true);
          observer.disconnect();
        }
      },
      { rootMargin: '50px' }
    );

    const element = document.getElementById(`iframe-${src}`);
    if (element) {
      observer.observe(element);
    }

    return () => observer.disconnect();
  }, [src]);

  return (
    <div 
      id={`iframe-${src}`}
      className={clsx('relative overflow-hidden bg-gray-100', className)}
      style={{ aspectRatio }}
    >
      {!isLoaded && (
        <div className="absolute inset-0 flex items-center justify-center">
          <div className="text-center">
            <div className="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-2" />
            <span className="text-sm text-gray-600">Loading {title}...</span>
          </div>
        </div>
      )}
      
      {isInView && (
        <iframe
          src={src}
          title={title}
          allow={allow}
          loading="lazy"
          onLoad={() => setIsLoaded(true)}
          className={clsx(
            'absolute inset-0 w-full h-full border-0 transition-opacity duration-300',
            isLoaded ? 'opacity-100' : 'opacity-0'
          )}
        />
      )}
    </div>
  );
}
