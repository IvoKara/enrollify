<?php

namespace App\Filament\Resources\LessonResource\Pages;

use App\Filament\Resources\LessonResource;
use Carbon\CarbonInterval;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Livewire\Attributes\On;

class EditLesson extends EditRecord
{
    protected static string $resource = LessonResource::class;

    #[On('refreshDuration')]
    public function recalculateDuration()
    {
        $record = $this->form->getRecord();
        $duration = $record->duration;
        $this->form->fill([
            'duration' => $duration,
            'duration_for_humans' => CarbonInterval::second($duration)->cascade()->forHumans(),
            'title' => $record->title,
            'meta_description' => $record->meta_description,
            'overview' => $record->overview,
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
