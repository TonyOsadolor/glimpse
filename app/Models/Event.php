<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    /**
     * The attributes that are not mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = ['id'];

    /**
     * Assign UUIDs to Model Crated
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    /**
     * Scope is Active
     */
    public function scopeActive()
    {
        return $this->where('is_active', true);
    }

    /**
     * Get the Company associated with the Category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event_category()
    {
        return $this->belongsTo(EventCategory::class, 'event_category_id');
    }

    /**
     * Get the Company associated with the Category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'user_id');
    }

    /**
     * Get the Company associated with the Category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(RegisterEvent::class);
    }
}
