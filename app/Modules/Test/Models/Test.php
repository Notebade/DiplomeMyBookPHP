<?php
declare(strict_types=1);

namespace App\Modules\Test\Models;

use App\Modules\Theme\Models\Theme;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Test extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;

    protected $table = 'test';

    protected $fillable = [
        'theme_id',
        'code',
        'name',
        'user_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'user_id',
        'theme_id',
    ];

    protected $appends = [
        'questions',
        'user',
        'theme'
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(Questions::class, 'test_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class, 'theme_id', 'id');
    }

    public function getQuestionsAttribute(): mixed
    {
        return $this->questions()->get();
    }

    public function getUserAttribute(): mixed
    {
        return $this->user()->first();
    }

    public function getThemeAttribute(): mixed
    {
        return $this->theme()->first();
    }
}
