<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Cuti extends Model
{

    
    /** @use HasFactory<\Database\Factories\CutiFactory> */
    use HasFactory, Notifiable;

protected $table = 'pengajuan_cuti';

protected $fillable = [
    
    'name',
    'jenis_cuti',
    'tanggal_pengajuan',
    'tanggal_mulai',
    'tanggal_selesai',
    'alasan',
    'status',
    'file',
];
   
    
}
