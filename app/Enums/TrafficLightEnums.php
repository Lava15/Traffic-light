<?php

namespace App\Enums;

/**
 * Через ENUM все параметры будут задаваться
 */
enum TrafficLightEnums: string
{
    /*
     * Создаем кейсы со цветами
     */
    case RED = 'red';
    case YELLOW = 'yellow';
    case GREEN = 'green';
    case YELLOW_AFTER_RED = 'yellow_after_red';

    /**
     * @return int
     * задаем интервал
     */
    public function interval(): int
    {
        return match ($this) {
            self::RED => 5000,
            self::YELLOW => 2000,
            self::GREEN => 5000,
        };
    }

    /**
     * @return string
     * задаем цвета светофора
     */
    public function colors(): string
    {
        return match ($this) {
            self::RED => 'bg-red-500',
            self::YELLOW => 'bg-yellow-500',
            self::GREEN => 'bg-green-500',
            self::YELLOW_AFTER_RED => '',
        };
    }

    /**
     * @return string
     * Задаем сообщения для записи в логи в зависимости от цвета
     */
    public function warning(): string
    {
        return match ($this) {
            self::RED => __('Проезд на красный. Штраф!'),
            self::YELLOW => __('Успели на желтый!'),
            self::GREEN => __('Проезд на зеленый!'),
            self::YELLOW_AFTER_RED => __('Слишком рано начали движение!'),
        };
    }
}
