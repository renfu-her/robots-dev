<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'description',
        'sort_order',
        'image'
    ];

    // 獲取子分類（支持多層）
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')
            ->with('children')  // 遞歸加載所有子分類
            ->orderBy('sort_order', 'asc');
    }

    // 獲取所有上層分類
    public function ancestors()
    {
        $ancestors = collect();
        $parent = $this->parent;

        while ($parent) {
            $ancestors->prepend($parent);
            $parent = $parent->parent;
        }

        return $ancestors;
    }

    // 獲取完整分類路徑名稱
    public function getFullPathAttribute()
    {
        return $this->ancestors()
            ->pluck('name')
            ->push($this->name)
            ->implode(' > ');
    }

    // 獲取父分類
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // 獲取頂層分類及其子分類
    public static function getMainCategories()
    {
        return self::where('parent_id', 0)
            ->orderBy('sort_order')
            ->with(['children' => function ($query) {
                $query->orderBy('sort_order');
            }])
            ->get();
    }

    // 獲取該分類下的熱門商品
    public function getHotProducts($limit = 5)
    {
        return $this->products()
            ->where('is_hot', true)
            ->where('is_active', true)
            ->with('primaryImage')
            ->limit($limit)
            ->get();
    }

    // 與商品的關係
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // 獲取圖片完整URL
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/categories/' . $this->image);
        }
        return asset('images/no-image.png'); // 預設圖片
    }
}
