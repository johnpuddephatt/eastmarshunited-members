<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Roles;
use Filament\Resources\Forms\Components;
use Filament\Resources\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Tables\Columns;
use Filament\Resources\Tables\Filter;
use Filament\Resources\Tables\Table;

class UserResource extends Resource
{
    public static $icon = 'heroicon-o-user';

    public static function form(Form $form)
    {
        return $form
            ->schema([
                Components\Tabs::make('Label')
                ->tabs([
                    Components\Tab::make(
                        'Account',
                        [
                            Components\TextInput::make('name'),
                            Components\TextInput::make('email'),
                            Components\DatePicker::make('date_of_birth'),
                            // Components\FileUpload::make('photo')->image()->imageCropAspectRatio('1:1')->disk('public'),
                            Components\Checkbox::make('approved'),
                            Components\Select::make('type')->options(['member' => 'Member', 'supporter' => 'Supporter', 'organisation' => 'Organisation']),
                        ],
                    ),
                    Components\Tab::make(
                        'Timebanking',
                        [
                            Components\Checkbox::make('has_completed_profile'),
                            Components\TextInput::make('credits'),
                            Components\TextInput::make('phone'),
                            Components\Textarea::make('description'),
                        ],
                    ),
                ]),
            ]);
    }

    public static function table(Table $table)
    {
        return $table
            ->columns([
                Columns\Text::make('name')->primary(),
                Columns\Text::make('email'),
                Columns\Text::make('type'),
                Columns\Boolean::make('approved'),
                Columns\Boolean::make('has_completed_profile')->label('Timebanking')
            ])
            ->filters([
                Filter::make('members', fn ($query) => $query->where('type', 'member')),
                Filter::make('supporters', fn ($query) => $query->where('type', 'supporter')),
                Filter::make('organisations', fn ($query) => $query->where('type', 'organisation'))
            ]);
    }

    public static function relations()
    {
        return [
            //
        ];
    }

    public static function routes()
    {
        return [
            Pages\ListUsers::routeTo('/', 'index'),
            Pages\CreateUser::routeTo('/create', 'create'),
            Pages\EditUser::routeTo('/{record}/edit', 'edit'),
        ];
    }
}
