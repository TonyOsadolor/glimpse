<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * The attributes that are not mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = ['id'];

    /**
     * Get the comments for the blog post.
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'company_id', 'user_id');
    }
}
