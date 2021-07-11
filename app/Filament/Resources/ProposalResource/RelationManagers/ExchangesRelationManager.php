<?php

namespace App\Filament\Resources\ProposalResource\RelationManagers;

use Filament\Resources\Forms\Components;
use Filament\Resources\Forms\Form;
use Filament\Resources\RelationManager;
use Filament\Resources\Tables\Columns;
use Filament\Resources\Tables\Filter;
use Filament\Resources\Tables\Table;

class ExchangesRelationManager extends RelationManager
{
    public static $primaryColumn = 'source_user_id';

    public static $relationship = 'exchanges';

    public static function form(Form $form)
    {
        return $form
            ->schema([
                Components\BelongsToSelect::make('source_user_id')
                    ->relationship('source_user', 'name'),
                Components\BelongsToSelect::make('recipient_user_id')
                    ->relationship('recipient_user', 'name'),
            ]);
    }

    public static function table(Table $table)
    {
        return $table
            ->columns([
                Columns\Text::make('source_user.name'),
                Columns\Text::make('recipient_user.name'),
                Columns\Text::make('status'),
            ])
            ->filters([
                //
            ]);
    }
}
