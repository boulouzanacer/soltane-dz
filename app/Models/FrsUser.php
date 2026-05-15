<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FrsUser extends Model
{
    use HasFactory;

    protected $table = 'frs_users';

    protected $fillable = [
        'id_frs',
        'nom',
        'email',
        'password',
        'role',
        'actif',
    ];

    protected $hidden = [
        'password',
    ];

    public function fournisseur(): BelongsTo
    {
        return $this->belongsTo(Fournisseur::class, 'id_frs', 'id');
    }
}
