<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    // Tên bảng trong database
    protected $table = 'brands';

    // Khóa chính mặc định là 'id' nên không cần khai báo lại
    // protected $primaryKey = 'id';

    // Các cột được phép gán hàng loạt (mass assignment)
    protected $fillable = [
        'brandname',
        'slug',
        'image',
        'status',
        'sort_order',
        'description',
    ];

    // ===================== Quan hệ (Relationship) =====================

    // Một Brand CÓ NHIỀU Products
    public function products()
    {
        return $this->hasMany(Product::class, 'brandid', 'id');
    }
}
