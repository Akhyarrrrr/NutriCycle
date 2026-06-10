@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'rounded-lg border-slate-300 shadow-sm focus:border-green-600 focus:ring-green-600']) }}>
