<?php

namespace App\Filament\Resources\LessonContentsResource\RelationManagers;

use App\Models\LessonContent;
use App\Models\Text;
use App\Models\Video;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Table;

class LessonRelationManager extends RelationManager
{
    protected static string $relationship = 'contents';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('contentable_type')
                    ->label('Content Type')
                    ->options([
                        Text::class => 'Text',
                        Video::class => 'Video',
                    ])
                    ->reactive()
                    ->afterStateUpdated(function ($set, $state) {
                        $set('contentable_id', null);
                    }),
                Forms\Components\Select::make('contentable_id')
                    ->label('Content ID')
                    ->options(function (callable $get) {
                        $modelClass = $get('contentable_type');

                        return $modelClass ? $modelClass::query()->pluck('id', 'id') : [];
                    })
                    ->reactive()
                    ->visible(fn (callable $get) => $get('contentable_type') !== null),
                Forms\Components\TextInput::make('order')
                    ->default(function () {
                        $lessonId = $this->getRelationship()->getParent()->id;
                        $maxOrder = LessonContent::where('lesson_id', $lessonId)->max('order');

                        return is_null($maxOrder) ? 1 : $maxOrder + 1;
                    }),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->reorderable('order')
            ->columns([
                Tables\Columns\TextColumn::make('lesson_id'),
                Tables\Columns\TextColumn::make('contentable_id'),
                Tables\Columns\TextColumn::make('contentable_type')
                    ->label('Type')
                    ->icon(fn (string $state) => match ($state) {
                        Text::class => 'heroicon-o-document-text',
                        Video::class => 'heroicon-o-video-camera',
                    })
                    ->iconPosition(IconPosition::After)
                    ->iconColor(fn (string $state) => match ($state) {
                        Text::class => 'info',
                        Video::class => 'success',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        Text::class => 'Text',
                        Video::class => 'Video',
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
