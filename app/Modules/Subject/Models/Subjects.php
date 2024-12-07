<?php
declare(strict_types=1);

namespace App\Modules\Subject\Models;

use App\Models\User;
use App\Modules\Discipline\Models\Discipline;
use App\Modules\Media\Models\Media;
use App\Modules\Theme\Models\Theme;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Prompts\Concerns\Themes;

class Subjects extends Model
{
    use softDeletes;
    protected $table = 'subjects';

    protected $fillable = [
        'name',
        'code',
        'description',
        'user_id',
        'media_id',
        'discipline_id',
    ];

    protected $hidden = [
        'media_id',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'discipline_id',
    ];

    protected $appends = [
        'name',
        'code',
        'description',
        'media',
        'discipline',
        'themes',
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

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'media_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function discipline(): BelongsTo
    {
        return $this->belongsTo(Discipline::class, 'discipline_id');
    }

    public function themes(): HasMany
    {
        return $this->hasMany(Theme::class, 'subject_id');
    }

    public function getMediaAttribute(): ?Media
    {
        return $this->media()->first();
    }

    public function getDisciplineAttribute(): ?Discipline
    {
        return $this->discipline()->first();
    }


    private function sortingThemes(iterable $topics): array
    {
        $themes = [];
        foreach ($topics as $theme) {//todo потом добавить сортировку дочерних
            $themes[$theme->position] = $theme;
        }
        ksort($themes);
        return array_values($themes);
    }

    public function getThemesAttribute(): ?iterable
    {
        return $this->sortingThemes($this->themes()->get());
    }
}
