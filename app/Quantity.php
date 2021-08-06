<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Quantity extends Model
{
    /**
     * Get the project that owns the Quantity
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    /**
     * Get the stage that owns the Quantity
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }
}
