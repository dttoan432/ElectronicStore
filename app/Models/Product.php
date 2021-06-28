<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'slug',
        'quantity',
        'origin_price',
        'sale_price',
        'discount_percent',
        'content',
        'content_more',
        'user_id',
        'category_id',
        'trademark_id',
        'status'
    ];

    const STATUS_INIT = 0;
    const STATUS_BUY = 1;
    const STATUS_STOP = 2;

    public static $status_text = [
        self::STATUS_INIT => 'Đang nhập',
        self::STATUS_BUY => 'Đang bán',
        self::STATUS_STOP => 'Dừng bán'
    ];

    public function getStatusTextAttribute()
    {
        if ($this->status == 0) {
            return 'Đang nhập';
        } elseif ($this->status == 1) {
            return 'Đang bán';
        } else {
            return 'Dừng bán';
        }
    }

    public function getContentMoreJsonAttribute(){
        $content_json = json_decode($this->content_more, true);
        return $content_json;
    }

    protected $casts = [
//        'content_more' => 'array'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function trademark()
    {
        return $this->belongsTo(Trademark::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    public function scopeSearch($query, $request)
    {
        if ($request->has('q')) {
            $query->where('name', 'LIKE', '%'.$request->q.'%')->orderBy('created_at', 'DESC');
        }

        return $query;
    }

    public function scopeStatus($query, $request)
    {
        if ($request->has('status')) {
            if ($request->get('status') == -1) {
                $query->orderBy('created_at', 'DESC');
            } else {
                $query->where('status', $request->status)->orderBy('created_at', 'DESC');
            }
        }

        return $query;
    }

    public function scopeTrade($query, $request)
    {
        if ($request->has('trademark')) {
            if ($request->get('trademark') == -1) {
                $query->orderBy('created_at', 'DESC');
            } else {
                $query->where('trademark_id', $request->trademark)->orderBy('created_at', 'DESC');
            }
        }

        return $query;
    }

    public function scopeCategory($query, $request)
    {
        if ($request->has('category')) {
            if ($request->get('category') == -1) {
                $query->orderBy('created_at', 'DESC');
            } else {
                $query->where('category_id', $request->category)->orderBy('created_at', 'DESC');
            }
        }

        return $query;
    }
}
