<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FrsUserTask extends Model
{
    use HasFactory;

    protected $table = 'frs_user_tasks';

    protected $fillable = [
        'id_frs_user',
        'titre',
        'description',
        'statut',
        'due_date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(FrsUser::class, 'id_frs_user', 'id');
    }
}

