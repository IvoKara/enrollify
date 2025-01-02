<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TextResource\Pages;
use App\Filament\Traits\FiltersByCurrentUser;
use App\Models\Text;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Awcodes\Curator\Components\Tables\CuratorColumn;
use Carbon\CarbonInterval;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Table;

class TextResource extends Resource
{
    use FiltersByCurrentUser;

    protected static ?string $model = Text::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make()->schema([
                        TextInput::make('title')->required(),
                        RichEditor::make('content')
                            ->required()
                            ->live(debounce: 500)
                            ->afterStateUpdated(function ($state, $set) {
                                $calculatedDuration = ceil(str_word_count(strip_tags($state)) / 200);
                                $set('duration', $calculatedDuration);
                            }),
                    ]),
                ])
                    ->columns(1)
                    ->columnSpan(2)
                    ->columnStart(1),
                Group::make()->schema([
                    Section::make()->schema([
                        TextInput::make('duration')
                            ->label('Duration (min)')
                            ->helperText('Calculated content read duration in minutes.')
                            ->required()
                            ->readOnly(),

                    ]),

                    Section::make()->schema([
                        CuratorPicker::make('media_id')->label('Image'),
                    ]),
                ])
                    ->columns(1)
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
                TextColumn::make('title')
                    ->searchable()
                    ->size(TextColumnSize::Large)
                    ->weight(FontWeight::Bold),
                TextColumn::make('duration')
                    ->label('Read Duration')
                    ->formatStateUsing(fn ($state) => CarbonInterval::minutes($state)->cascade()->forHumans())
                    ->searchable(),

                TextColumn::make('content')
                    ->html()
                    ->words(10)
                    ->lineClamp(3)
                    ->searchable(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTexts::route('/'),
            'create' => Pages\CreateText::route('/create'),
            'edit' => Pages\EditText::route('/{record}/edit'),
        ];
    }
}
