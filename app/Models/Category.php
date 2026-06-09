<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Tên bảng trong database
    protected $table = 'categories';

    // Khóa chính (không phải 'id' mặc định)
    protected $primaryKey = 'cateid';

    // Các cột được phép gán hàng loạt (mass assignment)
    protected $fillable = [
        'catename',
        'slug',
        'image',
        'status',
        'sort_order',
        'description',
    ];

    // ===================== Quan hệ (Relationship) =====================

    // Một Category CÓ NHIỀU Products
    public function products()
    {
        return $this->hasMany(Product::class, 'cateid', 'cateid');
    }
}
