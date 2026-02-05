<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admins'; // Gunakan tabel khusus admin
    protected $fillable = ['username', 'password', 'nama_admin'];
    protected $hidden = ['password'];
}