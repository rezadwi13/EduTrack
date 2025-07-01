@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-[#FF2D20] focus:ring-[#FF2D20] rounded-xl shadow-sm']) }}>
