import clsx from 'clsx';

interface TagProps {
  label: string;
  active?: boolean;
  onClick?: () => void;
}

export default function Tag({ label, active, onClick }: TagProps) {
  return (
    <button
      onClick={onClick}
      className={clsx(
        'px-3 py-1 text-sm rounded-full transition-colors',
        active
          ? 'bg-blue-600 text-white'
          : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
      )}
    >
      {label}
    </button>
  );
}
