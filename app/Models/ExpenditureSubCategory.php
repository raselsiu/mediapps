<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenditureSubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'subcategory', 'subc_slug',
    ];
}
