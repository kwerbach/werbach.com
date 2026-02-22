# Lazy Loading Components

This project includes optimized lazy loading components for images and iframes to improve performance and maintain CLS (Cumulative Layout Shift) < 0.1.

## LazyImage Component

Use for all images to ensure proper lazy loading with loading skeletons and aspect ratio preservation.

### Basic Usage

```tsx
import LazyImage from '@/components/LazyImage';

<LazyImage
  src="/images/profile.jpg"
  alt="Kevin Werbach speaking at conference"
  aspectRatio="16/9"
/>
```

### With Responsive Images

```tsx
<LazyImage
  src="/images/profile-800.jpg"
  srcSet="/images/profile-400.jpg 400w, /images/profile-800.jpg 800w, /images/profile-1200.jpg 1200w"
  sizes="(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 33vw"
  alt="Kevin Werbach speaking at conference"
  aspectRatio="16/9"
  className="rounded-lg shadow-md"
/>
```

### Props

- `src` (string, required): Image source URL
- `alt` (string, required): Accessible alt text describing the image
- `aspectRatio` (string, optional): CSS aspect-ratio value (default: "16/9"). Examples: "4/3", "1/1", "21/9"
- `className` (string, optional): Additional CSS classes for the container
- `sizes` (string, optional): Responsive image sizes attribute
- `srcSet` (string, optional): Responsive image source set

### Features

- **Loading="lazy"**: Native browser lazy loading for performance
- **Aspect ratio container**: Prevents CLS by reserving space before image loads
- **Loading skeleton**: Shows animated gradient while loading
- **Error handling**: Displays fallback message if image fails to load
- **Fade-in animation**: Smooth transition when image loads
- **Respects prefers-reduced-motion**: Animations pause for users with motion sensitivity

## LazyIframe Component

Use for embedded content (YouTube videos, Spotify podcasts, etc.) to defer loading until visible.

### Basic Usage

```tsx
import LazyIframe from '@/components/LazyIframe';

<LazyIframe
  src="https://www.youtube.com/embed/VIDEO_ID"
  title="Talk: Blockchain and the Law"
  aspectRatio="16/9"
  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
/>
```

### Props

- `src` (string, required): Iframe source URL
- `title` (string, required): Accessible title describing the embedded content
- `aspectRatio` (string, optional): CSS aspect-ratio value (default: "16/9")
- `className` (string, optional): Additional CSS classes for the container
- `allow` (string, optional): Iframe allow attribute for permissions

### Features

- **Intersection Observer**: Only loads iframe when user scrolls near it
- **Loading indicator**: Shows spinner and message while loading
- **Aspect ratio container**: Prevents CLS
- **Fade-in animation**: Smooth transition when iframe loads
- **50px rootMargin**: Starts loading slightly before iframe enters viewport

## Accessibility Features

Both components include:

- Proper semantic HTML (`img`, `iframe` with required attributes)
- Accessible alt text/titles (required props)
- Keyboard navigation support
- Screen reader compatibility
- Respects `prefers-reduced-motion` for loading animations

## Performance Benefits

- **Deferred loading**: Images/iframes don't block initial page load
- **CLS prevention**: Fixed aspect ratios reserve space before content loads
- **Bandwidth savings**: Only loads content user might see
- **Better Web Vitals**: Improves LCP (Largest Contentful Paint) and CLS scores

## Example: Article with Images

```tsx
import LazyImage from '@/components/LazyImage';
import LazyIframe from '@/components/LazyIframe';

export default function ArticleDetail() {
  return (
    <article>
      <header>
        <LazyImage
          src="/images/articles/blockchain-hero.jpg"
          alt="Visualization of blockchain network"
          aspectRatio="21/9"
          className="w-full mb-8 rounded-lg"
        />
        <h1>Understanding Blockchain Technology</h1>
      </header>

      <div className="prose">
        <p>Article content...</p>

        <LazyIframe
          src="https://www.youtube.com/embed/VIDEO_ID"
          title="Video: Blockchain Explained"
          aspectRatio="16/9"
          className="my-8"
        />

        <p>More content...</p>
      </div>
    </article>
  );
}
```

## Common Aspect Ratios

- **16/9**: Widescreen video/images (YouTube standard)
- **4/3**: Traditional photos
- **1/1**: Square images (social media profiles)
- **21/9**: Ultra-wide hero images
- **3/2**: Standard photo print ratio

## Testing

To verify CLS < 0.1:

1. Open Chrome DevTools
2. Go to Performance tab
3. Record page load
4. Check "Experience" section for CLS score
5. Should see green (< 0.1) for good performance
