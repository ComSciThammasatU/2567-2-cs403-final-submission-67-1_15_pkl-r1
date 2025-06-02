<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request; //จัดการข้อมูล request จาก user
use Illuminate\Support\Carbon; //จัดการข้อมูลวัน เวลา (วันที่สมัคร, วันหมดอายุ OTP)
use App\Http\Controllers\AuthController;    //เชื่อมกับ Controller
use App\Http\Controllers\ReportController;  //เชื่อมกับ Controller
use App\Http\Controllers\ProtestController; //เชื่อมกับ Controller
use App\Http\Controllers\ProfileController; //เชื่อมกับ Controller
use App\Http\Middleware\CheckRole; //เชื่อมกับ Middleware Check role
use App\Http\Middleware\PreventMultipleLogin; //เชื่อมกับ Middleware PreventMultipleLogin การล็อคอินซ้อน
use Illuminate\Support\Facades\DB; //ใช้ Query Builder ของ Laravel เพื่อเข้าถึงฐานข้อมูลโดยตรง (กรณีที่ไม่ใช้ Model)
use App\Models\Blacklist; //เชื่อมกับตาราง Blacklist ใน model
use App\Http\Controllers\OtpController;     //เชื่อมกับ Controller
use Illuminate\Support\Facades\Mail; //ใช้สำหรับส่งอีเมลจาก smtp(ตัวส่ง otp) ไปยัง user
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//______________________________________________________ผู้ใช้งานทั่วไป (ไม่ต้อง Login)___________________________________________________________

//1. หน้าหลัก
Route::view('/', 'welcome'); //หน้าล็อคอิน
Route::get('/welcome', function () {
    return view('welcome'); //หน้าล็อคอิน
})->name('welcome');


//2. ระบบหน้าค้นหา
Route::get('/search', function () {
    return view('search'); //หน้าค้นหา
})->name('search');
    //2.1 ส่ง request การค้นหาไปแมชกับฐานข้อมูล
Route::post('/search', [ReportController::class, 'search']);


//3. ระบบหน้าดูรายละเอียดเพิ่มเติม(มีเลขรายงาน)
Route::get('/moreinfo/{id}', function ($id) { //id = เลขรายงาน
    $report = Blacklist::findOrFail($id); //ค้นหาไอดีรายงานใน model Blacklist มีเลขไอดีไหม และเก็บลงใน $report(ไม่มีเลขไอดีจะขึ้น 404not found)
    return view('moreinfo', compact('report')); //ส่งตัวแปร report ไปหน้า moreinfo
})->name('moreinfo');


//4. ระบบสมัครสมาชิก (รับ request จากหน้าเว็บ)
Route::post('/register', [AuthController::class, 'register'])->name('register'); //ส่ง request ไปที่ Controller


//5. ระบบ Log in เข้าสู่ระบบ (รับ request จากหน้าเว็บ)
Route::post('/profile', [AuthController::class, 'loginSubmit']); //หน้า login ใช้ส่ง request ไป Controller


//______________________________________________________ผู้ใช้ที่เป็นสมาชิก (Log in)______________________________________________________________

//6. ระบบแสดงหน้าโปรไฟล์ (Login แล้ว)
Route::get('/profile', [ProfileController::class, 'index'])->middleware(['auth', PreventMultipleLogin::class])->name('profile');//(จำเป็นต้อง login) 


//7. ระบบเพิ่มรายงาน
    //7.1 ตารางรายงานฉ้อโกง
Route::get('/user-reports', [ReportController::class, 'userReports'])->middleware(['auth', PreventMultipleLogin::class])->name('user.reports');//แสดงตารางรายงานฉ้อโกงที่เพิ่ม
    //7.2 แสดงหน้าเพิ่มรายงาน (User)
Route::get('/newreport', function () {
     return view('newreport'); 
    })->middleware(['auth', PreventMultipleLogin::class])->name('newreport');
    //7.3 รับ request ข้อมูลเพิ่มรายงานจาก user
Route::post('/reports', [ReportController::class, 'store'])->middleware(['auth', PreventMultipleLogin::class])->name('reports.store');//ส่ง request ไปทำงานที่ Controller


//8. ระบบแจ้งรายงาน
    //8.1 ฟอร์มการแจ้งรายงาน
Route::get('/protest/{id}', [ProtestController::class, 'showForm'])->middleware(['auth', PreventMultipleLogin::class])->name('protest.form');//แจ้งรายงาน(ตามด้วยid)
    //8.2 ส่ง request หน้าแจ้งรายงาน
Route::post('/protest/{id}', [ProtestController::class, 'store'])->middleware(['auth', PreventMultipleLogin::class])->name('protest.store');//ส่ง request แจ้งรายงาน



//9. ระบบแก้ไขข้อมูลส่วนตัว
    //9.1 หน้าแก้ไขข้อมูล
