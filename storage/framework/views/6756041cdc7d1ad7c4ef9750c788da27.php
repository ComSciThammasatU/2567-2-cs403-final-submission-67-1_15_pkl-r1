<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายการรายงาน</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <!--ใช้ไอคอน bootstrap-->
    <style>
        body {
            font-family: 'Prompt', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        .container {
            max-width: 1500px;
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

            color: #333;
        }

        .table th {
            background-color: #f1f3f5;
            font-weight: 600;
        }

        .image-thumbnail {
            width: 50px;
            height: 50px;
            object-fit: cover;
            cursor: pointer;
            margin: 2px;
            border-radius: 5px;
            transition: transform 0.3s ease;
        }

        .image-thumbnail:hover {
            transform: scale(1.1);
        }

        .modal-image {
            max-width: 100%;
            max-height: 80vh;
            border-radius: 10px;
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

        .form-check-input:checked {
            background-color: #6a11cb;
            border-color: #6a11cb;
        }

        .btn-delete {
            color: #dc3545;
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .btn-delete:hover {
            color: #bd2130;
        }

        btn-reject {
            color: #fff;
            background-color: #dc3545;
            border: none;
            border-radius: 20px;
            padding: 5px 15px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-reject:hover:not(.disabled) {
            background-color: #bd2130;
        }

        .btn-reject.disabled {
            background-color: #6c757d;
            cursor: not-allowed;
        }

        .status-controls {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
    </style>
</head>

<body>
    <!--ระบบเซนเซอร์-->
    <?php
        function censorField($value)  {
            //ถ้าไม่มีข้อมูล ให้แสดงค่าว่าง
            if (empty($value)) {
                return ''; 
             } 
            $length = mb_strlen($value, 'UTF-8'); 
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

    <div class="search-section mb-4">
        <div class="hero text-center">
            <h1>ดูการส่งรายงาน</h1> <!--หัวข้อ-->
        </div>

        <!--ฟอร์มค้นหาของ Admin-->
        <div class="row justify-content-center mb-4"> <!--จัดกึ่งกลาง-->
            <div class="col-md-3">
                <label for="searchReportId" class="form-label">หมายเลขรายงาน</label>
                <input type="text" class="form-control" id="searchReportId" placeholder="ค้นหาตามหมายเลขรายงาน">
            </div>
            <div class="col-md-3">
                <label for="searchUserId" class="form-label">หมายเลขผู้ลงรายงาน</label>
                <input type="text" class="form-control" id="searchUserId" placeholder="ค้นหาตามหมายเลขผู้ลงรายงาน">
            </div>
            <div class="col-md-3">
                <label for="searchStatus" class="form-label">สถานะของรายงาน</label>
                <select class="form-select" id="searchStatus">
                    <option value="">ทั้งหมด</option>
                    <option value="approve">อนุมัติแล้ว</option>
                    <option value="pending">รอดำเนินการ</option>
                    <option value="rejected">ปฏิเสธแล้ว</option>
                </select>
            </div>
        </div>

        <div class="row justify-content-center"> <!--จัดกึ่งกลาง-->
            <div class="col-md-3 text-center">
                <button class="btn btn-custom btn-primary w-100" onclick="resetSearch()">ล้างการค้นหา</button>
            </div>
        </div>

    </div>

    <div class="container my-5">
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">รายการรายงาน</h2> <!--ตาราง-->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr> <!--คอลัมธ์-->
                                <th>หมายเลขรายงาน</th>
                                <th>หมายเลขผู้ลงรายงาน</th>
                                <th>ชื่อ</th>
                                <th>นามสกุล</th>
                                <th>เลขบัตรประชาชน</th>
                                <th>พร้อมเพย์/ทรูวอลเล็ท</th>
                                <th>เลขบัญชี</th>
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
                                <!--ข้อมูลที่ถูกเซนเซอร์-->
                                <tr>
                                    <td><?php echo e($report->id); ?></td>
                                    <td><?php echo e($report->user_id); ?></td>
                                    <td><?php echo e(NamecensorField($report->name)); ?></td>
                                    <td><?php echo e(NamecensorField($report->surname)); ?></td>
                                    <td><?php echo e(censorField($report->idcard)); ?></td>
                                    <td><?php echo e(censorField($report->telephone)); ?></td>
                                    <td><?php echo e(censorField($report->bankAccount)); ?></td>
                                    <td><?php echo e($report->bankType); ?></td>
                                    <td><?php echo e($report->date); ?></td>
                                    <td><?php echo e($report->amount); ?></td>
                                    <td><?php echo e($report->productName); ?></td>

                                    <td> <!--วนลูป 3 คอลัมธ์-->
                                        <div class="d-flex flex-wrap">
                                            <?php $__currentLoopData = ['product_images', 'conversation_images', 'payment_proof_images']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imageType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <!--ถ้ามีรูปภาพ ทำเงื่อนไขล่าง-->
                                            <?php if(!empty($report->$imageType)): ?>
                                                <?php $__currentLoopData = $report->$imageType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                  <!-- กล่องควบคุมสถานะรายงานแต่ละรายการ (ใช้กับ JavaScript) -->
                                    <div class="status-controls" id="status-controls-<?php echo e($report->id); ?>">

                                        <!-- แสดง checkbox เฉพาะกรณีที่สถานะยังไม่ถูกปฏิเสธ -->
                                        <?php if($report->status !== 'rejected'): ?>

                                            <div class="form-check mb-2">

                                                <!-- Checkbox: ใช้ติ๊กอนุมัติรายงาน -->
                                                <input 
                                                    class="form-check-input status-checkbox" 
                                                    type="checkbox"
                                                    id="status-<?php echo e($report->id); ?>" 
                                                    data-report-id="<?php echo e($report->id); ?>" 
                                                    <?php echo e($report->status === 'approve' ? 'checked' : ''); ?> 
                                                >

                                                <!-- Label ที่แสดงข้อความสถานะ (รอดำเนินการ / อนุมัติแล้ว) -->
                                                <label class="form-check-label" for="status-<?php echo e($report->id); ?>">
                                                    <span class="status-text">
                                                        <?php echo e($report->status === 'approve' ? 'อนุมัติแล้ว' : 'รอดำเนินการ'); ?>

                                                    </span>
                                                </label>

                                            </div>

                                        <?php endif; ?>

                                    </div>

                                            
                                    <!--ปุ่มปฏิเสธ (จะส่ง reject สีแดง , รอบแรก $report->status ใช้ให้ปุ่มดูจาง รอบสองใช้ปิดปุ่มเมื่อกด)-->
                                    <button class="btn btn-reject <?php echo e($report->status === 'rejected' ? 'disabled' : ''); ?>

                                        "data-report-id="<?php echo e($report->id); ?>"
                                        <?php echo e($report->status === 'rejected' ? 'disabled' : ''); ?>><!-- ปิดปุ่มปฏิเสธ-->
                                            <i class="bi bi-x-circle"></i> ปฏิเสธ
                                    </button>
                                    <!--เพิ่มแจ้งเตือนเล็กๆ ให้ฟอร์มค้นหา DOM หาเจอ-->
                                        <?php if($report->status === 'rejected'): ?>
                                        <span class="status-text d-block mt-1 text-danger">ปฏิเสธแล้ว</span>
                                        <?php endif; ?>
                                        </div>
                                    </td>
                            
                                        <td>
                                            <!--ปุ่มลบรายงาน-->
                                            <button class="btn-delete" data-report-id="<?php echo e($report->id); ?>">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                            <div class="text-center mt-4">
                                <a href="/profile" class="btn btn-custom btn-primary">กลับสู่หน้าโปรไฟล์</a>
                            </div>
                            </div>

    <!-- สร้าง Modal ขยายภาพ -->
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
        // ขยายรูปภาพ
        document.addEventListener('DOMContentLoaded', function() {
            const imageModal = document.getElementById('imageModal');
            imageModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget; 
                const imageUrl = button.getAttribute('data-image-src'); //ดึงภาพ
                const modalImage = imageModal.querySelector('.modal-image'); //ดึงกล่องภาพ
                modalImage.src = imageUrl; //นำภาพใส่กล่องภาพ
            });

// ฟังก์ชันส่ง status ไปทำงาน controller
const updateReportStatus = (reportId, status, element) => {
    fetch(`/report/${reportId}`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json', // แนบข้อมูลเป็น JSON
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' // ป้องกัน CSRF
        },
        body: JSON.stringify({ status }) // ส่งข้อมูล status ไปยัง controller
    })
    .then(response => response.json()) // แปลง response เป็น JSON object
    .then(data => {
        // ถ้าสำเร็จและสถานะคือ rejected
        if (data.success && status === 'rejected') {
            const statusControls = element.closest('.status-controls'); // หา container ของ checkbox
            const checkbox = statusControls?.querySelector('.form-check'); // หา checkbox ภายใน
            if (checkbox) checkbox.remove(); // ลบ checkbox ออก
            element.classList.add('disabled'); // ปิดปุ่ม
            element.disabled = true;
        }
    })
    .catch(() => alert('เกิดข้อผิดพลาดในการอัปเดตสถานะ')); // แจ้งเตือนเมื่อเกิดข้อผิดพลาด
};

// อัปเดตสถานะเมื่อมีการเปลี่ยน checkbox
document.querySelectorAll('.status-checkbox').forEach(function(cb) { 
    cb.addEventListener('change', function () {
        const reportId = this.getAttribute('data-report-id'); // รับเลขรายงาน
        const status = this.checked ? 'approve' : 'pending'; //ตรวจสอบกล่อง
        const statusText = this.parentNode.querySelector('.status-text'); 
        statusText.textContent = this.checked ? 'อนุมัติแล้ว' : 'รอดำเนินการ'; //ตรวจสอบข้อความ
        updateReportStatus(reportId, status, this); // เรียกฟังก์ชันอัปเดตสถานะ
    });
});

// ปฏิเสธรายงาน (เมื่อกดปุ่ม)
document.querySelectorAll('.btn-reject').forEach(function(button) {
    button.addEventListener('click', function () {
        if (confirm('คุณแน่ใจหรือไม่ว่าต้องการปฏิเสธรายงานนี้?')) {
            const reportId = this.getAttribute('data-report-id'); //รับเลขรายงาน
            updateReportStatus(reportId, 'rejected', this); //  เรียกฟังก์ชันอัปเดตสถานะ
        }
    });
});

     // ฟังก์ชันค้นหา

            //รับค่าจากฟอร์ม
            const searchInputs = {
                reportID: document.getElementById('searchReportId'),
                userID: document.getElementById('searchUserId'),
                status: document.getElementById('searchStatus')
            };

            const statusMapping = {
                approve: 'อนุมัติแล้ว',
                pending: 'รอดำเนินการ',
                rejected: 'ปฏิเสธแล้ว'
            };

         
            //นำ searchInputs มาใช้ ( ประกอบด้วย reportID, userID, status )
            Object.values(searchInputs).forEach(input => {
                input.addEventListener('input', filterTable); //ทุกครั้งที่พิมพ์ค่าเข้ามา ให้เรียกใช้ filterTable()
            });
            //เรียกใช้ตัวแปร  searchInputs.status
            searchInputs.status.addEventListener('change', filterTable);

            //ฟังก์ชันค้นหาฟอร์ม
            function filterTable() {
                const rows = document.querySelectorAll('tbody tr'); //รับค่าข้อมูลที่แสดง

                // Admin กรอกฟอร์ม
                const search = { 
                    reportID: searchInputs.reportID.value.toLowerCase(),
                    userID: searchInputs.userID.value.toLowerCase(),
                    status: searchInputs.status.value
                };
                
                //แสดงข้อมูลค้นหาจากฟอร์ม (วนลูปข้อมูลแต่ละแถว)
                rows.forEach(row => { 
                    
                    //ประกาศตัวแปร
                    const id = row.children[0].textContent.toLowerCase(); //id
                    const userID = row.children[1].textContent.toLowerCase(); //เลขรายงาน 
                    const statusText = row.querySelector('.status-text')?.textContent.trim() || ''; //รับค่า อนุมัติ , รอการดำเนินการ(trim ลบช่องว่างหัวท้าย)

                    //ข้างในฟอร์ม status
                    const statusMatch =
                        search.status === '' || //เลือกฟอร์ม 'ทั้งหมด'
                        statusText === statusMapping[search.status]; //เลือกฟอร์ม 'อนุมัติแล้ว','รอดำเนินการ','ปฏิเสธแล้ว'

                    //นำค่าตัวแปร แมชกับ Admin กรอกฟอร์ม
                    const match =
                        id.includes(search.reportID) && //ตรวจสอบ id 
                        userID.includes(search.userID) && //ตรวจสอบ เลขรายงาน
                        statusMatch; //ตรวจสอบ id

                         //แสดงข้อมูล 
                        if (match) {
                                row.style.display = ''; //แสดงข้อมูลทีแมช
                            } else {
                                row.style.display = 'none'; //ซ่อนข้อมูล
                            }
                 });
            }

     //ปุ่มล้างรายงาน
            window.resetSearch = function() {
                Object.values(searchInputs).forEach(input => input.value = ''); //วนลูปการค้นหาทั้งหมด ให้เป็นค่าว่าง
                filterTable();
            }
        });
        
  
    // ลบรายงาน
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.btn-delete').forEach(function (button) {
            button.addEventListener('click', function () {
                if (confirm('Are you sure you want to delete this report?')) {
                    const reportId = this.getAttribute('data-report-id'); // เก็บเลข id รายงาน
                    const row = this.closest('tr'); // เก็บแถวปัจจุบันไว้ล่วงหน้า

                    // ส่งคำสั่งลบไปที่ route → controller
                    fetch(`/report/${reportId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                        }
                    })
                    .then(response => response.json()) // แปลง response เป็น JSON
                    .then(data => {
                        alert(data.message); // แสดงข้อความที่ส่งกลับจาก controller

                        if (data.success) {
                            row.remove(); // ลบแถวออกจากตาราง
                        }
                    })
                    .catch(error => {
                        console.error('Error occurred:', error);
                        alert('An unexpected error occurred.');
                    });
                }
            });
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





<?php /**PATH C:\xampp\htdocs\fraudcheck\resources\views/reportlist.blade.php ENDPATH**/ ?>