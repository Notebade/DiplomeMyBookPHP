<?php
declare(strict_types=1);

namespace App\Modules\Test\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionType extends Model
{
    use HasFactory, SoftDeletes;

    protected $timestamp = false;

    protected $table = 'question_type';

    protected $fillable = [
        'type_id',
        'test_id',
        'text',
    ];

    protected $hidden = [
        'type_id',
        'test_id',
    ];


}
