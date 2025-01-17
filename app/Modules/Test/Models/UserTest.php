<?php
declare(strict_types=1);

namespace App\Modules\Test\Models;

use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserTest extends Model
{
    //answer_user_test
    use HasFactory;

    public $timestamps = false;

    protected $table = 'user_test';

    protected $fillable = [
        'type_id',
        'test_id',
        'trail',
        'score',
        'user_id',
    ];

    protected $hidden = [
        'type_id',
        'test_id',
        'user_id',
    ];

    protected $appends = [
        'answers',
        'user',
    ];

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class, 'test_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(UserAnswersType::class, 'type_id');
    }

    public function answers(): BelongsToMany
    {
        return $this->belongsToMany(Answers::class, 'answer_user_test', 'user_test_id', 'answers_id');
    }

    public function getAnswersAttribute(): mixed
    {
        return $this->answers()->get();
    }

    public function getUserAttribute(): mixed
    {
        return $this->user()->get();
    }
}
