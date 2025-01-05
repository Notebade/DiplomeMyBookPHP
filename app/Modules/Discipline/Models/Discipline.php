<?php
declare(strict_types=1);

namespace App\Modules\Discipline\Models;

use App\Modules\User\Models\User;
use App\Modules\Media\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Discipline extends Model
{
    use softDeletes;
    protected $table = 'disciplines';

    protected $fillable = [
        'name',
        'code',
        'description',
        'user_id',
        'media_id',
    ];

    protected $hidden = [
        'media_id',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = [
        'name',
        'code',
        'description',
        'authors',
        'media'
    ];

    public function getNameAttribute(): ?string
    {
        return $this->attributes['name'] ?? null;
    }

    public function getCodeAttribute(): ?string
    {
        return $this->attributes['code'] ?? null;
    }

    public function getDescriptionAttribute(): ?string
    {
        return $this->attributes['description'] ?? null;
    }

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'author_discipline', 'discipline_id', 'user_id');
    }

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'media_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getAuthorsAttribute(): ?array
    {
        $authors = [$this->user()->first()];
        foreach ($this->authors()->get() as $user) {
            $authors[] = $user;
        }
        return $authors;
    }

    public function getMediaAttribute(): ?Media
    {
        return $this->media()->first();
    }

    public function jsonSerialize(bool $user = false): array
    {
        $result = self::toArray();
        if($user)
        {
            foreach ($result['authors'] as $key => &$item) {
                if(Auth::getUser()->id === $item['id']) {
                    unset($result['authors'][$key]);
                }
            }
        }
        return $result;
    }
}
