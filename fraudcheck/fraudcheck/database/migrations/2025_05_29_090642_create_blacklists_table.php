<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlacklistsTable extends Migration
{
    public function up() //สร้างตาราง
    {
        Schema::create('blacklists', function (Blueprint $table) {
            $table->id(); //ไอดีรายงาน
            $table->unsignedBigInteger('user_id')->nullable(); //เก็บไอดีที่เพิ่มรายงาน (อาจซ้ำกันได้เพราะ1ไอดีอาจลงรายงานมากกว่า 1 ครั้ง)
            $table->string('name'); //ชื่อ
            $table->string('surname'); //นามสกุล
            $table->string('idcard')->nullable(); //เลขบัตรประชาชน ไม่ใส่ก็ได้
            $table->string('bankType')->nullable(); //ชนิดของธนาคาร ไม่ใส่ก็ได้
            $table->string('bankAccount')->nullable(); //เลขบัญชีธนาคาร ไม่ใส่ก็ได้
            $table->integer('amount'); //ราคาสินค้า
            $table->string('productName')->nullable(); //ชื่อสินค้า ไม่ใส่ก็ได้
            $table->string('telephone')->nullable(); //เพิ่ม telephone 
            $table->string('status')->default('pending'); //สถานะรายงาน เริ่มต้น Pending
            $table->timestamps(); //วันที่สร้าง , วันที่อัพเดท รายงาน
            $table->text('additional_notes')->nullable(); //คอมเม้นผู้ใช้งาน ไม่ใส่ก็ได้
            $table->json('product_images')->nullable();  //ภาพสินค้า ไม่ใส่ก็ได้
            $table->json('conversation_images')->nullable(); //ภาพการสนทนา ไม่ใส่ก็ได้
            $table->json('payment_proof_images')->nullable(); //สลิปโอนเงิน ไม่ใส่ก็ได้
            $table->date('payment_date')->nullable(); //วันที่โอนเงิน ไม่ใช่ก็ได้
            $table->string('communication_platform')->nullable(); //แอปพลิเคชันโอนเงิน ไม่ใส่ก็ได้
           
            //Foreign คือ กำหนด key เชื่อมตาราง 2 ตัวระหว่าง blacklists กับ app_users
            $table->foreign('user_id')->references('id')->on('app_users')->onDelete('set null'); //ถ้าลบ id ค่า user_id จะเป็นค่าว่าง (รายงานจะอยู่ในระบบอยู่)
        });
    }

    public function down() //เผื่อลบตาราง
    {
        Schema::dropIfExists('blacklists'); //ลบตาราง blacklists ในกรณีผิดพลาด
    }
}

