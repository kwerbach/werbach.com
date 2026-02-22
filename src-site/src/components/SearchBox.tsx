interface SearchBoxProps {
  value: string;
  onChange: (value: string) => void;
  placeholder?: string;
}

export default function SearchBox({ value, onChange, placeholder = 'Search...' }: SearchBoxProps) {
  return (
    <div className="mb-8">
      <input
        type="text"
        value={value}
        onChange={(e) => onChange(e.target.value)}
        placeholder={placeholder}
        className="w-full px-4 py-2 bg-english_violet-600 border border-english_violet-300 text-white placeholder-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
      />
    </div>
  );
}
