<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use App\Models\AppUser;

class CreateAppUsersTable extends Migration
{
    public function up()
    {
        Schema::create('app_users', function (Blueprint $table) {
            $table->id(); //หมายเลขประจำตัวผู้ใช้
            $table->string('username')->unique(); //เก็บ ชื่อผู้สมัคร login (ห้ามซ้ำกัน)
            $table->string('email')->unique(); //เก็บอีเมลผู้สมัคร (ห้ามซ้ำกัน)
            $table->string('telephone')->nullable(); //สร้างคอลัมธ์ telephone
            $table->string('password'); //เก็บรหัสผ่าน
            $table->string('role')->default('user'); //เก็บบทบาท ค่าเริ่มต้นเป็น user(ผู้ใช้งาน)
            $table->timestamps(); //วันที่สร้าง,อัพเดทตาราง
            $table->string('profile_picture')->nullable(); //เก็บรูปโปรไฟล์ 
            $table->boolean('email_verified')->default(false); //เก็บการยืนยัน otp ว่าผู้ใช้งานยืนยันหรือยัง? โดยค่าเริ่มต้นเป็น false (0=ไม่ยืนยัน , 1=ยืนยันแล้ว)
            $table->string('otp')->nullable(); //เก็บรหัส OTP ที่ใช้สำหรับยืนยันตัวตนสำหรับผู้ใช้งานที่ไม่กรอก OTP , เมื่อ OTP ถูกกรอก ค่าในคอลัมธ์ OTP ก็จะเป็น Null
            $table->timestamp('otp_expiry')->nullable(); //เก็บเวลาหมดอายุของ OTP เมื่อผู้ใช้งานที่ไม่กรอก OTP , เมื่อ OTP ถูกกรอก ค่าในคอลัมธ์ otp_expiry ก็จะเป็น Null
            $table->string('session_id')->nullable();
        });

        // เช็คในตาราง "app_users" ว่ายังไม่มีผู้ใช้ที่ชื่อ "admin" ให้สร้างขึ้นใหม่ , exists() = มีข้อมูลในระบบไหม?
        if (!AppUser::where('username', 'admin')->exists()) {
            AppUser::create([
                'username' => 'admin', //คอลัมธ์ชื่อผู้ใช้เพิ่ม "admin"
                'email' => 'admin@fraudcheck.com', //คอลัมธ์อีเมลเพิ่ม "admin@blacklistsellers.com"

               // Hash::make() เป็นฟังก์ชันของ laravel ป้องกันการถูกแฮ็ครหัสผ่าน
               // ก็คือจะทำการแปลงรหัสผ่านใหม่ทุกครั้งก่อนเข้าสู่ระบบ เช่น จาก "00000000" เป็น "$2y$10$JvFH65d8vK" 
                'password' => Hash::make('000000'), 
                'role' => 'admin', //เปลี่ยนจาก user เป็น admin
                'email_verified'=> 1,
            ]);
        }
    }

    public function down()
    {
        Schema::dropIfExists('app_users'); //ถ้าเกิดจะยกเลิกหรือย้อนกลับ จะทำการลบตารางออก
    }
}


