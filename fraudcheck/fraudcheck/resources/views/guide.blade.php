<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            /* ใช้ ฟอนต์ Prompt (จาก Google Fonts)ถ้าฟอนต์นี้ไม่มี ระบบจะใช้ฟอนต์สำรองเป็น sans-serif*/
            font-family: 'Prompt', sans-serif;
            background-color: #f8f9fa; /*พื้นหลังสีขาว*/
           
        }

        .container {
            /*กรอบสีฟ้านำคลาส .container มาใส่ขนาดความกว้าง 800px*/
            max-width: 800px;
        }

        .hero { /*กรอบสีฟ้านำคลาส hero มาใส่สี*/
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white; /*หัวข้อสีขาว*/
            padding: 4rem 0; /*ระยะห่างภายใน*/
            border-radius: 15px; /*มุม*/
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); /*เงากล่อง*/
        }

        .hero h1 {
            /*ขนาดฟ้อน "คำแนะนำผู้ใช้งาน"*/
            font-weight: 600; /*ความหนาตัวอักษร*/
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
        }

        .btn-custom {
            background-color: #ffc107;
            color: #333;
            border: none;
        }
        .btn-back {
            background-color: #dc3545;
            color: #ffffff;
            border: none;
        }
    </style>
    <title>คำแนะนำผู้ใช้งาน</title>
</head>

<!--คำแนะนำผู้เริ่มต้นใช้แอป-->

<body>
    <div class="container my-5">
        <div class="hero text-center">
            <h1 class="mb-5">คำแนะนำผู้ใช้งาน</h1>
            <div class="d-grid gap-3 col-lg-6 mx-auto"> <!--จัดปุ่มให้สวยงาม-->
                <a href="/guideregister" button type="button" class="btn btn-custom btn-lg" >สมัครสมาชิก</a>
                <a href="/guidesearch" button type="button" class="btn btn-custom btn-lg" >การค้นหา</a>
                <a href="/guidereport" button type="button" class="btn btn-custom btn-lg" >การเพิ่มรายงาน</a>
                <a href="/guideprotest" button type="button" class="btn btn-custom btn-lg" >การแจ้งคำร้อง</a>
                
                <a href="/" type="button" class="btn btn-back btn-lg" >ย้อนกลับ</button></a>
    
                </div>
        </div>
    </div>
    </div>
    <script>
        // เช็คการหลุดของเน็ต
        function checkOffline() {
            // ถ้าเครื่องผู้ใช้ไม่ได้เชื่อมต่ออินเทอร์เน็ต
            if (!navigator.onLine) {
                alert('คุณออฟไลน์อยู่ กรุณาตรวจสอบการเชื่อมต่ออินเทอร์เน็ต');
                //เปลี่ยนหน้าเว็บไปยัง /offline
                window.location.href = "/offline";
            }
        }

        window.addEventListener('load', checkOffline);
        window.addEventListener('offline', checkOffline);
    </script>
</body>

</html>
