<?php

namespace App\Models;

use App\Models\product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class invoice_products extends Model
{
    protected $fillable = ['invoice_id', 'product_id', 'user_id', 'quantity', 'sale_price'];

    function product ():BelongsTo {
        return $this->belongsTo(product::class);
    }

}
