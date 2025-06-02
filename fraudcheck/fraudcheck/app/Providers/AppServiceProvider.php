<?php

// app/Providers/AppServiceProvider.php
namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Paginator::useBootstrapFive(); //ตกแต่งระบบแบ่งหน้า
        Schema::defaultStringLength(191); //กำหนดให้คอลัมน์มีขนาดสูงสุด 191 ตัว

        // เตรียมใช้งานในระบบ online ถ้าระบบใช้ VERCEL_ENV (ตัวทดสอบ)
        if (env('VERCEL_ENV')) {
            URL::forceScheme('https'); //ให้เรียกใช้ Https เพราะปลอดภัยกว่า http
        }
    }

}


