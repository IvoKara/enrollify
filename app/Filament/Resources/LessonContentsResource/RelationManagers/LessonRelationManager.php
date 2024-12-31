<?php

namespace App\Filament\Resources\LessonContentsResource\RelationManagers;

use App\Models\LessonContent;
use App\Models\Text;
use App\Models\Video;
use Awcodes\Curator\Models\Media;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LessonRelationManager extends RelationManager
{
    protected static string $relationship = 'contents';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make()->schema([
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
                        ->searchable()
                        ->label('Content Title')
                        ->helperText('Choose your content by title.')
                        ->options(function (callable $get) {
                            $modelClass = $get('contentable_type');

                            return $modelClass ? $modelClass::query()->pluck('title', 'id') : [];
                        })
                        ->reactive()
                        ->visible(fn (callable $get) => $get('contentable_type') !== null)
                        ->native(false),
                ])
                    ->columns(1)
                    ->columnSpan(3)
                    ->columnStart(1),
                Forms\Components\Fieldset::make()->schema([
                    Forms\Components\TextInput::make('order')
                        ->default(function () {
                            $lessonId = $this->getRelationship()->getParent()->id;
                            $maxOrder = LessonContent::where('lesson_id', $lessonId)->max('order');

                            return is_null($maxOrder) ? 1 : $maxOrder + 1;
                        }),
                ])
                    ->columns(1)
                    ->columnSpan(1)
                    ->columnStart(4),
            ])->columns(4);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->reorderable('order')
            ->columns([
                Tables\Columns\TextColumn::make('order')
                    ->badge()
                    ->color('primary'),
                Tables\Columns\ImageColumn::make('image')
                    ->label('Image')
                    ->getStateUsing(fn (LessonContent $record) => match ($record->contentable_type) {
                        Text::class => Media::find(Text::find($record->contentable_id)->media_id)->path,
                        Video::class => Video::find($record->contentable_id)->thumbnail(),
                        default => '',
                    })
                    ->width(120)
                    ->height(80),
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->getStateUsing(fn (LessonContent $record) => match ($record->contentable_type) {
                        Text::class => Text::find($record->contentable_id)->title,
                        Video::class => Video::find($record->contentable_id)->title,
                    })
                    ->words(10)
                    ->lineClamp(3)
                    ->size(TextColumnSize::Large)
                    ->weight(FontWeight::Bold),
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
                Tables\Filters\SelectFilter::make('contentable_type')
                    ->options([
                        Text::class => 'Text',
                        Video::class => 'Video',
                    ])
                    ->label('Content Type'),
                Tables\Filters\Filter::make('Filter By Order')->form([
                    Forms\Components\TextInput::make('min_order_number')
                        ->numeric()
                        ->placeholder('Min Order Number'),
                    Forms\Components\TextInput::make('max_order_number')
                        ->numeric()
                        ->placeholder('Max Order Number'),
                ])->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['min_order_number'],
                            fn (Builder $query, $value) => $query->where('order', '>=', $value),
                        )
                        ->when(
                            $data['max_order_number'],
                            fn (Builder $query, $value) => $query->where('order', '<=', $value),
                        );
                }),
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
