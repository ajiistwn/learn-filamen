<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faktur extends Model
{
    //
    use hasFactory, softDeletes;
    protected $guarded = [];
    protected $table = 'fakturs';

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function details()
    {
        return $this->hasMany(Detail::class, 'faktur_id');
    }
}
