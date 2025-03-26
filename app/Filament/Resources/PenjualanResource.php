<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenjualanResource\Pages;
use App\Filament\Resources\PenjualanResource\RelationManagers;
use App\Models\Penjualan;
use Filament\Forms;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class PenjualanResource extends Resource
{
    protected static ?string $model = Penjualan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('tanggal_penjualan')
                    ->label("Tanggal Penjualan")
                    ->sortable()
                    ->searchable()
                    ->date('d F Y'),
                Tables\Columns\TextColumn::make('kode_penjualan')
                    ->label("Kode Penjualan")
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('jumlah')
                    ->label("Jumlah")
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(function ($state) {
                        return 'Rp ' . number_format($state, 0, ',', '.');
                    }),
                Tables\Columns\TextColumn::make('customer.nama_customer')
                    ->label("Nama Customer")
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('keterangan')
                    ->label("Keterangan")
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label("Status")
                    ->sortable()
                    ->searchable()
                    ->color(fn (string $state): string => match ($state) {
                        '1' => 'success',
                        '0' => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        '1' => 'Lunas',
                        '0' => 'Belum Lunas',
                    }),


            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListPenjualans::route('/'),
            'create' => Pages\CreatePenjualan::route('/create'),
            // 'edit' => Pages\EditPenjualan::route('/{record}/edit'),
        ];
    }
}
