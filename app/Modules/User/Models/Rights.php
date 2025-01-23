<?php
declare(strict_types=1);

namespace App\Modules\User\Models;

use Illuminate\Database\Eloquent\Model;

class Rights extends Model
{
    protected $table = 'rights';

    protected $fillable = [
        'name',
        'code',
    ];

    protected $hidden = [
        'pivot',
    ];
}
