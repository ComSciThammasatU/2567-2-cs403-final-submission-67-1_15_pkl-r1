<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\AppUser;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // ค้นหาผู้ใช้ที่มี username เป็น 'admin'
        $admin = AppUser::where('username', 'admin')->first();

        if ($admin) {
            // อัปเดตข้อมูลหากมีอยู่แล้ว
            $admin->update([
                'email' => 'admin@fraudcheck.com',
                'password' => Hash::make('000000'),
                'role' => 'admin',
            ]);
        } else {
            // สร้างใหม่ถ้ายังไม่มี
            AppUser::create([
                'username' => 'admin',
                'email' => 'admin@fraudcheck.com',
                'password' => Hash::make('000000'),
                'role' => 'admin',
            ]);
        }
    }
}
