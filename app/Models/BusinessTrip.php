<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessTrip extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'nama',
        'no_sppd',
        'unit_1',
        'atasan_1',
        'email_1',
        'unit_2',
        'atasan_2',
        'email_2',
        'divisi',
        'mulai',
        'kembali',
        'tujuan',
        'keperluan',
        'bb_perusahaan',
        'norek_krywn',
        'nama_pemilik_rek',
        'nama_bank',
        'ca',
        'tiket',
        'hotel',
        'taksi',
        'id_ca',
        'id_tiket',
        'id_hotel',
        'id_taksi',
        'status',

    ];

    protected $table = 'bt_transaction';
}
