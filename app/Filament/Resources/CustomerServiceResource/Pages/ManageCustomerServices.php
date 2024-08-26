<?php

namespace App\Filament\Resources\CustomerServiceResource\Pages;

use App\Filament\Resources\CustomerServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCustomerServices extends ManageRecords
{
    protected static string $resource = CustomerServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('New Customer Service')
                ->icon('heroicon-s-plus'),
        ];
    }
}
