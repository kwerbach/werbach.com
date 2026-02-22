import clsx from 'clsx';

interface ProseProps {
  children: React.ReactNode;
  className?: string;
}

export default function Prose({ children, className }: ProseProps) {
  return (
    <div className={clsx(
      'prose prose-lg prose-invert max-w-none',
      'prose-headings:text-white prose-headings:font-semibold',
      'prose-p:text-beige-700 prose-p:leading-relaxed',
      'prose-strong:text-white prose-strong:font-semibold',
      'prose-em:text-beige-700 prose-em:italic',
      'prose-li:text-beige-700 prose-li:leading-relaxed',
      'prose-a:text-green-500 prose-a:no-underline hover:prose-a:text-green-400',
      'prose-code:text-green-400 prose-code:bg-english_violet-600 prose-code:px-1.5 prose-code:py-0.5 prose-code:rounded',
      'prose-blockquote:border-l-green-600 prose-blockquote:text-beige-700 prose-blockquote:italic',
      className
    )}>
      {children}
    </div>
  );
}
