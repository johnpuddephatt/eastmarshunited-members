<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProposalResource\Pages;
use App\Filament\Resources\ProposalResource\RelationManagers;
use App\Filament\Roles;
use Filament\Resources\Forms\Components;
use Filament\Resources\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Tables\Columns;
use Filament\Resources\Tables\Filter;
use Filament\Resources\Tables\Table;

class ProposalResource extends Resource
{
    public static $icon = 'heroicon-o-collection';
    public static $label = 'Timebanking';

    public static function form(Form $form)
    {
        return $form
            ->schema([
                Components\BelongsToSelect::make('user_id')
                    ->relationship('user', 'name'),
                Components\TextInput::make('title'),
                Components\Textarea::make('description'),
                Components\Select::make('type')->options(['ask' => 'Ask', 'offer' => 'Offer']),
                Components\TextInput::make('hours'),
                Components\TextInput::make('places'),
            ]);
    }

    public static function table(Table $table)
    {
        return $table
            ->columns([
                Columns\Text::make('title')->primary(),
                Columns\Text::make('user.name'),
                Columns\Text::make('type'),

            ])
            ->filters([
                //
            ]);
    }

    public static function relations()
    {
        return [
            RelationManagers\ExchangesRelationManager::class,
        ];
    }

    public static function routes()
    {
        return [
            Pages\ListProposals::routeTo('/', 'index'),
            Pages\CreateProposal::routeTo('/create', 'create'),
            Pages\EditProposal::routeTo('/{record}/edit', 'edit'),
        ];
    }
}
