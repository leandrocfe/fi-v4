<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Actions;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schema\Components\Section;
use Filament\Schema\Components\Split;
use Filament\Schema\Components\Utilities\Get;
use Filament\Schema\Components\Utilities\Set;
use Filament\Schema\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Schema $form): Schema
    {
        return $form
            ->columns(null)
            ->schema([
                Split::make([
                    Section::make([

                        TextEntry::make('Instructions')
                            ->state('Numquam recusandae dolor suscipit libero dolorem.')
                            ->color('primary'),

                        TextInput::make('title')
                            ->required()
                            ->afterStateUpdatedJs(<<<'JS'
                                $set('slug', slug($state))
                            JS),

                        TextInput::make('slug')
                            ->required()
                            ->afterStateUpdatedJs(<<<'JS'
                                $set('slug', slug($state))
                            JS),

                        /*
                        TextInput::make('title')
                            ->live(onBlur: true)
                            ->partiallyRenderComponentsAfterStateUpdated(['slug'])
                            ->afterStateUpdated(function (Set $set, ?string $state) {
                                $set('slug', str($state)->slug());
                            }),

                        TextInput::make('slug'),

                        TextEntry::make('time')
                            ->state(now()),
                        */

                        RichEditor::make('content')
                            ->columnSpanFull(),

                        Toggle::make('show_tags')
                            ->live()
                            ->formatStateUsing(fn () => true),

                        TagsInput::make('tags')
                            ->columnSpanFull()
                            ->visible(fn (Get $get): bool => $get('show_tags')),
                    ]),
                    Section::make([

                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->required(),

                        FileUpload::make('image')
                            ->image(),
                        Toggle::make('published'),

                        DateTimePicker::make('published_at')
                            ->visibleJs(<<<'JS'
                            $get('published')
                        JS),
                    ])
                        ->grow(false)
                        ->extraAttributes(['style' => 'min-width: 350px']),
                ]),
            ]);
    }

    public static function infolist(Schema $infolist): Schema
    {
        return $infolist->schema([
            TextEntry::make('title'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\IconColumn::make('published')
                    ->boolean(),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Actions\ViewAction::make(),
                Actions\EditAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'view' => Pages\ViewPost::route('/{record}'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
