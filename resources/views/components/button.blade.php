@props([
    'type' => 'button',
    'variant' => 'primary',
    'colors' => [
        'primary' => 'bg-blue-500',
    ]
])

<button {{$attributes->merge(['class' => "{$colors[$variant]} h-10 self-center hover:bg-blue-700 text-white font-bold py-2 px-4 rounded real-timef"]) }}>
    {{$slot}}
</button>
