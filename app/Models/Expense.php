<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'amount',
        'description',
        'user_id',
        'created_at',
    ];

    protected $casts = [
        'amount' => 'decimal:0',
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Kategori pengeluaran yang tersedia
    public static function categories(): array
    {
        return [
            'Makan & Minum',
            'Transportasi',
            'Operasional Toko',
            'Listrik & Air',
            'Sewa',
            'Gaji',
            'Belanja Stok',
            'Perbaikan',
            'Internet & Pulsa',
            'Lainnya',
        ];
    }
}
