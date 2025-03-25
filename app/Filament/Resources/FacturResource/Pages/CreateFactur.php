<?php

namespace App\Filament\Resources\FacturResource\Pages;

use App\Filament\Resources\FacturResource;
use App\Models\Penjualan;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFactur extends CreateRecord
{
    protected static string $resource = FacturResource::class;
    protected function afterCreate(): void
    {
        Penjualan::create([

            'tanggal_penjualan' =>  $this->record->tanggal_faktur,
            'kode_penjualan' => $this->record->kode_faktur,
            'jumlah' => $this->record->total,
            'customer_id' => $this->record->customer_id,
            'faktur_id' => $this->record->id,
            'status' => 0,
            'keterangan' => $this->record->ket_faktur,
        ]);
    }
}
