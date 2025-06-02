<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>คำแนะนำการค้นหา</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            /* ใช้ฟอนต์ Prompt จาก Google Fonts; หากไม่มีฟอนต์นี้ ระบบจะใช้ฟอนต์สำรองเป็น sans-serif */
            font-family: 'Prompt', sans-serif;
            background-color: #f8f9fa;
            /* กำหนดพื้นหลังสีขาว */
            color: #333;
            /* กำหนดสีตัวหนังสือเป็นสีดำ */
        }

        .container {
            /* กำหนดความกว้างสูงสุดของคอนเทนเนอร์เป็น 800px */
            max-width: 800px;

        }

        .hero {
            /* กำหนดพื้นหลังด้วยการไล่สีแบบ linear-gradient */
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            /* กำหนดสีตัวหนังสือเป็นสีขาว */
            padding: 4rem 0;
            /* กำหนดระยะห่างด้านใน */
            border-radius: 15px;
            /* กำหนดมุมโค้ง */
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            /* กำหนดเงา */
        }

        .No1 {
            font-size: 25px;
            /* กำหนดขนาดฟอนต์ตามที่ต้องการ */
            margin-left: 30px;
            /* ขยับเลข "1." ออกจากกรอบสี่เหลี่ยม */
        }

        .register {
            display: flex;
            justify-content: center;
            /* จัดตรงกลางแนวนอน */
            align-items: center;
            /* จัดตรงกลางแนวตั้ง (ถ้าสูงพอ) */
        }

        .register img {
            max-width: 100%;
            height: auto;
            border-radius: 15px;
            border: 3px solid white;
            box-sizing: border-box;
        }
      

        .btn-home {
            background-color: #898989;
            color: #ffffff;
            border: none;
        }
        .btn-back {
            background-color: #dc3545;
            color: #ffffff;
            border: none;
        }
        

    </style>
</head>

<body>
    <div class="container my-5">
        <div class="hero">
            <h1 class="mb-5 text-center">วิธีใช้ระบบค้นหา</h1>
            <h1 class="No1 mb-5 text-left">1. เข้าสู่หน้าเว็บไซต์หลัก</h1>
            <div class="register mb-5">
                <img src="https://i.ibb.co/4nCdrmX6/1.jpg" alt="ภาพแสดงขั้นตอนที่ 1">
            </div>
        </div>
    </div>

    <div class="container my-5">
        <div class="hero">
            <h2 class="No1 mb-5 text-left">2. เลือกที่ปุ่ม "ค้นหารายงาน"</h2>
            <div class="register">
                <img src="https://i.ibb.co/d0xGGyCH/2.jpg" alt="ภาพแสดงขั้นตอนที่ 2">
            </div>
        </div>
    </div>

    <div class="container my-5">
        <div class="hero">
            <h2 class="No1 mb-5 text-left">3. ผู้ใช้งานสามารถนำข้อมูลที่ต้องการค้นหามากรอกในช่องได้ ได้แก่ ชื่อ, นามสกุล, เลขบัตรประชาชน, Promtpay, ธนาคาร, เลขบัญชีธนาคาร (สามารถกรอก 1 ช่องเพื่อค้นหาได้)</h2>
            <div class="register">
                <img src="https://i.ibb.co/xt73M0n1/3.jpg" alt="ภาพแสดงขั้นตอนที่ 3">
            </div>
        </div>
    </div>

    <div class="container my-5">
        <div class="hero">
            <h2 class="No1 mb-5 text-left">4. เมื่อกรอกข้อมูลเสร็จสิ้นกดปุ่ม "ค้นหา"</h2>
            <div class="register">
                <img src="https://i.ibb.co/tPBmJkwC/4.jpg" alt="ภาพแสดงขั้นตอนที่ 4">
            </div>
        </div>
    </div>

    <div class="container my-5">
        <div class="hero">
            <h2 class="No1 mb-5 text-left">5. ระบบจะแสดงผลลัพธ์การค้นหาแก่ผู้ใช้งาน</h2>
            <div class="register">
                <img src="https://i.ibb.co/F9mdmQ4/5.jpg" alt="ภาพแสดงขั้นตอนที่ 5">
            </div>
        </div>
    </div>

    <div class="container my-5">
        <div class="hero">
            <h2 class="No1 mb-5 text-left">6. ผู้ใช้งานสามารถดูรายละเอียดเพิ่มเติมโดยกดปุ่ม "ดูรายละเอียดเพิ่มเติม"</h2>
            <div class="register">
                <img src="https://i.ibb.co/XfDGxz7C/6.jpg"  alt="ภาพแสดงขั้นตอนที่ 6">
            </div>
        </div>
    </div>

    <div class="container1 my-5">
        <div class="hero1 text-center">
            <div class="d-grid gap-3 col-lg-6 mx-auto">
            <div>
                <a href="/" type="button" class="btn btn-home btn-lg">หน้าหลัก</button></a>
                <a href="/guide" type="button" class="btn btn-back btn-lg">ย้อนกลับ</button></a>
            </div>
           
        </div>
        </div>
    </div>

    <script>
        // เช็คการหลุดของเน็ต
        function checkOffline() {
            if (!navigator.onLine) {
                alert('คุณออฟไลน์อยู่ กรุณาตรวจสอบการเชื่อมต่ออินเทอร์เน็ต');
                window.location.href = "/offline";
            }
        }

        window.addEventListener('load', checkOffline);
        window.addEventListener('offline', checkOffline);
    </script>
</body>

</html>

