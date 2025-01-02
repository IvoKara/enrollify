<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VideoResource\Pages;
use App\Filament\Traits\FiltersByCurrentUser;
use App\Forms\Components\VideoUrlInput;
use App\Models\Video;
use Carbon\CarbonInterval;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Table;

class VideoResource extends Resource
{
    use FiltersByCurrentUser;

    protected static ?string $model = Video::class;

    protected static ?string $navigationIcon = 'heroicon-o-video-camera';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Overview')->schema([
                    Forms\Components\TextInput::make('title')
                        ->required(),
                    Forms\Components\RichEditor::make('description')
                        ->required(),
                ])
                    ->columnStart(1)
                    ->columnSpan(2),
                Forms\Components\Section::make('Video')->schema([
                    VideoUrlInput::make('url')
                        ->reactive()
                        ->helperText('Enter a valid YouTube or other supported video URL.')
                        ->required()
                        ->afterStateUpdated(function ($set, $state, $record) {
                            return $set('duration', Video::getVideoDuration($state));
                        }),
                    Forms\Components\TextInput::make('duration')
                        ->helperText('Calculated video duration in seconds.')
                        ->required()
                        ->readOnly()
                        ->hidden(fn ($get) => $get('url') === null),
                ])
                    ->columnStart(3)
                    ->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('url')
                //     ->label('URL')
                // ->formatStateUsing(),
                ImageColumn::make('url')
                    ->getStateUsing(fn (Video $record) => $record->thumbnail())
                    ->width(120)
                    ->height(80),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->size(TextColumnSize::Large)
                    ->weight(FontWeight::Bold),
                Tables\Columns\TextColumn::make('description')
                    ->html()
                    ->searchable()
                    ->words(20)
                    ->lineClamp(3),
                Tables\Columns\TextColumn::make('duration')
                    ->formatStateUsing(fn ($state) => CarbonInterval::seconds($state)->cascade()->forHumans()),
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
            'index' => Pages\ListVideos::route('/'),
            'create' => Pages\CreateVideo::route('/create'),
            'edit' => Pages\EditVideo::route('/{record}/edit'),
        ];
    }
}
