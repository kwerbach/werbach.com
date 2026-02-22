import { Linkedin } from 'lucide-react';

export default function Footer() {
  return (
    <footer className="bg-[#020617] mt-16 text-white">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div className="flex items-center justify-center gap-4 flex-wrap">
          <a
            href="https://lgst.wharton.upenn.edu/profile/werbach/"
            target="_blank"
            rel="noopener noreferrer"
            className="text-beige-700 hover:text-citron transition-colors text-sm"
          >
            Wharton Profile
          </a>
          <a
            href="https://www.linkedin.com/in/kevinwerbach/"
            target="_blank"
            rel="noopener noreferrer"
            className="text-beige-700 hover:text-citron transition-colors"
            aria-label="LinkedIn"
          >
            <Linkedin size={18} />
          </a>
          <a
            href="https://x.com/kwerb"
            target="_blank"
            rel="noopener noreferrer"
            className="text-beige-700 hover:text-citron transition-colors"
            aria-label="X (formerly Twitter)"
          >
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
              <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
            </svg>
          </a>
          <a
            href="https://bsky.app/profile/kwerb.com"
            target="_blank"
            rel="noopener noreferrer"
            className="text-beige-700 hover:text-citron transition-colors"
            aria-label="Bluesky"
          >
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
              <path d="M12 10.8c-1.087-2.114-4.046-6.053-6.798-7.995C2.566.944 1.561 1.266.902 1.565.139 1.908 0 3.08 0 3.768c0 .69.378 5.65.624 6.479.815 2.736 3.713 3.66 6.383 3.364.136-.02.275-.038.415-.05-.138.012-.277.024-.415.036-3.912.277-7.394 1.643-6.372 4.331.427.84 1.671 1.347 3.156 1.347 2.921 0 5.784-1.98 7.209-5.185.068-.153.128-.312.184-.473.056.161.116.32.184.473 1.425 3.205 4.288 5.185 7.209 5.185 1.485 0 2.729-.507 3.156-1.347 1.022-2.688-2.46-4.054-6.372-4.331-.138-.012-.277-.024-.415-.036.14.012.279.03.415.05 2.67.296 5.568-.628 6.383-3.364.246-.829.624-5.79.624-6.479 0-.688-.139-1.86-.902-2.203-.659-.299-1.664-.621-4.3 1.24C16.046 4.747 13.087 8.686 12 10.8z"/>
            </svg>
          </a>
          <a
            href="http://creativecommons.org/licenses/by/4.0/"
            target="_blank"
            rel="noopener noreferrer"
            className="hover:opacity-80 transition-opacity"
            aria-label="Creative Commons Attribution 4.0 International License"
          >
            <img
              src="https://mirrors.creativecommons.org/presskit/buttons/88x31/png/by.png"
              alt="Creative Commons Attribution 4.0 International License"
              className="w-12 h-auto"
            />
          </a>
        </div>
      </div>
    </footer>
  );
}
