<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    // Tên bảng trong database
    protected $table = 'products';

    // Khóa chính mặc định là 'id' nên không cần khai báo lại
    // protected $primaryKey = 'id';

    // Các cột được phép gán hàng loạt (mass assignment)
    protected $fillable = [
        'productname',
        'slug',
        'price',
        'pricediscount',
        'image',
        'description',
        'status',
        'cateid',
        'brandid',
    ];

    // ===================== Quan hệ (Relationship) =====================

    // Một Product THUỘC VỀ một Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'cateid', 'cateid');
    }

    // Một Product THUỘC VỀ một Brand
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brandid', 'id');
    }

    // Một Product CÓ NHIỀU ProductImages
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }
}
