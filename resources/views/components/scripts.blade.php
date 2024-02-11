{{--Имортируем TrafficLightEnums для использования значений в шаблоне--}}
@php
    use App\Enums\TrafficLightEnums
@endphp

@push('scripts')
    <script>
        $(document).ready(function () {
            // Оппеделяем цвета светофора из инамов
            const trafficLightEnums = {
                RED: '{{ TrafficLightEnums::RED }}',
                YELLOW: '{{ TrafficLightEnums::YELLOW }}',
                GREEN: '{{ TrafficLightEnums::GREEN }}'
            };

            // Оппеделяем интервал светофора из инамов
            const lightDurations = {
                green: {{ TrafficLightEnums::GREEN->interval() }},
                yellow: {{ TrafficLightEnums::YELLOW->interval() }},
                red: {{ TrafficLightEnums::RED->interval() }}
            };

            // Текущий цвет светофора
            let currentColor = trafficLightEnums.GREEN;

            // Состовние для отслеживания желтово цвета , по умолчанию после зеленого = true, после красного = false
            let isYellowAfterGreen = true;

            // берем светофоры по ID для манипульяций
            const lights = {
                green: $('#light-green'),
                yellow: $('#light-yellow'),
                red: $('#light-red')
            };

            // Берем сообщения из инамов
            const warnings = {
                red: '{{ TrafficLightEnums::RED->warning() }}',
                yellow: '{{ TrafficLightEnums::YELLOW->warning() }}',
                green: '{{ TrafficLightEnums::GREEN->warning() }}',
                yellow_after_red: '{{ TrafficLightEnums::YELLOW_AFTER_RED->warning() }}'
            };

            // Обновление цветов светофора
            function updateLightDisplay() {
                $.each(lights, function (_, light) {
                    // Выключаем светофоры по умолчанию
                    light.css({opacity: 0.10});
                });
                // Включаем в зависимости от текущего цвета
                lights[currentColor].css({opacity: 1});
            }


            // Функция включения светофора
            function switchLights() {
                updateLightDisplay();
                // Следющий цвет
                let nextColor;
                // Длительность светофоров
                let duration = lightDurations[currentColor];

                setTimeout(() => {
                    switch (currentColor) {
                        case trafficLightEnums.GREEN:
                            nextColor = trafficLightEnums.YELLOW;
                            isYellowAfterGreen = true;
                            break;
                        case trafficLightEnums.YELLOW:
                            nextColor = isYellowAfterGreen ? trafficLightEnums.RED : trafficLightEnums.GREEN;
                            isYellowAfterGreen = !isYellowAfterGreen;
                            break;
                        case trafficLightEnums.RED:
                            nextColor = trafficLightEnums.YELLOW;
                            break;
                    }

                    currentColor = nextColor;
                    switchLights();
                }, duration);
            }

            // Запуск цикла светофора
            switchLights();

            // Кнопка вперед
            $('#go-button').on('click', function (event) {
                event.preventDefault();

                // Сообщение для записи в логи
                let message = warnings[currentColor];

                // Условия определения желтого цвета , после зеленого или красного
                if (currentColor === trafficLightEnums.YELLOW) {
                    message = isYellowAfterGreen ? warnings.yellow : warnings.yellow_after_red;
                }
                // Аякс запрос на сервер для создания логов
                $.ajax({
                    url: '{{ route("forward") }}',
                    type: 'POST',
                    data: {
                        current_color: currentColor,
                        is_yellow_after_green: isYellowAfterGreen,
                        message: message,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        //  Форматируем время
                        const dateStr = new Date(response.created_at).toLocaleString('ru-RU', {
                            year: 'numeric',
                            month: '2-digit',
                            day: '2-digit',
                            hour: '2-digit',
                            minute: '2-digit',
                            second: '2-digit'
                        }).split(', ').join(' ');

                        // Добавляем логи в таблицу
                        $("#log-table").append(
                            `<x-log-table.row>
                                <x-log-table.data-cell>
                                    <span class="px-5 bg-${currentColor}-500"></span>
                                </x-log-table.data-cell>
                                <x-log-table.data-cell>
                                    ${response.message}
                                </x-log-table.data-cell>
                                <x-log-table.data-cell>
                                    ${dateStr}
                                </x-log-table.data-cell>
                            </x-log-table.row>`,
                        );
                    }
                });
            });
        });

    </script>
@endpush
