<?php

namespace App\Http\API;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
	use SoftDeletes;
    protected $table = "clientes";

    protected $fillable = ["nome", "endereco", "telefone","idade","filho"];
}
