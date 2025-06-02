<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Blacklist;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;
class ReportController extends Controller
{
    //ระบบค้นหา
    public function search(Request $request)  //รับ request
    {
       // เซ็นเซอร์ข้อมูลเปิด 3 ตัวหลัง 0834554179 -> ●●●●●●179
       $censorField = function($value) { //รับค่าข้อมูลที่ต้องการเซนเซอร์
        if (empty($value)) return ''; //ถ้าไม่มีข้อมูลกรอกเข้ามา แสดงค่าว่าง

        $length = mb_strlen($value, 'UTF-8'); //นับตัวอักษร(เป็นภาษาไทยและไบต์)

            //ถ้าไม่ตรงตามเงื่อนไขบน
            //สร้าง ●(ตามตัวอักษรทั้งหมด-3) .(ต่อด้วย) , ดึงตัวอักษร 3 ตัวสุดท้าย
            return str_repeat('●', $length - 4) . mb_substr($value, -4, null, 'UTF-8'); //pumiput = ●●●●put
        
    };
    //เซ็นเซอร์ข้อมูลเฉพาะตรงกลาง pumiput -> pu●●●ut
    $NamecensorField = function($value) {
        if (empty($value)) return '';

        $length = mb_strlen($value, 'UTF-8');
        //เซนเซอร์น้อยกว่าเท่ากับ 4 ตัวอักษร
        if ($length === 1) { // ถ้า 1 ตัว ไม่ต้องเซนเซอร์
            return $value; 
        } elseif ($length === 2) { //ถ้า 2 ตัว เช่น ใจ -> ใ●
            $start = mb_substr($value, 0, 1, 'UTF-8'); 
            return $start . '●'; 
        } elseif ($length === 3) { //ถ้า 3 ตัว เช่น สวย -> ส●ย
            $start = mb_substr($value, 0, 1, 'UTF-8');
            $end = mb_substr($value, -1, 1, 'UTF-8'); //เปิด 1 ตัวท้าย
            return $start . '●' . $end;
        } elseif ($length === 4) { //ถ้า 4 ตัว เช่น สมใจ -> ส●●จ
            $start = mb_substr($value, 0, 1, 'UTF-8');
            $end = mb_substr($value, -1, 1, 'UTF-8');
            return $start . '●●' . $end;
        } elseif ($length === 5) { //ถ้า 5 ตัว เช่น สมศรี -> ส●●รี
            $start = mb_substr($value, 0, 1, 'UTF-8');
            $end = mb_substr($value, -2, null, 'UTF-8'); // เปิด 2 ตัวท้าย
            return $start . '●●' . $end;
        } else //มากกว่า 5 ขึ้นไป
         {
            $start = mb_substr($value, 0, 2, 'UTF-8');
            $end = mb_substr($value, -2, null, 'UTF-8');
            $blurLength = $length - 4; //ส่วนกลาง 
            return $start . str_repeat('●', $blurLength) . $end;
        }
    };

    //ข้อมูลจากผู้ใช้งานป้อนเข้ามาจากช่องที่ระบุ (รับข้อมูลจากหน้า view)
    $name = $request->input('name'); //ชื่อ
    $surname = $request->input('surname'); //นามสกุล
    $id = $request->input('idcard'); //บัตรประชาชน
    $phone = $request->input('telephone'); //พร้อมเพลย์
    $bank = $request->input('bankType'); //ธนาคาร
    $accountNumber = $request->input('bankAccount'); //เลขธนาคาร
    
    // ดึงข้อมูลที่มีสถานะ approve จากคอลัมธ์ status โมเดล Blacklist 
    $query = Blacklist::where('status', 'Approve'); 
 
     
        //LIKE(คำสั่งค้นหาในSQL) , %(ตัวอักษรที่เหลือ) เช่น มิพั = %ภู|มิพั|ฒน์%
        if ($name) {
            $query->where('name', 'LIKE', "%$name%"); //ค้นหาชื่อ (ไม่จำเป็นต้องพิมพ์ทุกตัวอักษร)
        }
        if ($surname) {
            $query->where('surname', 'LIKE', "%$surname%"); //ค้นหานามสกุล (ไม่จำเป็นต้องพิมพ์ทุกตัวอักษร)
        }
        if ($id) {
            $query->where('idcard', $id); //ค้นหาเลขบัตรประชาชน (พิมพ์ทุกตัว)
        }
        if ($phone) {
            $query->where('telephone', $phone); //ค้นหาพร้อมเพลย์
        }
        if ($bank) {
            $query->where('bankType', $bank); //ค้นหาธนาคาร (พิมพ์ทุกตัว)
        }
        if ($accountNumber) {
            $query->where('bankAccount', $accountNumber); //ค้นหาเลขธนาคาร (พิมพ์ทุกตัว)
        }
    
    
    $reports = $query->get(); // เก็บผลลัพธ์ เก็บใน $reports
    
    // เซนเซอร์การค้นหา
    //'phone' คอลัมธ์ฐานข้อมูล , $phone ตัวแปรที่เก็บ request
    $searchParams = [
        'name' => $NamecensorField($name), //ชื่อ
        'surname' => $NamecensorField($surname), //นามสกุล
        'id' => $censorField($id), //บัตรประชาชน
        'phone' => $censorField($phone), //พร้อมเพลย์
        'bank' => $bank,  // ชนิดธนาคาร(ไม่เซนเซอร์)
        'accountNumber' => $censorField($accountNumber) //เลขธนาคาร
    ];

    //เซนเซอร์ผลลัพธ์
    //ถ้า $reports ไม่ว่างเปล่าให้ทำใน if
    if ($reports->isNotEmpty()) { 
        $found = true; //พบข้อมูล
        $reportData = $reports->map(function($report) use ($censorField , $NamecensorField) { //ประกาศเพื่อใช้ฟังก์ชันนอกฟิลด์มาเซนเซอร์ได้
            return [
             
                'name' => $NamecensorField($report->name), //เซนเซอร์ชื่อ
                'surname' => $NamecensorField($report->surname), //เซนเซอร์นามสกุล
                'telephone' => $censorField($report->telephone), //เซนเซอร์เบอร์
                'idcard' => $censorField($report->idcard), //เซนเซอร์บัตรประชาชน
                'bankType' => $report->bankType, //ชนิดธนาคาร
                'bankAccount' => $censorField($report->bankAccount), //เซนเซอร์เลขธนาคาร
                'amount' => $report->amount, //ราคาสินค้า
                'productName' => $report->productName, //ชื่อสินค้า
                'number' => $report->id, //เลขรายงาน
                'product_images' => is_string($report->product_images), //ชื่อไฟล์รูปภาพสินค้า
                'conversation_images' => is_string($report->conversation_images), //ชื่อไฟล์รูปภาพหลักฐาน
                'payment_proof_images' => is_string($report->payment_proof_images), //ไม่ได้ใช้
                'additional_notes' => $report->additional_notes, //ไม่ได้ใช้(คอมเม้น)
                'payment_date' => $report->payment_date, //วันโอน
                'communication_platform' => $report->communication_platform, //แพลตฟอร์มการโอน
                'user_id' => $report->user_id, //ผู้ลงรายงาน
            ];
        });
        //แสดงผลลัพธ์หน้า results ,ส่งตัวแปรไปทำงานที่ view [found(พบรายงาน) , reports(ผลลัพธ์ที่ถูกเซนเซอร์แล้ว) , 'search'(คำค้นหาที่เซนเซอร์) ]
        return view('results', ['found' => $found, 'reports' => $reportData, 'search' => $searchParams]);
    }
     else {
        $found = false; //ไม่พบข้อมูล

        //แสดงผลลัพธ์หน้า results ,ส่งตัวแปรไปทำงานที่ view [found(ไม่พบรายงาน),search(คำค้นหาที่เซนเซอร์)]
        return view('results', ['found' => $found, 'search' => $searchParams]);
      }

    }
    //บันทึกรายงานฉ้อโกง
    public function store(Request $request) //รับ request
    {
        try {
            //Log บันทึกข้อมูลการทำงานเก็บใน log ของ laravel(ใช้ตรวจสอบข้อมูลย้อนหลังเช็คได้ที่ storage->Log->Laravel log )
            Log::info('Starting store function', ['user_id' => Auth::id()]); //บันทึกชื่อผู้ลงรายงานใน Log
    
            $validatedData = $request->validate([ //นำ request มาตรวจสอบ
                'name' => 'required|string',
                'surname' => 'required|string',
                'idcard' => 'nullable|string',
                'bankAccount' => 'nullable|string',
                'bankType' => 'nullable|string',
                'amount' => 'required|integer',
                'productName' => 'nullable|string',
                'telephone' => 'nullable|string',
                'additional_notes' => 'nullable|string',
                'product_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,heic,heif|max:5120',
                'conversation_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,heic,heif|max:5120',
                'payment_proof_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,heic,heif|max:5120',
                'payment_date' => 'nullable|date',
                'communication_platform' => 'nullable|string',
            ]);
    
            Log::info('Data validated successfully', ['validated_data' => $validatedData]);//บันทึกข้อมูลถูกต้องใน Log
    
            $report = new Blacklist($validatedData); //สร้าง object ข้อมูลที่ตรวจสอบแล้วเก็บใน Blacklist (ex. name,surname ....)
            $report->status = 'pending';//คอลัมธ์ status จะเป็น pending
            $report->user_id = Auth::id(); //คอลัมธ์ user_id จะเป็น id ผู้ใช้
    
            $imageCategories = ['product_images', 'conversation_images', 'payment_proof_images'];//เก็บ array รูปภาพ
            foreach ($imageCategories as $category) {//นำรูปภาพมาวนลูป (category เป็นตัวแปรพักในการวนลูป)
                if ($request->hasFile($category)) { //เช็คว่ามีการอัพโหลดไฟล์เข้ามาไหม
                    $urls = [];//ไว้เก็บ url เป็นค่าว่าง

                    //index(ตำแหน่งภาพ) , image(ภาพที่ 1,2,3)
                    foreach ($request->file($category) as $index => $image) { //ดึงไฟล์ที่อัพโหลดมาวนลูป(index ที่ 0 จะวน image ภาพที่ 1)
                        try {
                            //เก็บ image(ภาพ) ที่ไฟล์ public -> images เก็บไว้ที่ตัวแปร $path
                            $path = $image->store('images', 'public'); 

                            //นำpath มาเก็บเป็น $urls เพื่อใช้งาน
                            $urls[] = Storage::url($path); 
                            Log::info("Image uploaded successfully", [ //แจ้งเตือนอัพโหลดภาพสำเร็จใน Log
                                'category' => $category,
                                'index' => $index,
                                'path' => $path
                            ]);
                        } catch (Exception $e) { //แจ้งเตือนอัพโหลดภาพล้มเหลว ใน Log
                            Log::error("Failed to upload image", [
                                'category' => $category,
                                'index' => $index,
                                'error' => $e->getMessage()
                            ]);
                        }
                    }
                    $report->$category = $urls; //นำ $urls มาเก็บในคอลัมธ์ database
                } else {
                    //แจ้งเตือนไม่มีรูปภาพอัพโหลดใน Log
                    Log::info("No images uploaded for category", ['category' => $category]);
                }
            }
    
            $report->save(); //บันทึกข้อมูลตาราง
            Log::info('Report saved successfully', ['report_id' => $report->id]); //แจ้งเตือนบันทึกสำเร็จใน Log
            return redirect('/profile')->with('success', 'สำเร็จ');

        } catch (ValidationException $e) { //รายงานไม่ผ่านการตรวจสอบ
            Log::error('Validation failed', [ //แจ้งเตือนใน laravel.log
                'errors' => $e->errors(),
                'user_id' => Auth::id()
            ]);
            return redirect()->back()->withErrors($e->errors())->withInput();//ส่งกลับไปฟอร์มเดิม ,ส่งแจ้งเตือน error และ คงข้อมูลเดิมไว้ที่เคยกรอก(withInput();)
        } catch (Exception $e) { //ดักจับข้อมูลผิดพลาดอื่นๆ เช่น server database ...
            Log::error('Unexpected error occurred', [ //แจ้งเตือนใน laravel.log
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id()
            ]);
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาดที่ไม่คาดคิด กรุณาลองใหม่อีกครั้ง');//ส่งกลับไปฟอร์มเดิม และแสดงข้อความ
        }
    }

