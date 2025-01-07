<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class StatsOverviewWidget extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 0;

    protected int $multiplier = 10;

    protected function getColumns(): int
    {
        return 2;
    }

    protected function getStats(): array
    {

        $paidCourses = auth()->user()->courses()->where('is_free', false)->with('lessons')->get();
        $totalPrice = $paidCourses->pluck('price')->sum();
        $revenue = (int) ($totalPrice * $this->multiplier);

        $paidLessons = $paidCourses->pluck('lessons')->flatten()->count();
        $viewers = (int) ($paidLessons * $this->multiplier * 12);

        return [
            Stat::make('Revenue from courses', '$'.$this->formatNumber($revenue))
                ->description('3% increase')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make('New viewers', $this->formatNumber($viewers))
                ->description('1% decrease')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->chart([12, 13, 14, 15, 14, 13, 13])
                ->color('danger'),
        ];
    }

    protected function formatNumber(float|int $number): string
    {
        if ($number < 1000) {
            return (string) Number::format($number, 0);
        }

        if ($number < 1000000) {
            return Number::format($number / 1000, 2).'k';
        }

        return Number::format($number / 1000000, 2).'m';
    }
}
