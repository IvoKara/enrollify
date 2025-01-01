<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LessonContentsResource\RelationManagers\LessonRelationManager;
use App\Filament\Resources\LessonResource\Pages;
use App\Filament\Traits\FiltersByCurrentUser;
use App\Models\Lesson;
use Carbon\CarbonInterval;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LessonResource extends Resource
{
    use FiltersByCurrentUser;

    protected static ?string $model = Lesson::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make()->schema([
                        TextInput::make('title')
                            ->required()
                            ->label('Title'),
                        TextInput::make('meta_description')
                            ->required()
                            ->label('Meta Description'),

                        RichEditor::make('overview')
                            ->required()
                            ->label('Overview'),
                    ]),

                ])
                    ->columnSpan(2)
                    ->columnStart(1),

                Group::make()->schema([
                    Section::make('Course')->schema([
                        Toggle::make('is_free')
                            ->label('Is Free')
                            ->onIcon('heroicon-o-check')
                            ->offIcon('heroicon-o-currency-dollar'),
                        Select::make('course_id')
                            ->relationship('course', 'title')
                            ->searchable()
                            ->required()
                            ->native(false),
                    ]),

                    Section::make('Duration')->schema([
                        TextInput::make('duration')
                            ->integer()
                            ->helperText('Duration in minutes')
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, Set $set) {
                                $set('duration_for_humans', CarbonInterval::minutes($state)->cascade()->forHumans());
                            }),
                        TextInput::make('duration_for_humans')
                            ->dehydrated()
                            ->disabled()
                            ->helperText('Duration in readable format'),
                    ]),
                ])
                    ->columnSpan(1)
                    ->columnStart(3),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->size(TextColumnSize::Large)
                    ->weight(FontWeight::Bold),
                IconColumn::make('is_free')
                    ->boolean()
                    ->label('Free'),
                TextColumn::make('meta_description')
                    ->searchable()
                    ->label('Meta Description'),
                TextColumn::make('duration')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => CarbonInterval::minutes($state)->cascade()->forHumans()),
                TextColumn::make('course.title')
                    ->searchable()
                    ->url(
                        fn (Lesson $record) => route(
                            'filament.admin.resources.courses.edit',
                            ['record' => $record->course->id]
                        )
                    )
                    ->color('primary')
                    ->icon('heroicon-m-arrow-top-right-on-square')
                    ->iconPosition(IconPosition::After)
                    ->label('Course'),
            ])
            ->filters([
                Filter::make('Filter By Duration')->form([
                    TextInput::make('min_duration')
                        ->numeric()
                        ->placeholder('Min Duration'),
                    TextInput::make('max_duration')
                        ->numeric()
                        ->placeholder('Max Duration'),
                ])->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['min_duration'],
                            fn (Builder $query, $value) => $query->where('duration', '>=', $value),
                        )
                        ->when(
                            $data['max_duration'],
                            fn (Builder $query, $value) => $query->where('duration', '<=', $value),
                        );
                }),
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

    public static function getRelations(): array
    {
        return [
            LessonRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLessons::route('/'),
            'create' => Pages\CreateLesson::route('/create'),
            'edit' => Pages\EditLesson::route('/{record}/edit'),
        ];
    }
}
