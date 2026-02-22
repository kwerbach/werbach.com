import type { Config } from 'tailwindcss'

export default {
  content: [
    "./index.html",
    "./src/**/*.{js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        citron: {
          DEFAULT: '#bbbe64',
          100: '#282911',
          200: '#505222',
          300: '#797b33',
          400: '#a1a445',
          500: '#bbbe64',
          600: '#c9cb83',
          700: '#d6d8a2',
          800: '#e4e5c1',
          900: '#f1f2e0'
        },
        teal: {
          DEFAULT: '#468189',
          100: '#0e1a1c',
          200: '#1c3437',
          300: '#2b4e53',
          400: '#39686e',
          500: '#468189',
          600: '#60a4ad',
          700: '#88bbc2',
          800: '#b0d2d6',
          900: '#d7e8eb'
        },
        beige: {
          DEFAULT: '#eaf0ce',
          100: '#3b4415',
          200: '#77882a',
          300: '#aec645',
          400: '#ccdb88',
          500: '#eaf0ce',
          600: '#edf3d6',
          700: '#f2f6e1',
          800: '#f6f9eb',
          900: '#fbfcf5'
        },
        english_violet: {
          DEFAULT: '#443850',
          100: '#0e0b10',
          200: '#1c1720',
          300: '#292231',
          400: '#372d41',
          500: '#443850',
          600: '#6a577d',
          700: '#8f7ba3',
          800: '#b5a7c2',
          900: '#dad3e0'
        },
        black: {
          DEFAULT: '#050609',
          100: '#010102',
          200: '#020304',
          300: '#030406',
          400: '#040508',
          500: '#050609',
          600: '#29314a',
          700: '#4c5b8a',
          800: '#7f8eb9',
          900: '#bfc6dc'
        }
      },
      fontFamily: {
        mono: ['JetBrains Mono', 'Consolas', 'Monaco', 'monospace'],
      },
      typography: {
        DEFAULT: {
          css: {
            maxWidth: '65ch',
          },
        },
      },
    },
  },
  plugins: [
    // @ts-ignore
    require('@tailwindcss/typography'),
  ],
} satisfies Config
