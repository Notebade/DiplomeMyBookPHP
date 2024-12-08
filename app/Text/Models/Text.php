<?php
declare(strict_types=1);

namespace App\Text\Models;

use App\Models\User;
use App\Modules\Theme\Models\Theme;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Text extends Model
{
    use HasFactory, SoftDeletes;

    protected $timestamp = false;

    protected $table = 'text';

    protected $fillable = [
        'text',
        'theme_id',
        'position',
    ];

    protected $hidden = [
        'deleted_at',
        'created_at',
        'updated_at',
        'theme_id',
    ];

    protected $appends = [
        //'theme',
    ];

    protected function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class, 'theme_id');
    }

    public function media(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'text_media', 'text_id', 'media_id');
    }

    public function getThemeAttribute(): ?Theme
    {
        return $this->theme()->first();
    }
}
