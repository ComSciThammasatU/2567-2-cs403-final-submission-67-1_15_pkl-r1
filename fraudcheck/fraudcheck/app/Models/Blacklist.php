<?php
namespace App\Models;
use App\Models\AppUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blacklist extends Model
{
    use HasFactory; //ใช้สำหรับเชื่อมไปยัง factory เผื่อไว้

    protected $fillable = [ 
        'user_id', 'name', 'surname', 'idcard', 'bankType', 'bankAccount', 'amount', 'productName', 'telephone',
        'additional_notes', 'product_images', 'conversation_images', 'payment_proof_images', 
        'payment_date', 'communication_platform', 'status'
    ];
    //แปลงชนิดภาพให้เป็น array เป็น json (เก็บภาพ), json เป็น array (แสดงภาพ) อัตโนมัติ
    protected $casts = [ 
        'product_images' => 'array', 
        'conversation_images' => 'array',
        'payment_proof_images' => 'array',
        'payment_date' => 'date',
    ];

    public function user() //กำหนดให้ Blacklist เป็นลูกของ AppUser เพราะมีการใช้ Foreign Key
    {
        return $this->belongsTo(AppUser::class, 'user_id');
    }
    
}