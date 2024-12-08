<?php

namespace App\Modules\Theme\Models;

use App\Modules\Subject\Models\Subjects;
use App\Text\Models\Text;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Theme extends Model
{
    use HasFactory, SoftDeletes;

    protected $timestamp = false;

    protected $table = 'theme';

    protected $fillable = [
        'name',
        'code',
        'position',
        'subject_id',
        'parent_id',
    ];

    protected $hidden = [
        'subject_id',
        'parent_id',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    protected $appends = [
        'position',
        'name',
        'parent',
        'text',
    ];

    public function getPositionAttribute(): int
    {
        return $this->attributes['position'] ?? 1;
    }

    public function getNameAttribute(): ?string
    {
        return $this->attributes['name'] ?? null;
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Theme::class, 'parent_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subjects::class, 'subject_id');
    }

    public function texts(): HasMany
    {
        return $this->hasMany(Text::class, 'theme_id');
    }

    public function getParentAttribute(): ?Theme
    {
        return $this->parent()->first();
    }

    private function sortingText(iterable $data): array
    {
        $texts = [];
        foreach ($data as $value) {
            $texts[$value->position] = $value;
        }
        ksort($texts);
        return array_values($texts);
    }

    public function getTextAttribute(): ?iterable
    {
        return $this->sortingText($this->texts()->get());
    }
}
