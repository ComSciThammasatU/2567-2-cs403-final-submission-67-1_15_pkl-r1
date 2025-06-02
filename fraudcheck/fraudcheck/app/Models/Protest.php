<?php

namespace App\Models;
use App\Models\AppUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Protest extends Model
{
    use HasFactory; //อาจใช้ factory

    protected $fillable = ['report_id', 'user_id', 'title', 'description', 'images']; //เรียกใช้คอลัมธ์ที่ create หรือ update

    protected $casts = [ //นำคอลัมธ์มาเปลี่ยนชนิดตัวแปร
        'images' => 'array', //รูปภาพเก็บได้หลายไฟล์ ให้เก็บเป็น array
    ];


    //ให้ Protest สามารถใช้ตารางของ AppUser และ Blacklist ได้
    public function user() //ขอเป็นคลาสลูกในโมเดล AppUser โดยใช้คอลัมธ์ user_id
    {
        return $this->belongsTo(AppUser::class , 'user_id');
    }

    public function report() //ขอเป็นคลาสลูกในโมเดล blacklist
    {
        return $this->belongsTo(Blacklist::class, 'report_id' );
    }
}