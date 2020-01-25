<?php

namespace App\Http\API;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produto extends Model
{
    use SoftDeletes;
    protected $table = "produtos";
    protected $fillable = ["nome", "preco", "UN","fornecedor","qtde"];
}
