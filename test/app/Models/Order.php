<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_customer',
        'kendaraan_id',
        'tanggal_sewa',
        'tanggal_kembali',
        'total_harga',
        'tanggal_buat_order',
        'tanggal_ubah_order',
    ];

    // protected $dates = [
    //     'tanggal_sewa',
    //     'tanggal_kembali',
    //     'tanggal_buat_order',
    //     'tanggal_ubah_order'
    // ];


    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }
}
