<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Penjualan extends Model
{
    //
    use HasFactory;
    protected $table = 'penjualans';
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function faktur()
    {
        return $this->belongsTo(Faktur::class);
    }

}
