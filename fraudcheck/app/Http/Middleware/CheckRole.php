<?php

namespace App\Http\Middleware; //ระบุตำแหน่ง middleware

use Closure; //ใช้สำหรับเรียก Middleware ถัดไป
use Illuminate\Http\Request; //รับ request ที่ส่งมา
use Illuminate\Support\Facades\Auth; //ตรวจสอบสถานะล็อคอิน

class CheckRole //ประกาศ class เช็คโรล
{
    //request = Admin ล็อคอินเข้ามา , $next = อนุมัติ
    public function handle(Request $request, Closure $next) 
    {

        //ผู้ใช้งานไม่ได้ล็อคอิน หรือ ล็อคอินแต่โรลไม่ใช่ admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.'); //ให้ไม่เข้าเงื่อนไข และถูกปิดกั้น, Laravel จะแสดงข้อความ 'Unauthorized action'
        }

        return $next($request); //ยืนยันว่าเป็นแอดมิน (อนุม้ติ request)
    }
}
