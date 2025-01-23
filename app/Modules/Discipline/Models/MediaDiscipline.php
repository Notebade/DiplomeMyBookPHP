<?php
declare(strict_types=1);

namespace App\Modules\Discipline\Models;

use Illuminate\Database\Eloquent\Model;

class MediaDiscipline extends Model
{
    protected $table = 'media_discipline';

    protected $fillable = [
        'discipline_id',
        'media_id',
        'media_type_id'
    ];

    protected $hidden = [
        'discipline_id',
        'media_id',
        'media_type_id'
    ];

    protected $appends = [
        'media',
        'type',
    ];
}
