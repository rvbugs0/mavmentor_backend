<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Role;
use Illuminate\Notifications\Notifiable;
class User extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'users';
    use Notifiable;
    protected $fillable = [
        'email', 'password', 'first_name', 'last_name', 'role'
    ];

    protected $casts = [
        'role' => 'integer', // Assuming 'role' is an integer field (foreign key)
    ];
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
