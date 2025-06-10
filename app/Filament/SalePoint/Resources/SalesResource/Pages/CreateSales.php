<?php

namespace App\Filament\SalePoint\Resources\SalesResource\Pages;

use App\Filament\SalePoint\Resources\SalesResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions\Action;

class CreateSales extends CreateRecord
{
    protected static string $resource = SalesResource::class;

    protected function getSubmitFormAction(): Action
    {
        return Action::make('create')
            ->label(__('salah'))
//            ->submit('create')
            ->requiresConfirmation()
            ->keyBindings([]);
    }
}
