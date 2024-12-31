<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VideoResource\Pages;
use App\Forms\Components\VideoUrlInput;
use App\Models\Video;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

class VideoResource extends Resource
{
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
                        ->required(),
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
                    ->getStateUsing(function (Video $record) {

                        $videoId = VideoUrlInput::getVideoId($record->url);

                        // Return the thumbnail URL
                        return url("https://img.youtube.com/vi/$videoId/sddefault.jpg");
                    })
                    ->width(120)
                    ->height(80),
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\TextColumn::make('description')->searchable(),
            ])
            ->filters([
                //
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
