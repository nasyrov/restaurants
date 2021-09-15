
@props(['disabled' => false])

<input {{ $attributes->merge(['class' => 'focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md', 'type' => 'text']) }} {{ $disabled ? 'disabled' : '' }}>
