<?php
declare(strict_types=1);

namespace App\Modules\Test\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswersType extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'answer_user_test';

    protected $fillable = [
        'code',
        'name',
    ];
}
