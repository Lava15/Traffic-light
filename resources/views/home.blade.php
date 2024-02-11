{{--Имортируем TrafficLightEnums для использования значений в шаблоне--}}
@php
    use App\Enums\TrafficLightEnums
@endphp
<x-app>
    <div class="text-center mt-5 md:flex justify-around aligh-center">
        <div class="mb-4 border p-5 border-black">
            @foreach(TrafficLightEnums::cases() as $light)
                <x-light
                    id="{{ $light->value }}"
                    :type="TrafficLightEnums::from($light->value)->colors()"
                />
            @endforeach
        </div>

        <x-button variant="primary" id="go-button" type="submit">{{__('Вперед')}}</x-button>
    </div>

    <!-- Компонент таблицы логов-->
    <x-log-table.table :logs="$logs"/>

    <!-- Пагинация -->
    <div class="max-w-4xl mx-auto">
        {{ $logs->links() }}
    </div>

    <!-- Загружаем скрипты как компонент -->
    @include('components.scripts')

</x-app>
