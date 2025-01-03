<?php

namespace App\Filament\Resources;

use App\Enums\CourseStatus;
use App\Filament\Resources\CourseResource\Pages;
use App\Filament\Traits\FiltersByCurrentUser;
use App\Models\Course;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Awcodes\Curator\Components\Tables\CuratorColumn;
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
use Filament\Support\Enums\FontFamily;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CourseResource extends Resource
{
    use FiltersByCurrentUser;

    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make()->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(debounce: 500)
                            ->afterStateUpdated(function (string $operation, $state, Set $set) {
                                $set('slug', Str::slug($state));
                            }),
                        TextInput::make('slug')
                            ->dehydrated()
                            ->required()
                            ->unique(Course::class, 'slug', ignoreRecord: true),

                        RichEditor::make('description')
                            ->required()
                            ->columnSpan('full'),
                    ])->columns(2),

                    Section::make('Image')->schema([
                        CuratorPicker::make('media_id')->label('Image'),
                    ]),
                ])
                    ->columnSpan(2)
                    ->columnStart(1),

                Group::make()->schema([
                    Section::make('Pricing')->schema([
                        Toggle::make('is_free')
                            ->reactive()
                            ->label('Is Free')
                            ->onIcon('heroicon-o-check')
                            ->offIcon('heroicon-o-currency-dollar')
                            ->afterStateUpdated(function ($set, $state) {
                                if ($state) {
                                    $set('price', null); // Set text_input to 0 if toggle is true
                                }
                            }),

                        TextInput::make('price')
                            ->required(fn ($get) => $get('is_free') !== true)
                            ->numeric()
                            ->prefix('$')
                            ->disabled(fn ($get) => $get('is_free') === true),
                    ]),

                    Section::make('Status')->schema([
                        Select::make('status')
                            ->searchable()
                            ->options(CourseStatus::options())
                            ->default(CourseStatus::DRAFT)
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
                CuratorColumn::make('media_id')
                    ->label('Image')
                    ->width(120)
                    ->height(80),
                TextColumn::make('status')
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state) => CourseStatus::colors($state)),
                TextColumn::make('title')
                    ->searchable()
                    ->size(TextColumnSize::Large)
                    ->weight(FontWeight::Bold),
                TextColumn::make('slug')
                    ->searchable()
                    ->fontFamily(FontFamily::Mono),
                IconColumn::make('is_free')
                    ->label('Is Free')
                    ->boolean()
                    ->falseColor('warning')
                    ->falseIcon('heroicon-o-currency-dollar'),
                TextColumn::make('price')
                    ->prefix('$')
                    ->getStateUsing(fn ($record) => $record->is_free ? null : $record->price),
                TextColumn::make('duration')
                    ->searchable()
                    ->formatStateUsing(fn ($state) => CarbonInterval::minutes($state)->cascade()->forHumans()),
            ])
            ->filters([
                //
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
            CourseResource\RelationManagers\LessonsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }
}
