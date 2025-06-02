<?php

namespace App\Http\Controllers;
use App\Models\AppUser;
use App\Models\Protest;
use App\Models\Blacklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProtestController extends Controller
{   
    //แสดงแจ้งรายงานของ admin
    public function index() 
    {   //'user','report' โหลดข้อมูลที่มีการจับคู่แล้ว (foreign key) โดยใช้ belongto
        $protests = Protest::with('user', 'report')->latest()->paginate(10);  
        return view('protests.index', compact('protests')); 
    }

    public function showForm($id) //แสดงรายงานที่แจ้ง รับเลขid
    {
        $report = Blacklist::findOrFail($id); //ค้นหาเลขไอดีใน blacklist
        return view('protest_form', compact('report')); //ส่ง report ไปทำงานที่ view
    }

    public function store(Request $request, $id) //รับ request และ เลขid
    {
        $request->validate([ //ตรวจสอบความถูกต้อง request
            'reason' => 'required', //ช่องติ๊กแจ้งรายงาน (บังคับกด)
            'description' => 'required_if:reason,2', //ถ้ากดติ๊กช่อง 2 (บังคับกรอก description ด้วย)
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,heic,heif|max:5120',//ไฟล์รูปภาพ ขนาดไม่เกิน 2MB
        ]);

        $report = Blacklist::findOrFail($id); //นำเลข id มาดึงรายงานจากโมเดล Blacklist
        $imageUrls = []; //สร้าง array เก็บค่ารูปภาพ
        if ($request->hasFile('images')) { //ถ้ามีไฟล์รูป
            foreach ($request->file('images') as $image) { //วนลูปเก็บไฟล์ภาพ
                $path = $image->store('protest_images', 'public'); //เก็บลงพาธ public/protest_images
                $imageUrls[] = asset('storage/' . $path); //นำพาธมาเก็บใน Storage จะได้ storage/app/public/protest_images และจัดเก็บในชื่อไฟล์ภาพใน array

            }
        }
        //ถ้า request(ช่องกดติ๊ก) = 1 ไม่ต้องกรอก description , ถ้าไม่ใช่ ให้กรอก 
        $description = $request->reason == '1' ? '-' : $request->description; 

        //'report_id'=คอลัมธ์ฐานข้อมูล //$report->id = request
        Protest::create([ //ให้โมเดลรายงานสร้างตาราง
            'report_id' => $report->id, //เลขแจ้งรายงาน
            'user_id' => Auth::id(), //id ค้นแจ้ง
            'title' => $request->reason == '1' ? 'กรอกข้อมูลรายงานผิดพลาด' : 'อื่นๆ', //หัวข้อที่ติ๊ก(ถ้าติ๊ก1 = กรอกรายงานผิดพลาด,ถ้าไม่ใช่ = อื่นๆ)
            'description' => $description, //ถ้ามีให้กรอก descroption ให้เก็บ
            'images' => $imageUrls, //เก็บชื่อไฟล์ภาพจาก array
        ]);

        return redirect('/profile')->with('success', 'คำคัดค้านของคุณถูกส่งเรียบร้อยแล้ว'); //ส่งแจ้งรายงานสำเร็จ และแจ้งเตือน
        
    }
}