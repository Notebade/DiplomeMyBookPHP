<?php
declare(strict_types=1);

namespace App\Modules\User\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    use Timestamp;
    protected $table = 'invite';

    protected $fillable = [
        'code',
        'info',
        'date_end',
    ];

    protected $hidden = [
        'pivot',
        'user_id',
        'created_at',
        'updated_at',
        'date_end',
    ];

    protected $appends = [
      'dateEnd',
    ];

    public function getDateEndAttribute(): string
    {
        return $this->attributes['date_end'];
    }

    public function getInfoAttribute(): array
    {
        return json_decode($this->attributes['info'], true);
    }
}
