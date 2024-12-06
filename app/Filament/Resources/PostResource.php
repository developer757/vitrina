<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Http;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required(),
                TextInput::make('description')
                    ->label('Описание')
                    ->nullable()
                    ->maxLength(5000),
                TextInput::make('link')
                    ->required()
                    ->label('Ccылка'),

                FileUpload::make('image')
                    ->disk('public')
                    ->required()
                    ->image()
                    ->label('Картинка'),

                Select::make('geo')
                    ->label('Гео')
                    ->options([
                        'AF' => 'AF',
                        'AL' => 'AL',
                        'DZ' => 'DZ',
                        'AR' => 'AR',
                        'AU' => 'AU',
                        'AT' => 'AT',
                        'AZ' => 'AZ',
                        'BS' => 'BS',
                        'BH' => 'BH',
                        'BD' => 'BD',
                        'BY' => 'BY',
                        'BE' => 'BE',
                        'BZ' => 'BZ',
                        'BJ' => 'BJ',
                        'BT' => 'BT',
                        'BO' => 'BO',
                        'BA' => 'BA',
                        'BW' => 'BW',
                        'BR' => 'BR',
                        'BN' => 'BN',
                        'BG' => 'BG',
                        'BF' => 'BF',
                        'BI' => 'BI',
                        'KH' => 'KH',
                        'CM' => 'CM',
                        'CA' => 'CA',
                        'CF' => 'CF',
                        'TD' => 'TD',
                        'CL' => 'CL',
                        'CN' => 'CN',
                        'CO' => 'CO',
                        'KM' => 'KM',
                        'CG' => 'CG',
                        'CR' => 'CR',
                        'HR' => 'HR',
                        'CU' => 'CU',
                        'CY' => 'CY',
                        'CZ' => 'CZ',
                        'DK' => 'DK',
                        'DJ' => 'DJ',
                        'DO' => 'DO',
                        'EC' => 'EC',
                        'EG' => 'EG',
                        'SV' => 'SV',
                        'GQ' => 'GQ',
                        'ER' => 'ER',
                        'EE' => 'EE',
                        'ET' => 'ET',
                        'FJ' => 'FJ',
                        'FI' => 'FI',
                        'FR' => 'FR',
                        'GA' => 'GA',
                        'GM' => 'GM',
                        'GE' => 'GE',
                        'DE' => 'DE',
                        'GH' => 'GH',
                        'GR' => 'GR',
                        'GT' => 'GT',
                        'GN' => 'GN',
                        'GY' => 'GY',
                        'HT' => 'HT',
                        'HN' => 'HN',
                        'HU' => 'HU',
                        'IS' => 'IS',
                        'IN' => 'IN',
                        'ID' => 'ID',
                        'IR' => 'IR',
                        'IQ' => 'IQ',
                        'IE' => 'IE',
                        'IL' => 'IL',
                        'IT' => 'IT',
                        'JM' => 'JM',
                        'JP' => 'JP',
                        'JO' => 'JO',
                        'KZ' => 'KZ',
                        'KE' => 'KE',
                        'KW' => 'KW',
                        'KG' => 'KG',
                        'LA' => 'LA',
                        'LV' => 'LV',
                        'LB' => 'LB',
                        'LS' => 'LS',
                        'LR' => 'LR',
                        'LY' => 'LY',
                        'LI' => 'LI',
                        'LT' => 'LT',
                        'LU' => 'LU',
                        'MK' => 'MK',
                        'MG' => 'MG',
                        'MW' => 'MW',
                        'MY' => 'MY',
                        'MV' => 'MV',
                        'ML' => 'ML',
                        'MT' => 'MT',
                        'MR' => 'MR',
                        'MU' => 'MU',
                        'MX' => 'MX',
                        'MD' => 'MD',
                        'MC' => 'MC',
                        'MN' => 'MN',
                        'ME' => 'ME',
                        'MA' => 'MA',
                        'MZ' => 'MZ',
                        'MM' => 'MM',
                        'NA' => 'NA'
                    ]),


                Toggle::make('target_blank')
                    ->label('Открывать в новой вкладке'),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('title')
                    ->sortable()
                    ->searchable()
                    ->label('Название'),
                TextColumn::make('link')
                    ->sortable()
                    ->searchable()
                    ->limit(30)
                    ->label('Ссылка'),
                TextColumn::make('description')
                    ->sortable()
                    ->searchable()
                    ->limit(30)
                    ->label('Описание'),


                ImageColumn::make('image')
                    ->label('Картинка'),
                TextColumn::make('geo')
                    ->sortable()
                    ->searchable()
                    ->label('Ссылка'),


                BooleanColumn::make('target_blank')
                    ->label('Blank'),

                TextColumn::make('clicks')
                    ->sortable()
                    ->label('Клики'),

                TextColumn::make('views')
                    ->sortable()
                    ->label('Просмотры'),
            ])

            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
