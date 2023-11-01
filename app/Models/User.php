<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
// use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    // use SoftDeletes;
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'name_no_spaces',
        'email',
        'password',
        'is_admin',
        'cedula',
        'cedula2',
        'sexo',
        'cel',
        'rol_id', //2 asignador | 3 asesor
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // protected $appends = [ 'profile_photo_url', ];

    public function orden_compras() {
        return $this->belongstoMany(OrdenCompra::class, 'orden_compra_users')->using(OrdenCompra_User::class);
    }

    public function rol() {
        return $this->belongsTo(Roles::class,'rol_id');
    }

    public function getRol() {
        return Roles::find(Auth::user()->rol_id)->nombre;
    }
}
