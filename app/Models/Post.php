<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Tên bảng trong database
    protected $table = 'posts';

    // Khóa chính mặc định là 'id' nên không cần khai báo lại
    // protected $primaryKey = 'id';

    // Các cột được phép gán hàng loạt (mass assignment)
    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'status',
        'user_id',
    ];

    // ===================== Quan hệ (Relationship) =====================

    // Một Post THUỘC VỀ một User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
