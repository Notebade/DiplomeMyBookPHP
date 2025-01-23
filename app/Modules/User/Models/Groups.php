<?php
declare(strict_types=1);

namespace App\Modules\User\Models;

use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    protected $table = 'groups';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'code',
    ];

    protected $hidden = [
        'pivot',
    ];
}
