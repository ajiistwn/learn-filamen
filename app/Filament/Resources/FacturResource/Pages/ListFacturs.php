<?php

namespace App\Filament\Resources\FacturResource\Pages;

use App\Filament\Resources\FacturResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFacturs extends ListRecords
{
    protected static string $resource = FacturResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
