<?php

namespace Admin\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Charts
{
    public function __invoke(): array
    {
        return [
            'chart_customers_yearly' => $this->chartCustomersYearly(),
        ];
    }

    protected function getTodayEndDate()
    {
        return today()->add('23 Hours 59 Minutes 59 Seconds');

        return today()->add('18 Hours 59 Minutes 59 Seconds');
    }

    protected function chartCustomersYearly()
    {
        $query = DB::table('users');

        $query->select(DB::raw("date_format(users.created_at + INTERVAL 0 HOUR, '%Y-%m') as date_result, count(users.id) as aggregate"))
                ->whereBetween('users.created_at', [today()->startOfYear(), today()->endOfYear()])
                ->whereNotNull('stripe_id')
                ->groupBy(DB::raw("date_format(users.created_at + INTERVAL 0 HOUR, '%Y-%m')"))
                ->orderBy('date_result');

        $results = $query->get();

        $array = $results->map(function ($item) {
            return [Carbon::parse($item->date_result)->format('M') => $item->aggregate];
        });

        $data = $array->collapse();

        $months = [];

        for ($i = 0; $i < 12; $i++) {
            $day = today()->month($i + 1)->format('M');
            $months[$day] = $data[$day] ?? 0;
        }

        return $months;
    }
}
