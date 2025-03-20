<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\SensorData;

class SensorController extends Controller
{
    const array PARAM_KEYS = ['T', 'P', 'V'];

    public function store(Request $request): JsonResponse
    {
        $sensorId = $request->query('sensor');
        $params = $request->except('sensor') ?? [];
        $parameter = null;
        $value = null;

        foreach ($params as $k => $v) {
            if (in_array($k, static::PARAM_KEYS)) {
                $parameter = $k;
                $value = floatval($v);
            }
        }

        if (empty($sensorId) || empty($params) || empty($parameter) || empty($value)) {
            return response()->json(['message' => 'Invalid request parameters'], 422);
        }

        SensorData::query()->create([
            'sensor_id' => $sensorId,
            'parameter' => $parameter,
            'value' => $value,
        ]);

        return response()->json(['message' => 'Saved successfully'], 200);
    }

    public function history(Request $request): JsonResponse
    {
        $sensorId = $request->query('sensor');
        $startDate = Carbon::parse($request->query('start_date'))->startOfDay();
        $endDate = Carbon::parse($request->query('end_date'))->endOfDay();

        if (empty($sensorId)) {
            return response()->json(['message' => 'Invalid request parameters'], 422);
        }

        $data = SensorData::query()->select([
            'sensor_id',
            'parameter',
            'value',
            'created_at',
        ])
            ->where('sensor_id', $sensorId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderByDesc('created_at')
            ->get();

        return response()->json($data, 200);
    }
}
