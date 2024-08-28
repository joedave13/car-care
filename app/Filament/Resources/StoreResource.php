<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StoreResource\Pages;
use App\Filament\Resources\StoreResource\RelationManagers;
use App\Models\Store;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class StoreResource extends Resource
{
    protected static ?string $model = Store::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    protected static ?string $navigationGroup = 'Master Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)
                    ->schema([
                        Section::make('Store Information')
                            ->description('Information about the store')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn($state, Set $set) => $set('slug', Str::slug($state) . '-' . strtolower(Str::random(5))))
                                    ->prefixIcon('heroicon-m-building-storefront'),
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->disabled()
                                    ->dehydrated()
                                    ->unique(Store::class, 'slug', ignoreRecord: true)
                                    ->prefixIcon('heroicon-m-link'),
                                Forms\Components\Select::make('city_id')
                                    ->relationship('city', 'name')
                                    ->required()
                                    ->preload()
                                    ->searchable()
                                    ->prefixIcon('heroicon-m-building-library'),
                                Forms\Components\FileUpload::make('thumbnail')
                                    ->image()
                                    ->directory('stores/thumbnails'),
                                Forms\Components\RichEditor::make('address')
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('phone')
                                    ->tel()
                                    ->maxLength(255)
                                    ->prefixIcon('heroicon-m-phone'),
                                Forms\Components\Select::make('customer_service_id')
                                    ->relationship('customerService', 'name')
                                    ->required()
                                    ->preload()
                                    ->searchable()
                                    ->prefixIcon('heroicon-m-user-group'),
                                Forms\Components\Toggle::make('is_open')
                                    ->required()
                                    ->inline(false)
                                    ->default(true)
                                    ->label('Is Open'),
                                Forms\Components\Toggle::make('is_full')
                                    ->required()
                                    ->inline(false)
                                    ->default(false)
                                    ->label('Is Full'),
                            ])
                            ->columns(2),
                    ]),
                Section::make('Store Photo')
                    ->description('Photo of the store')
                    ->schema([
                        Repeater::make('storePhotos')
                            ->relationship()
                            ->schema([
                                Forms\Components\FileUpload::make('photo')
                                    ->image()
                                    ->directory('stores/photos')
                            ])
                    ])->columnSpan(1),
                Section::make('Store Service')
                    ->description('Service in the store')
                    ->schema([
                        Repeater::make('serviceStores')
                            ->relationship()
                            ->schema([
                                Forms\Components\Select::make('service_id')
                                    ->relationship('service', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                            ])
                    ])
                    ->columnSpan(1)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->description(fn(Store $record) => $record->city->name)
                    ->searchable(),
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->circular(),
                Tables\Columns\IconColumn::make('is_open')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_full')
                    ->boolean(),
                Tables\Columns\TextColumn::make('customerService.name')
                    ->description(fn(Store $record) => $record->customerService->role->getLabel())
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
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListStores::route('/'),
            'create' => Pages\CreateStore::route('/create'),
            'view' => Pages\ViewStore::route('/{record}'),
            'edit' => Pages\EditStore::route('/{record}/edit'),
        ];
    }
}
