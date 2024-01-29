<?php

namespace App\Models;

use App\Models\invoice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class product extends Model
{
    protected $fillable = ['name', 'price', 'unit', 'img_url', 'category_id', 'user_id'];

}






