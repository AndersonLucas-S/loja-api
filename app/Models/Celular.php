<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Venda;

class Celular extends Model
{
    protected $table = 'celulares';
    protected $fillable = [
        'name',
        'price',
        'description',
    ];

    public function vendas()
    {
        return $this->belongsToMany(Venda::class)
            ->withPivot(['amount']);
    }
}
