<?php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use Carbon\CarbonInterval;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Table;

class LessonsRelationManager extends RelationManager
{
    protected static string $relationship = 'lessons';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->size(TextColumnSize::Large)
                    ->weight(FontWeight::Bold),
                Tables\Columns\TextColumn::make('meta_description')
                    ->searchable()
                    ->label('Meta Description'),
                Tables\Columns\TextColumn::make('duration')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => CarbonInterval::seconds($state)->cascade()->forHumans()),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Create New Lesson')
                    ->url(function () {
                        return route('filament.admin.resources.lessons.create');
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Edit Lesson')
                    ->url(fn ($record) => route('filament.admin.resources.lessons.edit', ['record' => $record->id])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
