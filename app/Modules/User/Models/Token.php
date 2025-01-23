<?php
declare(strict_types=1);

namespace App\Modules\User\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $table = 'token_history';

    public $timestamps = true;

    protected $fillable = [
        'token'
    ];
}
