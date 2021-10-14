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
    public $recordsPerPage = 50;

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
                            Components\TextInput::make('name')->required(),
                            Components\TextInput::make('email')->required(),
                            Components\DatePicker::make('date_of_birth')->required(),
                            // Components\FileUpload::make('photo')->image()->imageCropAspectRatio('1:1')->disk('public'),
                            
                            Components\Select::make('type')->options(['member' => 'Member', 'supporter' => 'Supporter', 'organisation' => 'Organisation'])->default('member')->dependable(),
                            Components\Checkbox::make('approved')->when(fn ($record) => $record->type === 'organisation'),
                            Components\Textarea::make('notes'),
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
                Columns\Boolean::make('has_completed_profile')->label('Timebanking')
            ])
            ->filters([
                Filter::make('Only members', fn ($query) => $query->where('type', 'member')),
                Filter::make('Only supporters', fn ($query) => $query->where('type', 'supporter')),
                Filter::make('Only organisations', fn ($query) => $query->where('type', 'organisation')),
                Filter::make('Show deleted users', fn ($query) => $query->onlyTrashed())
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