    public function reportList() //นำรายงานแสดงแก่ admin
    {   //orderby = เรียงลำดับ , created_at = วันเวลา , desc = ปัจจุบันก่อน อดีตหลัง
        $reports = Blacklist::orderBy('created_at', 'desc')->get(); //ดึงข้อมูลจากตารางฉ้อโกง(เรียงจากวันปัจจุบันขึ้นก่อน) เก็บใน $reports 
        return view('reportlist', compact('reports')); //ไปยังพาธ reportlist เพื่อนำรายงานฉ้อโกงแสดงแก่ admin
    }

    public function update(Request $request, $id)
    {   
        $report = Blacklist::findOrFail($id); //ค้นหา id ในตาราง blacklist(ถ้าไม่มีจะขึ้น 404notfound)
        $validatedData = $request->validate([ //ตรวจสอบความถูกต้อง status
            'status' => 'required|in:pending,approve,rejected', //ต้องเป็นค่า 3 อย่างนี้
        ]);
        $report->status = $validatedData['status']; //นำ 'status'เข้าตรวจสอบ Validate ('status' คือ ค่าจาก fetch)
        $report->save(); //บันทึก
        return response()->json(['success' => true]); //แจ้งเตือนหน้าเว็บ เปลี่ยน status สำเร็จ
    }

    public function userReports() //แสดงตารางหน้าเพิ่มรายงานฉ้อโกง
    {
        $user = Auth::user(); //ดึงข้อมูลที่ล็อคอินปัจจุบัน
        $reports = Blacklist::where('user_id', $user->id)->orderBy('created_at', 'desc')->get(); // ดึงรายงานที่มี user_id(คอลัมธ์ฐานข้อมูล) ตรงกับ ID ของผู้ใช้งานที่ล็อกอิน
        return view('user_reports', compact('reports')); //ส่ง reports ไปทำงานที่ View
    }

    public function destroy($id) //แจ้งลบรายงาน
    {
        try {
            $report = Blacklist::findOrFail($id); //ค้นหาเลขรายงาน
            $report->delete();
    
            return response()->json([ //ส่งไปทำงาน จาวาสคริป
                'success' => true,
                'message' => 'Delete success' 
            ]);
        } catch (Exception $e) {
            return response()->json([ //ส่งไปทำงาน จาวาสคริป
                'success' => false,
                'message' => 'Delete failed' 
            ], 500);
        }
    }
    

    
}
