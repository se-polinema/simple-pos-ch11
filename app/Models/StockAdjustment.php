<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Audit trail for manual stock corrections (restock, shrinkage, count fix) —
 * created by ProductController::adjustStock(), the only path allowed to change
 * an existing product's stock outside of a sale/void.
 */
class StockAdjustment extends Model
{
    protected $fillable = ['product_id', 'user_id', 'delta', 'stock_after', 'reason'];

    protected function casts(): array
    {
        return [
            'delta' => 'integer',
            'stock_after' => 'integer',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
