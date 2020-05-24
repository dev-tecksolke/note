<?php

namespace Note\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use Uuids, SoftDeletes;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    //set attributes
    protected $guarded = [];

    /**
     * get the models
     * relating here
     * @return MorphTo
     */
    public function notification()
    {
        return $this->morphTo(Notification::class);
    }
}
