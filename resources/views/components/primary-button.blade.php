<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-3 bg-gradient-to-r from-pink-500 to-orange-500 hover:from-pink-600 hover:to-orange-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition ease-in-out duration-150 shadow-lg']) }}>
    {{ $slot }}
</button>
