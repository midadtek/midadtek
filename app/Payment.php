<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Payment extends Model
{
    /**
     * Get the project that owns the Payment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
