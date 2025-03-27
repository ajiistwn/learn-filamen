<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Customer;
use App\Models\Barang;
use App\Models\Penjualan;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $countPelanggan = Customer::count();
        $countBarang = Barang::count();
        $countPenjualan = Penjualan::count();
        return [
            //
            Stat::make('Pelanggan', (string)$countPelanggan),
            Stat::make('Barang', (string)$countBarang),
            Stat::make('Penjualan', (string)$countPenjualan),
        ];
    }
}
