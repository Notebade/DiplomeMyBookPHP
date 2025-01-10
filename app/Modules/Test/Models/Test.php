<?php
declare(strict_types=1);

namespace App\Modules\Test\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = [
      'questions',
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(Questions::class, 'test_id', 'id');
    }

    public function getQuestionsAttribute(): mixed
    {
        return $this->questions()->get();
    }
}
