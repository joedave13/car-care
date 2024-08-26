<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Resources\ServiceResource\RelationManagers;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?string $navigationGroup = 'Master Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($state, Set $set) => $set('slug', Str::slug($state) . '-' . strtolower(Str::random(5))))
                    ->prefixIcon('heroicon-m-wrench-screwdriver'),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->disabled()
                    ->dehydrated()
                    ->unique(Service::class, 'slug', ignoreRecord: true)
                    ->prefixIcon('heroicon-m-link'),
                Forms\Components\RichEditor::make('description')
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('photo')
                    ->image()
                    ->directory('services/photos'),
                Forms\Components\FileUpload::make('icon')
                    ->image()
                    ->directory('services/icons'),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                Forms\Components\TextInput::make('duration_in_hour')
                    ->required()
                    ->numeric()
                    ->label('Duration in Hour')
                    ->prefixIcon('heroicon-m-clock'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->numeric()
                    ->sortable()
                    ->prefix('Rp. '),
                Tables\Columns\ImageColumn::make('photo')
                    ->circular(),
                Tables\Columns\ImageColumn::make('icon')
                    ->circular(),
                Tables\Columns\TextColumn::make('duration_in_hour')
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
                ActionGroup::make([
                    ActionGroup::make([
                        Tables\Actions\EditAction::make(),
                    ])->dropdown(false),
                    Tables\Actions\DeleteAction::make(),
                ])
                    ->icon('heroicon-m-bars-3')
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageServices::route('/'),
        ];
    }
}
