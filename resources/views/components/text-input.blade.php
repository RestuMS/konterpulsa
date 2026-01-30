@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'bg-white/10 border-gray-600 focus:border-pink-500 focus:ring-pink-500 rounded-xl shadow-sm text-white placeholder-white/50']) !!}>
