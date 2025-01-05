<?php
declare(strict_types=1);

namespace App\Modules\User\Models;

use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    protected $table = 'groups';

    protected $fillable = [
        'name',
        'code',
    ];

    protected $hidden = [
        'pivot',
    ];
}
