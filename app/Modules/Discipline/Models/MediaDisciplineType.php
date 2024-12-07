<?php
declare(strict_types=1);

namespace App\Modules\Discipline\Models;

use Illuminate\Database\Eloquent\Model;

class MediaDisciplineType extends Model
{
    protected $table = 'media_discipline_type';

    protected $appends = [
        'code',
        'name',
    ];

    public function getCodeAttribute(): ?string
    {
        return $this->attributes['code'] ?? null;
    }

    public function getNameAttribute(): ?string
    {
        return $this->attributes['name'] ?? null;
    }
}
