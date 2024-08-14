<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class TableExample extends Page implements HasActions, HasForms, HasTable
{
    use InteractsWithActions;
    use InteractsWithForms;
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.table-example';

    public function mount(): void {}

    public function table(Table $table): Table
    {
        return $table->records(fn () => [
            [
                'id' => 1,
                'image' => 'https://avatars.githubusercontent.com/u/3833889?v=4',
                'name' => 'Leandro Ferreira',
                'email' => 'leandrocfe@gmail.com',
                'phone' => '+551699999999',
                'profile_url' => 'https://github.com/leandrocfe',
            ],
        ])
            ->columns([
                TextColumn::make('id'),
                ImageColumn::make('image')
                    ->circular(),
                TextColumn::make('name'),
                TextColumn::make('email'),
                TextColumn::make('phone'),
            ])
            ->actions([
                Action::make('viewProfile')
                    ->icon('heroicon-o-eye')
                    ->url(fn (array $record) => $record['profile_url'])
                    ->openUrlInNewTab(),
            ]);
    }
}
