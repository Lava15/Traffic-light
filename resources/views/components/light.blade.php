@props([
    'type',
    'id'=> ''
])

<div
        id="light-{{$id}}"
        {{ $attributes->merge(['class' => "w-16 h-16 $type rounded-full mx-auto opacity-25 real-time"]) }}
></div>

