<?php
declare(strict_types=1);

namespace App\Modules\Media\Models;

use App\Modules\User\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use HasFactory, SoftDeletes;

    protected $timestamp = false;

    protected $table = 'media_files';

    protected $fillable = [
        'path',
        'user_id',
        'name',
        'type'
    ];

    protected $appends = [
        'path',
        'user',
        'name',
        'type',
        'dateCreated',
        'dateUpdated',
    ];

    protected $hidden = [
        'deleted_at',
        'created_at',
        'updated_at',
        'parent_id',
        'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getUserAttribute()
    {
        return $this->user()->first();
    }

    public function getNameAttribute(): ?string
    {
        return $this->attributes['name'] ?? null;
    }

    public function getTypeAttribute(): ?string
    {
        return $this->attributes['type'] ?? null;
    }

    public function getPathAttribute(): ?string
    {
        return $this->attributes['path'] ?? null;
    }

    public function getDateCreatedAttribute(): ?string
    {
        return Carbon::create($this->attributes['created_at'])->format('Y.m.d H:i') ?? null;
    }

    public function getDateUpdatedAttribute(): ?string
    {
        if (Carbon::create($this->attributes['created_at'])->eq(Carbon::create($this->attributes['updated_at']))) {
            return null;
        }
        return Carbon::create($this->attributes['updated_at'])->format('Y.m.d H:i') ?? null;
    }
}
