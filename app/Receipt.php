<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Receipt extends Model
{
    /**
     * Get all of the items for the Invoice
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(ReceiptItem::class);
    }
    /**
     * Get the project that owns the Invoice
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
