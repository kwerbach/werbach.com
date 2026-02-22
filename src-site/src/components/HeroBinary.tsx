import { motion } from 'framer-motion';
import { useEffect, useState, useMemo } from 'react';

interface HeroBinaryProps {
  density?: 'normal' | 'narrow';
  className?: string;
}

export default function HeroBinary({ density = 'normal', className = '' }: HeroBinaryProps) {
  const [prefersReducedMotion, setPrefersReducedMotion] = useState(false);

  useEffect(() => {
    // Check for prefers-reduced-motion
    const mediaQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
    setPrefersReducedMotion(mediaQuery.matches);

    const handleChange = (e: MediaQueryListEvent) => {
      setPrefersReducedMotion(e.matches);
    };

    mediaQuery.addEventListener('change', handleChange);
    return () => mediaQuery.removeEventListener('change', handleChange);
  }, []);

  // Generate static binary grid - memoized to prevent regeneration and glitching
  const meshGrid = useMemo(() => {
    const rows = density === 'narrow' ? 10 : 20;
    const cols = density === 'narrow' ? 30 : 50;
    const grid = [] as Array<{id:string; value:string; row:number; col:number; x:number; y:number; delay:number}>;
    for (let row = 0; row < rows; row++) {
      for (let col = 0; col < cols; col++) {
        grid.push({
          id: `${row}-${col}`,
          value: Math.random() > 0.5 ? '1' : '0',
          row,
          col,
          x: col * (density === 'narrow' ? 28 : 30),
          y: row * (density === 'narrow' ? 32 : 35),
          delay: (row + col) * 0.02
        });
      }
    }
    return grid;
  }, []);

  return (
    <div className={`absolute inset-0 overflow-hidden bg-black text-white pointer-events-none ${className}`}>
      {/* Static Binary Mesh - Full page background */}
      <div aria-hidden="true" className="absolute inset-0 opacity-40">
        {meshGrid.map((digit) => {
          return (
            <motion.span
              key={digit.id}
              initial={{ opacity: 0 }}
              animate={{ 
                opacity: prefersReducedMotion ? 0.5 : [0.3, 0.6, 0.3]
              }}
              transition={prefersReducedMotion ? { duration: 0 } : {
                duration: 6,
                repeat: Infinity,
                delay: digit.delay,
                ease: "easeInOut"
              }}
              className="absolute text-lg font-mono text-citron"
              style={{
                left: digit.x,
                top: digit.y,
                textShadow: '0 0 10px rgba(187, 190, 100, 0.6)'
              }}
            >
              {digit.value}
            </motion.span>
          );
        })}
      </div>

      {/* Flowing binary streams (background layer) */}
      <div aria-hidden="true" className="absolute inset-0 opacity-25">
        {Array.from({ length: 8 }).map((_, i) => (
          <motion.div
            key={`stream-${i}`}
            initial={{ y: -100, opacity: 0 }}
            animate={prefersReducedMotion ? { y: -100, opacity: 0 } : {
              y: ['0%', '120%'],
              opacity: [0, 1, 0]
            }}
            transition={prefersReducedMotion ? { duration: 0 } : {
              duration: 5 + i * 0.5,
              repeat: Infinity,
              delay: i * 0.7,
              ease: "linear"
            }}
            className="absolute text-sm font-mono text-teal-500"
            style={{ left: `${i * 12}%` }}
          >
            {Array.from({ length: 20 }, () => Math.random() > 0.5 ? '1' : '0').map((bit, idx) => (
              <div key={idx} className="leading-6">{bit}</div>
            ))}
          </motion.div>
        ))}
      </div>
    </div>
  );
}
