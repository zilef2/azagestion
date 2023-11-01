<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenCompra_User extends Model
{
    use HasFactory;

    protected $table = 'orden_compra_users';

    protected $fillable = [
        'orden_compra_id',
        'user_id',
    ];
}
