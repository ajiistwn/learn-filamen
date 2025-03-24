<?php

namespace App\Filament\Resources\FacturResource\Pages;

use App\Filament\Resources\FacturResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFactur extends EditRecord
{
    protected static string $resource = FacturResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
