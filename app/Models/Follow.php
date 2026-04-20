<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Follow extends Pivot
{
    protected $table = 'follows';

    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id');
    }

    public function followedUser()
    {
        return $this->belongsTo(User::class, 'following_id');
    }
}