Route::get('/editprofile', [ProfileController::class, 'edit'])->middleware(['auth', PreventMultipleLogin::class])->name('editprofile'); //แสดงหน้าแก้ไขโปรไฟล์ ทำงานที่ controller
    //9.2 ส่ง request แก้ไขแบบ put(แก้ไข้ข้อมูลทั้งหมดในหน้านี้)
Route::put('/updateprofile', [ProfileController::class, 'update'])->middleware(['auth', PreventMultipleLogin::class])->name('updateprofile'); 


//10. ระบบเปลี่ยนพาส
    //10.1 หน้าเปลี่ยนพาส
Route::get('/editpassword', [ProfileController::class, 'editPassword'])->middleware(['auth', PreventMultipleLogin::class])->name('editpassword'); //เปลี่ยนรหัสผ่าน
    //10.2 ส่ง request แก้ไขแบบ put(แก้ไข้ข้อมูลทั้งหมดในหน้านี้)
Route::put('/updatepassword', [ProfileController::class, 'updatePassword'])->middleware(['auth', PreventMultipleLogin::class])->name('updatepassword');//แก้ไขรหัสผ่านแบบ put(แก้ไขทั้งหมด)



//______________________________________________________ระบบของ admin______________________________________________________________________

//11. ระบบดูรายงาน admin

    //11.1 แสดงหน้ารายงาน admin
Route::get('/reportlist', [ReportController::class, 'reportList'])->middleware(['auth', CheckRole::class])->name('reportlist');
    //11.2 ปุ่มเปลี่ยนสถานะรายงาน admin (patch แก้ไขบางส่วน)
Route::patch('/report/{id}', [ReportController::class, 'update'])->name('report.update'); //patch แก้ไขข้อมูลบางส่วน ใช้กับ javascript ใน reportlist  แค่เปลี่ยนสถานะ status(จาก pending เป็น Approve)
    //11.3 ลบรายงาน admin
    Route::delete('/report/{id}', [ReportController::class, 'destroy'])->name('report.destroy');
    //ลบรายงาน


//12. แสดงหน้าดูแจ้งรายงาน admin
Route::get('/protests', [ProtestController::class, 'index'])->middleware(['auth', CheckRole::class])->name('protests.index'); //ใช้แสดงหน้าแจ้งคำร้อง admin




//______________________________________________________ออกจากระบบ_________________________________________________________________________

Route::get('/logout', function (Request $request) { //รับ request เมื่อกดปุ่ม logout
    Auth::logout(); //auth ออกจากระบบ และเคลียข้อมูล
    $request->session()->invalidate(); //ลบ session เมื่อล็อคเอ้าท์ (ชุดข้อมูลชั่วคราว)
    $request->session()->regenerateToken();//สร้าง csrf ใหม่ (CSRF Token = ตัวป้องกันการแฮกจากฟอร์มหรือลิงก์ปลอม)
    return redirect('/'); //พากลับหน้าแรก
})->name('logout');



//______________________________________________________ระบบ OTP_________________________________________________________________________

//13. ระบบส่ง otp
    //หน้าส่ง otp (อีเมล)
Route::get('/otp', [OtpController::class, 'showOtpForm'])->name('otp.form')->middleware(['auth']);//แสดงหน้า otp
    //request ของ otp
Route::post('/verify-otp', [OtpController::class, 'verifyOtp'])->name('otp.verify'); //ส่ง request

//14.ส่ง OTP อีกรอบ
Route::post('/resend-otp', [OtpController::class, 'resend'])->name('otp.resend');

//15. ทดสอบส่งข้อความไปอีเมล จาก Laravel ไป อีเมล โดยใช้ SMTP ก่อนส่ง
Route::get('/test-email', function() { //ทดสอบการส่งอีเมล
    Mail::raw('ทดสอบการส่งอีเมลจาก Laravel', function($message) {//เนื้อหาอีเมล
        $message->to('konosubarashii2@gmail.com') //ส่งอีเมลไปที่ :
                ->subject('ทดสอบการส่งอีเมล');//หัวเรื่อง
    });

    return "ทดสอบสำเร็จ"; //แสดงข้อความบนเว็บ
});



//______________________________________________________คำแนะนำ_________________________________________________________________________

//16. คำแนะนำผู้ใช้งาน(หน้าหลัก)
Route::get('/guide', function () {
    return view('guide'); 
})->name('guide');

    //15.1 สมัครสมาชิก
Route::get('/guideregister', function () {
    return view('guide1.guideregister'); 
})->name('guideregister');

    //15.2 การค้นหา
Route::get('/guidesearch', function () {
    return view('guide1.guidesearch'); 
})->name('guidesearch');

    //15.3 การเพิ่มรายงาน
Route::get('/guidereport', function () {
    return view('guide1.guidereport'); 
})->name('/guidereport');

    //15.4 การแจ้งคำร้อง
Route::get('/guideprotest', function () {
    return view('guide1.guideprotest'); 
})->name('guideprotest');


//__________________________ตรวจสอบอินเทอร์เน็ต____________________________________________
Route::get('/offline', function () {
    return view('offline');
});
