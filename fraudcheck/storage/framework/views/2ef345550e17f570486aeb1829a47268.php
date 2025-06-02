<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Reports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Prompt', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        .container {
            max-width: 1500px;
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

        .image-thumbnail {
            width: 50px;
            height: 50px;
            object-fit: cover;
            cursor: pointer;
            margin: 2px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .image-thumbnail:hover {
            transform: scale(1.1);
        }

        .modal-image {
            max-width: 100%;
            max-height: 80vh;
            border-radius: 10px;
        }

        .table {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        .status-legend {
            display: flex;
            gap: 2rem;
            padding: 1rem;
            margin-bottom: 1rem;
            background: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .status-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .status-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
        }

        .status-dot.pending {
            background-color: #ffc107;
        }

        .status-dot.approved {
            background-color: #198754;
        }

        .status-dot.rejected {
            background-color: #dc3545;
        }

        .status-text {
            font-size: 0.9rem;
        }

        .status-text.pending {
            color: #ffc107;
        }

        .status-text.approved {
            color: #198754;
        }

        .status-text.rejected {
            color: #dc3545;
        }
    </style>
</head>

<body>
    <?php
        //เซนเซอร์ข้อมูล เปิด 3 ตัวท้าย
        function censorField($value)
        {
            if (empty($value)) {
                return '';
            } //ถ้าไม่มีข้อมูล ให้แสดงค่าว่าง
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
        <div class="hero text-center">
            <h1>รายงานของคุณ</h1>
        </div>
        <div class="mb-4 text-center">
            <a href="/newreport" class="btn btn-custom btn-main">+ เพิ่มรายงานใหม่</a> <!--ไปหน้าเพิ่มรายงาน-->
        </div>
        <!-- แถบแจ้งเตือนสถานะ -->
        <div class="status-legend">
            <div class="status-item">
                <span class="status-dot pending"></span> <!--วงกลมสีเหลือง-->
                <span class="status-text pending">Pending - รอการตรวจสอบ</span>
            </div>
            <div class="status-item">
                <span class="status-dot approved"></span> <!--วงกลมสีเขียว-->
                <span class="status-text approved">Approved - อนุมัติแล้ว</span>
            </div>
            <div class="status-item">
                <span class="status-dot rejected"></span> <!--วงกลมสีแดง-->
                <span class="status-text rejected">Rejected - ปฏิเสธ (กรณีไม่ทำตามคำแนะนำ เช่น ไม่เซนเซอร์ตัวอักษรตามคำแนะนำ ไม่ลงภาพหลักฐานการซื้อขาย ไม่ลงภาพบันทึกประจำวัน)</span>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <!--สามารถเลื่อนตารางได้-->
                <div class="table-responsive"> 
                    <table class="table table-hover">
                        <thead>
                            <tr> <!--หัวข้อตาราง-->
                                <th>หมายเลขรายงาน</th>
                                <th>ชื่อ</th>
                                <th>นามสกุล</th>
                                <th>เลขบัตรประชาชน</th>
                                <th>พร้อมเพย์/ทรูวอลเล็ท</th>
                                <th>เลขบัญชีธนาคาร</th>
                                <th>ธนาคาร</th>
                                <th>วันที่</th>
                                <th>จำนวนเงิน</th>
                                <th>ชื่อสินค้า</th>
                                <th>รูปภาพ</th>
                                <th>สถานะ</th>
                                <th>การดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <!--แสดงรายงานแต่ละไฟล์-->
                                <tr>
                                    <td><?php echo e($report->id); ?></td>
                                    <td><?php echo e(NamecensorField($report->name)); ?></td>
                                    <td><?php echo e(NamecensorField($report->surname)); ?></td>
                                    <td><?php echo e(censorField($report->idcard)); ?></td>
                                    <td><?php echo e(censorField($report->telephone)); ?></td>
                                    <td><?php echo e(censorField($report->bankAccount)); ?></td>
                                    <td><?php echo e($report->bankType); ?></td>
                                    <td><?php echo e($report->date); ?></td>
                                    <td><?php echo e($report->amount); ?></td>
                                    <td><?php echo e($report->productName); ?></td>

                                    <td>
                                        <div class="d-flex flex-wrap">
                                            <!--วนภาพทั้งหมด 3 คอลัมธ์-->
                                            <?php $__currentLoopData = ['product_images', 'conversation_images', 'payment_proof_images']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imageType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <!--เช็คว่าภาพว่างไหม? ไม่ว่างทำต่อ-->
                                            <?php if(!empty($report->$imageType)): ?>
                                                    <!--วนภาพในคอลัมน์-->
                                                    <?php $__currentLoopData = $report->$imageType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <!--แสดงภาพขนาดเล็ก, ตั้งจุดขยายใหญ่ภาพ(ให้จาวาสคริปใช้)-->
                                                        <img src="<?php echo e($image); ?>" class="image-thumbnail"
                                                            data-bs-toggle="modal" data-bs-target="#imageModal"
                                                            data-image-src="<?php echo e($image); ?>"
                                                            alt="<?php echo e($imageType); ?> <?php echo e($index + 1); ?>"
                                                            title="<?php echo e(ucfirst(str_replace('_', ' ', $imageType))); ?>">
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </td>
                                    <td>
                                        <!--แสดงสถานะ-->
                                        <span
                                            class="badge bg-<?php echo e($report->status == 'approve' ? 'success' : ($report->status == 'rejected' ? 'danger' : 'warning')); ?>">
                                            <?php echo e($report->status); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <!--ปุ่มแจ้งลบรายงาน-->
                                        <a href="/protest/<?php echo e($report->id); ?>" 
                                            class="btn btn-warning btn-sm btn-custom">แจ้งลบรายงาน</a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="/profile" class="btn btn-custom btn-secondary-custom">กลับไปหน้าโปรไฟล์</a>
        </div>
    </div>

    <!-- สร้างกรอบขยายภาพ -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img src="" class="modal-image" alt="Full size image">
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>

        //่่javascript นำกรอบมาขยายใหญ่ภาพ
        document.addEventListener('DOMContentLoaded', function() {
            var imageModal = document.getElementById('imageModal');
            imageModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var imageUrl = button.getAttribute('data-image-src');
                var modalImage = imageModal.querySelector('.modal-image');
                modalImage.src = imageUrl;
            });
        });
    </script>
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
<?php /**PATH C:\xampp\htdocs\fraudcheck\fraudcheck\resources\views/user_reports.blade.php ENDPATH**/ ?>