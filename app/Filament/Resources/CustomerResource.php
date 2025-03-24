<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Customer nich';

    protected static ?string $slug = 'kelola-customer';

    protected static ?string $navigationGroup = 'Kelola';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\TextInput::make('nama_customer')
                    ->label('Nama')
                    ->placeholder('Masukkan Nama')
                    ->required(),
                Forms\Components\TextInput::make('kode_customer')
                    ->numeric()
                    ->label('Kode')
                    ->placeholder('Masukkan Kode')
                    ->required(),
                Forms\Components\TextInput::make('alamat_customer')
                    ->label('Alamat')
                    ->placeholder('Masukkan Alamat')
                    ->required(),
                Forms\Components\TextInput::make('no_telp_customer')
                    ->label('No Telepon')
                    ->placeholder('Masukkan No Telepon')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('nama_customer')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(), 
                Tables\Columns\TextColumn::make('kode_customer')
                    ->label('Kode')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Kode customer telah disalin'),
                Tables\Columns\TextColumn::make('alamat_customer')
                    ->label('Alamat'),
                Tables\Columns\TextColumn::make('no_telp_customer')
                    ->label('No Telepon'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
