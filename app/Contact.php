<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    
    /**
     * Get the supportive that owns the Contact
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supportive()
    {
        return $this->belongsTo(Supportive::class);
    }
}