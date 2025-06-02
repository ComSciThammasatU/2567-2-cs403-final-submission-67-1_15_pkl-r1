<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{ //สร้างตารางเก็บรายงานคำร้อง
    Schema::create('protests', function (Blueprint $table) {
        $table->id(); //เก็บหมายเลขรายงาน
        $table->unsignedBigInteger('report_id'); //เลขไอดีที่รายงาน
        $table->unsignedBigInteger('user_id'); //เลขไอดีคนร้องเรียน
        $table->string('title'); //หัวข้อในการร้องเรียน
        $table->text('description'); //รายละเอียดร้องเรียน
        $table->json('images')->nullable(); //เก็บรูป มีหรือไม่ก็ได้
        $table->timestamps();//เวลาสร้าง และอัพเดท

        //นำ report_id(เลขไอดีที่รายงาน) ไปเชื่อมกับ id บน blacklists(รายงานการฉ้อโกง) และถ้าลบการร้องเรียนที่เกี่ยวข้องจะถูกลบด้วย
        $table->foreign('report_id')->references('id')->on('blacklists')->onDelete('cascade');
        //นำ user_id(ไอดีคนร้องเรียน) ใน protests ไปเชื่อมกับ id บน app_user และถ้าลบการร้องเรียนที่เกี่ยวข้องจะถูกลบด้วย
        $table->foreign('user_id')->references('id')->on('app_users')->onDelete('cascade');
    });
}

public function down()
{ //ถ้ามีการย้อนกลับ หรือแก้ไข ก็จะทำการลบตาราง protests
    Schema::dropIfExists('protests');
}
};
