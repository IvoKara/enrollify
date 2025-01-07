<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    use BaseDashboard\Concerns\HasFiltersForm;

    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\AccountWidget::class,
            \App\Filament\Widgets\StatsOverviewWidget::class,
        ];
    }

    public function getColumns(): int|string|array
    {
        return 1;
    }
}
