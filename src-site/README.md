# Kevin Werbach Website

A modern, content-driven website built with React, Tailwind CSS, and Decap CMS, deployed on Netlify.

## Tech Stack

- **Frontend**: React 19 + TypeScript
- **Styling**: Tailwind CSS v4 + @tailwindcss/typography
- **Routing**: React Router DOM
- **Animations**: Framer Motion
- **CMS**: Decap CMS (GitHub backend)
- **Content**: Markdown with frontmatter (gray-matter)
- **Build Tool**: Vite
- **Deployment**: Netlify

## Project Structure

```
kevinwerbach/
├── src/
│   ├── components/        # Reusable UI components
│   ├── pages/            # Page components
│   ├── App.tsx           # Main app with routing
│   └── main.tsx          # Entry point
├── content/              # Markdown content
│   ├── papers/, essays/, policy/, projects/
│   ├── books/, teaching/courses/
│   ├── podcast/episodes/
│   └── media/ (press/, video/)
├── public/
│   ├── admin/            # Decap CMS
│   └── uploads/          # Media uploads
└── netlify.toml          # Netlify configuration
```

## Development

```bash
# Install dependencies
npm install

# Run development server
npm run dev

# Build for production
npm run build

# Preview production build
npm run preview
```

## CMS Access

The Decap CMS admin interface is available at `/admin`. It uses GitHub as the backend.

### Setting up GitHub OAuth (Netlify)

1. Go to Netlify site settings
2. Navigate to Access control > OAuth
3. Install GitHub provider
4. Grant access to your repository

## Deployment

Connect your GitHub repository to Netlify. Build settings are configured in `netlify.toml`.

## Features

- **Binary Hero Animation**: Animated binary grid on hero sections using Framer Motion
- **Content Filtering**: Tag-based filtering and search functionality
- **Responsive Design**: Mobile-first design with Tailwind CSS
- **CMS-Powered**: Manage content via Decap CMS
- **Fast Performance**: Vite build system

## TODO for Production

1. Implement actual markdown file loading (currently using mock data)
2. Integrate Fuse.js for fuzzy search
3. Load content dynamically based on URL slugs
4. Add image optimization
5. Add SEO meta tags and structured data
6. Implement contact form backend
7. Create custom 404 page

## License

© 2024 Kevin Werbach. All rights reserved.

