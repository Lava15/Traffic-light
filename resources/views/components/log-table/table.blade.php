@php
    use App\Enums\TrafficLightEnums
@endphp

@props(['logs'])

<table id="log-table" {{ $attributes->merge(['class' => 'rounded-t-lg m-5 w-5/6 mx-auto bg-gray-200 text-gray-800']) }}>
    <tr class="text-left border-b-2 border-gray-300">
        <th class="px-4 py-3 text-center">{{ __('Статус') }}</th>
        <th class="px-4 py-3 text-center">{{ __('Описание') }}</th>
        <th class="px-4 py-3 text-center">{{ __('Время') }}</th>
    </tr>

    @foreach($logs as $log)
        <x-log-table.row>
            <x-log-table.data-cell>
                <span class="px-5 {{ TrafficLightEnums::tryFrom($log->status->value)->colors() }} "></span>
            </x-log-table.data-cell>
            <x-log-table.data-cell>{{ $log->message }}</x-log-table.data-cell>
            <x-log-table.data-cell>{{ $log->created_at->format('d.m.Y h:i:s') }}</x-log-table.data-cell>
        </x-log-table.row>
    @endforeach
</table>
