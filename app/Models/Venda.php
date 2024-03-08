<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Celular;

class Venda extends Model
{
    protected $fillable = [
        'sales_id',
        'amount',
        'products',
    ];

    protected $casts = [
        'products' => 'json',
    ];

    public function celulares()
    {
        return $this->belongsToMany(Celular::class)
            ->withPivot(['amaount']);
    }
}
