<?php
declare(strict_types=1);

namespace App\Modules\Test\Models;

use App\Modules\Media\Models\Media;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Questions extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'questions';

    protected $fillable = [
        'type_id',
        'test_id',
        'text',
    ];

    protected $hidden = [
        'type_id',
        'test_id',
    ];

    protected $appends = [
        'type',
        'media',
        'answers',
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(QuestionType::class, 'type_id');
    }

    public function media(): BelongsToMany
    {
        return $this->belongsToMany(Media::class, 'media_question', 'question_id', 'media_id');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answers::class , 'question_id');
    }

    public function getTypeAttribute(): mixed
    {
        return $this->type()->first();
    }

    public function getMediaAttribute(): mixed
    {
        return $this->media()->first();
    }

    public function getAnswersAttribute(): mixed
    {
        return $this->answers()->get();
    }
}
