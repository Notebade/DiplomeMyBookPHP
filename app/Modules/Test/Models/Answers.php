<?php
declare(strict_types=1);

namespace App\Modules\Test\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answers extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'answers';

    protected $fillable = [
        'text',
        'question_id',
        'right'
    ];

    protected $hidden = [
        'question_id',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Questions::class, 'question_id', 'id');
    }

    public function jsonSerialize(bool $hideAnswers = true): mixed
    {
        if (!$hideAnswers) {
            return self::toArray();
        }

        return [
            'id' => $this->id,
            'text' => $this->text,
        ];
    }
}
