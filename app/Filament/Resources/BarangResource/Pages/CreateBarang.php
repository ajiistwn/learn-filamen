<?php

namespace App\Filament\Resources\BarangResource\Pages;

use App\Filament\Resources\BarangResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateBarang extends CreateRecord
{
    protected static string $resource = BarangResource::class;

    protected function getCreatedNotification(): ?Notification
{
    return Notification::make()
        ->success()
        ->icon('heroicon-o-archive-box-arrow-down')
        ->iconColor('black')
        ->color('success')
        ->title('Barang Created')
        ->duration(2000)
        ->body('The barang has been created successfully.');
}
}
