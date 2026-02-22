import { useState } from 'react';
import clsx from 'clsx';

interface LazyImageProps {
  src: string;
  alt: string;
  aspectRatio?: string; // e.g., "16/9" or "4/3"
  className?: string;
  sizes?: string;
  srcSet?: string;
}

export default function LazyImage({ 
  src, 
  alt, 
  aspectRatio = '16/9', 
  className,
  sizes,
  srcSet
}: LazyImageProps) {
  const [isLoaded, setIsLoaded] = useState(false);
  const [hasError, setHasError] = useState(false);

  return (
    <div 
      className={clsx('relative overflow-hidden bg-gray-100', className)}
      style={{ aspectRatio }}
    >
      {!isLoaded && !hasError && (
        <div className="absolute inset-0 bg-linear-to-r from-gray-100 via-gray-200 to-gray-100 animate-shimmer" />
      )}
      
      {hasError ? (
        <div className="absolute inset-0 flex items-center justify-center text-beige-700">
          <span>Image unavailable</span>
        </div>
      ) : (
        <img
          src={src}
          srcSet={srcSet}
          sizes={sizes}
          alt={alt}
          loading="lazy"
          decoding="async"
          onLoad={() => setIsLoaded(true)}
          onError={() => setHasError(true)}
          className={clsx(
            'w-full h-full object-cover transition-opacity duration-300',
            isLoaded ? 'opacity-100' : 'opacity-0'
          )}
        />
      )}
    </div>
  );
}
