<?php

namespace App\Http\Controllers;

use App\Enums\TrafficLightEnums;
use App\Http\Requests\TrafficForwardRequest;
use App\Models\TrafficLightLog;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class TrafficLightController extends Controller
{
    /**
     * @return View
     * Передаем в шаблон логи
     */
    public function index(): View
    {
        /*
         * Берем из базы последние логи, и делаем пагинацию по 10
         */
        $trafficLightLogs = TrafficLightLog::query()->latest()->paginate(10);
        /*
         * Возврашаем шаблон home с логами
         */
        return view('home', ['logs' => $trafficLightLogs]);
    }

    /**
     * @param TrafficForwardRequest $request
     * @return JsonResponse|void
     * Функия управление кнопкой Вперед!
     * Если данные проходят проверку записываем в базу,
     * и передаем обратно в таблицу с логами
     */

    public function forward(TrafficForwardRequest $request): JsonResponse
    {
        if ($request->validated()) {
            $currentColor = $request->input('current_color');
            $isYellowAfterGreen = $request->input('is_yellow_after_green', true) === 'true'; // String to boolean conversion

            // Определяем сообщение в зависимости от цвета и последовтельности
            $message = match ($currentColor) {
                TrafficLightEnums::RED->value => TrafficLightEnums::RED->warning(),
                TrafficLightEnums::GREEN->value => TrafficLightEnums::GREEN->warning(),
                TrafficLightEnums::YELLOW->value => $isYellowAfterGreen
                    ? TrafficLightEnums::YELLOW->warning()
                    : TrafficLightEnums::YELLOW_AFTER_RED->warning(),
            };

            // Создаем запись в базу
            $logEntry = TrafficLightLog::create([
                'status' => $currentColor,
                'message' => $message,
            ]);

            // Возвращаем новый лог в JSON формате для отображения в реальном времени
            return response()->json($logEntry);
        }
    }
}
