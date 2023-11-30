<?php

namespace RealSoft\RealKardex;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class StockMutation extends Model
{
    protected $fillable = [
        'stockable_type',
        'stockable_id',
        'reference_type',
        'reference_id',
        'warehouse_type',
        'warehouse_id',
        'amount',
        'description',
    ];

    /**
     * StockMutation constructor.
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('stock.table', 'stock_mutations'));
    }

    /**
     * Relation.
     *
     * @return MorphTo
     */
    public function stockable()
    {
        return $this->morphTo();
    }

    /**
     * Relation.
     *
     * @return MorphTo
     */
    public function reference()
    {
        return $this->morphTo();
    }
    
    /**
     * Relation.
     *
     * @return MorphTo
     */
    public function warehouse()
    {
        return $this->morphTo();
    }
}