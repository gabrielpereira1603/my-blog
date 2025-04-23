@props(['disabled' => false])

<input
    @disabled($disabled)
    {{ $attributes->merge([
        'class' => 'border-[#14B8A6] bg-white text-gray-800 focus:border-[#14B8A6] focus:ring-[#14B8A6] rounded-md shadow-sm transition duration-200'
    ]) }}
/>
