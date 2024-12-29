<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LessonContentsResource\RelationManagers\LessonRelationManager;
use App\Filament\Resources\LessonResource\Pages;
use App\Models\Lesson;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LessonResource extends Resource
{
    protected static ?string $model = Lesson::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                    TextInput::make('title')
                        ->required()
                        ->label('Title'),
                    TextInput::make('meta_description')
                        ->required()
                        ->label('Meta Description'),
                    TextInput::make('duration')
                        ->integer()
                        ->required()
                        ->label('Duration'),
                    RichEditor::make('overview')
                        ->required()
                        ->label('Overview'),
                    Checkbox::make('is_free'),
                    Select::make('course_id')
                        ->relationship('course', 'title')
                        ->searchable()
                        ->required(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable(),
                IconColumn::make('is_free')
                    ->boolean()
                    ->label('Free'),
                TextColumn::make('meta_description')
                    ->searchable()
                    ->label('Meta Description'),
                TextColumn::make('duration')->sortable(),
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
                        ->placeholder('Maz Duration'),
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
