<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายละเอียดเพิ่มเติม</title>
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
        }
        .card-body {
            padding: 2rem;
        }
        .table {
            background-color: white;
            border-radius: 15px;
            overflow: hidden;
        }
        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
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
        .btn-primary {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a0fa8 0%, #1e63d6 100%);
        }
        .text-muted-link {
            color: #6c757d;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .text-muted-link:hover {
            color: #5a6268;
            text-decoration: none;
        }
        .image-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
        }
        .image-gallery img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        .image-gallery img:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <?php //เรียกใช้ฟังก์ชันเซนเซอร์ในหน้า view
        function censorField($value) {
            if (empty($value)) return ''; //ถ้าไม่มีข้อมูล ให้แสดงค่าว่าง
        $length = mb_strlen($value, 'UTF-8'); //นำข้อมูลมานับตัวอักษร(เป็นภาษาไทย) , mb = ไบต์เก็บข้อมูลภาษาไทย(UTF-8)

            return str_repeat('●', $length - 4) . mb_substr($value, -4, null, 'UTF-8');
        
        }
        //เซนเซอร์ชื่อ, นามสกุล (เปิด 2ตัวหน้า, 2ตัวหลัง)
        function NamecensorField($value)
        {
            if (empty($value)) {
                 return '';
            }

            $length = mb_strlen($value, 'UTF-8');

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
            }
                else { //มากกว่า 5 ขึ้นไป pumiput -> pu●●●ut
                    $prefix = mb_substr($value, 0, 2, 'UTF-8'); // 2 ตัวหน้า
                    $suffix = mb_substr($value, -2, 2, 'UTF-8'); // 2 ตัวท้าย
                    $censoredLength = $length - 4; // จำนวน ● ที่เซนเซอร์
                    return $prefix . str_repeat('●', $censoredLength) . $suffix; //นำมาต่อกัน ( pu●●●ut )
            }
        }

    ?>

    <div class="container my-5">
        <h1 class="text-center mb-4">รายละเอียดเพิ่มเติม</h1>
        <div class="card mb-4">
            <div class="card-body">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th scope="row">หมายเลขผู้เพิ่มรายงาน :</th>
                            <td><?php echo e($report->user_id); ?></td> <!--หมายเลขผู้เพิ่ม-->
                        </tr>
                        <tr>
                            <th scope="row">หมายเลขรายงาน :</th>
                            <td><?php echo e($report->id); ?></td> <!--หมายเลขรายงาน-->
                        </tr>
                        <tr>
                            <th scope="row">ชื่อ :</th> 
                            <td><?php echo e(NamecensorField($report->name)); ?></td> <!--เซนเซอร์ชื่อ-->
                        </tr>
                        <tr>
                            <th scope="row">นามสกุล :</th>
                            <td><?php echo e(NamecensorField($report->surname)); ?></td> <!--เซนเซอร์นามสกุล-->
                        </tr> 
                        <tr>
                            <th scope="row">เลขบัตรประชาชน :</th>
                            <td><?php echo e(censorField($report->idcard)); ?></td> <!--เซนเซอร์เลขบัตรประชาชน-->
                        </tr>
                        <tr>
                            <th scope="row">Promtpay,Truemoney :</th>
                            <td><?php echo e(censorField($report->telephone)); ?></td> <!--เซนเซอร์พร้อมเพลย์-->
                        </tr>
                        <tr>
                            <th scope="row">ธนาคาร :</th>
                            <td><?php echo e($report->bankType ?? '-'); ?></td> <!--ดึงชนิดธนาคาร ถ้าไม่มีให้เป็นค่าว่าง-->
                        </tr>
                        <tr>
                            <th scope="row">เลขบัญชี :</th>
                            <td><?php echo e(censorField($report->bankAccount)); ?></td> <!--เซนเซอร์เลขธนาคาร-->
                        </tr>
                        <tr>
                            <th scope="row">จำนวนเงิน :</th>
                            <td><?php echo e($report->amount); ?></td> <!--จำนวนเงิน-->
                        </tr>
                        <tr>
                            <th scope="row">สินค้า :</th>
                            <td><?php echo e($report->productName); ?></td> <!--สินค้า-->
                        </tr>
                        <tr>
                            <th scope="row">แอปพลิเคชัน :</th>
                            <td><?php echo e($report->communication_platform); ?></td> <!--แพลตฟอร์มที่โอน-->
                        </tr>
                        <tr>
                            <th scope="row">วันโอนเงิน :</th>
                            <td><?php echo e($report->payment_date->format('d-m-Y')); ?></td> <!--วันโอนเงิน-->
                        </tr>
                        <tr>
                            <th scope="row">วันตั้งโพส :</th>
                            <td><?php echo e($report->created_at->format('d-m-Y')); ?></td> <!--วันเริ่มสร้างรายงาน-->
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <?php if(!empty($report->product_images)): ?> <!--ตรวจสอบว่าภาพไม่ว่างเปล่า ให้ทำเงื่อนไขข้างใน-->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">ภาพสินค้า :</h5>
                <div class="image-gallery">
                    <?php $__currentLoopData = $report->product_images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <!--วนลูปภาพ-->
                        <img src="<?php echo e($image); ?>" alt="ภาพสินค้า" class="img-fluid"> <!--แสดงภาพสินค้าที่เก็บอยู่ในคอลัมธ์ product_image-->
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        
            <!--จัดตำแหน่งปุ่มให้สวยงาม-->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <!--ย้อนกลับ ยังคงหน้ารายงานข้อมูลไว้-->
            <a href="javascript:history.back()" class="text-muted-link">< ย้อนกลับ</a>
            <a href="/" class="btn btn-custom btn-primary">หน้าหลัก</a>
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
</html><?php /**PATH C:\xampp\htdocs\fraudcheck\resources\views/moreinfo.blade.php ENDPATH**/ ?>