<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Barang;
use App\Models\Faktur;
use App\Models\Customer;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\FacturResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\FacturResource\RelationManagers;
use Filament\Forms\Get;
use Filament\Forms\Set;

class FacturResource extends Resource
{
    protected static ?string $model = Faktur::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('kode_faktur')
                    ->columnspan(2),
                Select::make('customer_id')
                    ->reactive()
                    ->relationship(name: 'customer', titleAttribute: 'nama_customer')
                    ->columnspan(["default" => 2, "sm" => 1])
                    ->afterStateUpdated(function ($state,  callable $set) {
                        $customer = Customer::find($state);
                        $set('kode_customer', $customer->kode_customer);
                    }),
                DatePicker::make('tanggal_faktur')
                    ->columnspan(["default" => 2, "sm" => 1]),
                TextInput::make('kode_customer')
                    ->columnspan(2)
                    ->readOnly(),
                Repeater::make('details')
                    ->relationship()
                    ->schema([
                        Select::make('barang_id')
                            ->columnSpan(2)
                            ->relationship(name: 'barang', titleAttribute: 'nama_barang')
                            ->reactive()
                            ->afterStateUpdated(function ($state,  callable $set) {
                                $barang = Barang::find($state);
                                $set('nama_barang', $barang->nama_barang);
                                $set('harga', $barang->harga_barang);
                            }),
                        TextInput::make('nama_barang')
                            ->columnSpan(2),
                        // ->disabled(),
                        TextInput::make('harga')
                            ->columnSpan(["default" => 2, "sm" => 1, "md" => 1, "lg" => 1])
                            ->numeric()
                            ->prefix('Rp'),
                        // ->disabled(),
                        TextInput::make('qty')
                            ->numeric()
                            ->reactive()
                            ->columnSpan(["default" => 2, "sm" => 1, "md" => 1, "lg" => 1])
                            ->afterStateUpdated(function (Set $set, $state, Get $get) {
                                $set('hasil_qty', $state * $get('harga'));
                            }),
                        TextInput::make('hasil_qty')
                            ->numeric()
                            ->prefix('Rp')
                            ->columnSpan(2),
                        // ->disabled(),
                        TextInput::make('diskon')
                            ->numeric()
                            ->columnSpan(2)
                            ->prefix('%')
                            ->reactive()
                            ->afterStateUpdated(function (Set $set, $state, Get $get) {
                                $set('subtotal', $get('hasil_qty') - (($state / 100) * $get('hasil_qty')));
                            }),
                        TextInput::make('subtotal')
                            ->numeric()
                            ->prefix('Rp')
                            ->columnSpan(2),
                        // ->disabled(),

                    ])
                    ->columnspan(2)
                    ->live(),
                Textarea::make('ket_faktur')
                    ->columnspan(2),
                TextInput::make('total')
                    ->prefix('Rp')

                    ->columnspan(["default" => 2, "sm" => 1])
                    ->placeholder(function (Set $set, Get $get) {
                        $total = collect($get('details'))->pluck('subtotal')->sum();
                        if ($total) {
                            $set('total', $total);
                        } else {
                            $set('total', 0);
                        }
                    })
                    ->live(),
                TextInput::make('nominal_charge')
                    ->columnspan(["default" => 2, "sm" => 1])
                    ->reactive()
                    ->prefix('%')
                    ->afterStateUpdated(function (Set $set, $state, Get $get) {
                        $set('charge', ($state / 100) * $get('total'));
                    }),
                TextInput::make('charge')
                    ->numeric()
                    ->columnspan(2)
                    ->prefix('Rp'),
                // ->disabled(),
                TextInput::make('total_final')
                    ->columnspan(2)
                    ->prefix('Rp')
                    ->placeholder(function (Set $set, Get $get) {
                        $set('total_final', $get('total') + $get('charge'));
                    }),
                // ->disabled()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('kode_faktur'),
                TextColumn::make('tanggal_faktur'),
                TextColumn::make('kode_customer'),
                TextColumn::make('customer.nama_customer'),
                TextColumn::make('ket_faktur'),
                TextColumn::make('total'),
                TextColumn::make('nominal_charge'),
                TextColumn::make('charge'),
                TextColumn::make('total_final'),
                TextColumn::make('created_at')


            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListFacturs::route('/'),
            'create' => Pages\CreateFactur::route('/create'),
            'edit' => Pages\EditFactur::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
