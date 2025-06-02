<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Prompt', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }
        .container {
            max-width: 800px;
        }
        .card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 2rem;
        }
        .card-body {
            padding: 2rem;
        }
        .card-title {
            font-weight: 600;
            margin-bottom: 1rem;
        }
        .hero {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            padding: 4rem 0;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }
        .hero h1 {
            font-weight: 600;
            font-size: 3rem;
            margin-bottom: 1.5rem;
        }
        .btn-custom {
            border-radius: 30px;
            padding: 0.8rem 2rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 14px rgba(0, 0, 0, 0.1);
        }
        .btn-main {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            border: none;
        }
        .btn-main:hover {
            background: linear-gradient(135deg, #5a0fa8 0%, #1e63d6 100%);
            color: white;
        }
        .btn-secondary-custom {
            background-color: #f8f9fa;
            color: #333;
            border: 1px solid #dee2e6;
        }
        .btn-secondary-custom:hover {
            background-color: #e9ecef;
            color: #333;
        }
        .img-fluid {
            border-radius: 10px;
        }
    </style>
</head>
<body>

<div class="container my-5">
    <div class="hero text-center">
        <h1>ผลการค้นหา</h1>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">ข้อมูลที่ใช้ค้นหา:</h5>
            <!--ผลลัพธ์การค้นหา (ตัวแปร $search ได้จาก compact ใน controller)-->
            @if ($search['name'])
                <p class="card-text"><strong>ชื่อ:</strong> {{ $search['name'] }}</p>
            @endif
            @if ($search['surname'])
                <p class="card-text"><strong>นามสกุล:</strong> {{ $search['surname'] }}</p>
            @endif
            @if ($search['phone'])
                <p class="card-text"><strong>Promtpay,Truemoney:</strong> {{ $search['phone'] }}</p>
            @endif
            @if ($search['id'])
                <p class="card-text"><strong>เลขบัตรประชาชน:</strong> {{ $search['id'] }}</p>
            @endif
            @if ($search['bank'])
                <p class="card-text"><strong>ธนาคาร:</strong> {{ $search['bank'] }}</p>
            @endif
            @if ($search['accountNumber'])
                <p class="card-text"><strong>เลขบัญชี:</strong> {{ $search['accountNumber'] }}</p>
            @endif
        </div>
    </div>

    <!--ถ้า found(เจอข้อมูล) = True-->
    @if ($found)
                                    <!--นับรายงานที่ approve-->
        <h2 class="mb-4">ผลการค้นหา ({{ $reports->count() }} รายการ):</h2>
        @foreach ($reports as $report)
            <div class="card mb-4">
                <div class="card-body">
                                        <!--'number' ใช้กับฟังก์ชัน map ใน controller-->
                    <h5 class="card-title">รายการที่ {{ $report['number'] }}</h5>
                    <p class="card-text"><strong>ชื่อ:</strong> {{ $report['name'] }}</p>
                    <p class="card-text"><strong>นามสกุล:</strong> {{ $report['surname'] }}</p>
                    <p class="card-text"><strong>เลขบัตรประชาชน:</strong> {{ $report['idcard'] }}</p>
                    <p class="card-text"><strong>Promtpay,Truemoney:</strong> {{ $report['telephone'] }}</p>
                    <p class="card-text"><strong>ธนาคาร:</strong> {{ $report['bankType'] }}</p>
                    <p class="card-text"><strong>เลขบัญชี:</strong> {{ $report['bankAccount'] }}</p>
                    <p class="card-text"><strong>จำนวนเงิน:</strong> {{ $report['amount'] }} บาท</p>
                    <p class="card-text"><strong>สินค้าที่ขาย:</strong> {{ $report['productName'] }}</p>
                    <p class="card-text"><strong>วันที่โอนเงิน:</strong> {{ $report['payment_date'] }}</p>
                    <p class="card-text"><strong>หมายเลขรายงาน:</strong> {{ $report['number'] }}</p>
                    <p class="card-text"><strong>หมายเลขผู้ลงรายงาน:</strong> {{ $report['user_id'] }}</p>

                   

                    <div class="mt-4">
                        <a href="{{ route('moreinfo', ['id' => $report['number']]) }}" class="btn btn-custom btn-main me-2">ดูรายละเอียดเพิ่มเติม</a>
                        
                        <!--ถ้ามีการล็อคอินให้ขึ้น "แจ้งลบรายงาน"-->
                        @auth
                            <a href="{{ route('protest.form', ['id' => $report['number']]) }}" class="btn btn-custom btn-danger">แจ้งลบรายงาน</a>
                        @endauth
                    </div>
                </div>
            </div>
        @endforeach

    @else <!--ถ้า found(ไม่เจอข้อมูล) = False-->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">ผลการค้นหา:</h5>
                <p class="card-text">ไม่พบประวัติฉ้อโกง</p>
            </div>
        </div>
    @endif

    <div class="text-center mt-4">
        <a href="{{ route('search') }}" class="btn btn-custom btn-secondary-custom">กลับไปหน้าค้นหา</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
