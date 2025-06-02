<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายการแจ้งลบรายงาน</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Prompt', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }
        .container {
            max-width: 1000px;
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
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-body {
            padding: 2rem;
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
        .protest-image {
            width: 100%;
            height: 150px;
            object-fit: cover;
            cursor: pointer;
            transition: transform 0.3s ease;
            border-radius: 10px;
        }
        .protest-image:hover {
            transform: scale(1.05);
        }
        .modal-image {
            max-width: 100%;
            max-height: 80vh;
            border-radius: 10px;
        }
        .pagination {
            justify-content: center;
        }
        .page-item.active .page-link {
            background-color: #6a11cb;
            border-color: #6a11cb;
        }
        .page-link {
            color: #6a11cb;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="hero text-center">
            <h1>รายการแจ้งลบรายงาน</h1> <!--หัวข้อ-->
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="d-flex justify-content-between mb-4">
                    <a href="/profile" class="btn btn-custom btn-secondary-custom">
                        <i class="bi bi-arrow-left"></i> กลับไปหน้า Profile <!--ปุ่มกลับหน้าโปรไฟล์-->
                    </a>
                    <?php if(Auth::user() && Auth::user()->role === 'admin'): ?>
                        <a href="/reportlist" class="btn btn-custom btn-main">
                            <i class="bi bi-list-ul"></i> กลับไปหน้ารวมรายงาน <!--ถ้าเป็น admin แสดงปุ่มนี้-->
                        </a>
                    <?php endif; ?>
                </div>
                
                <!--แสดงรายงานหลาย ๆ รายงานแก่ผู้ใช้งาน-->
                <?php $__currentLoopData = $protests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $protest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">หัวข้อ: <?php echo e($protest->title); ?></h5> <!--แสดงหัวข้อจากฐานข้อมูล-->
                            <p class="card-text">หมายเลขผู้แจ้ง: <?php echo e($protest->user_id); ?></p> <!--แสดงเลขผู้แจ้งจากฐานข้อมูล-->
                            <p class="card-text">หมายเลขรายงาน: <?php echo e($protest->report_id); ?></p> <!--แสดงหมายเลขรายงานจากฐานข้อมูล-->
                            <p class="card-text">หมายเหตุ: <?php echo e($protest->description); ?></p> <!--แสดงอีเมลที่ผู้ใช้เก็บจากฐานข้อมูล-->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <small class="text-muted">ชื่อผู้แจ้ง: <?php echo e($protest->user->username ?? 'ไม่ระบุ'); ?></small> <!--แสดงชื่อผู้แจ้งจากฐานข้อมูล App_User โดยชี้ไปที่ฟังก์ชัน user ในโมเดล Protests-->
                                <small class="text-muted">วันที่แจ้ง: <?php echo e($protest->created_at->format('d/m/Y H:i')); ?></small> <!--แสดงวันเวลาแจ้งรายงาน-->
                            </div>
                            
                            <?php if($protest->images): ?> <!--แสดงรูปภาพ-->
                                <div class="row mt-3">
                                    <?php $__currentLoopData = $protest->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <!--เก็บตำแหน่ง 0 ภาพที่ 1, ตำแหน่ง 1 ภาพที่ 2, ....-->
                                        <div class="col-md-4 col-6 mb-3">
                                            <!--แสดงภาพ, ใช้จาวาสคริปเพื่อขยายภาพให้ใหญ่-->
                                            <img src="<?php echo e($image); ?>" alt="Protest Image <?php echo e($index + 1); ?>"  
                                                 class="protest-image"
                                                 data-bs-toggle="modal" 
                                                 data-bs-target="#imageModal" 
                                                 data-bs-image="<?php echo e($image); ?>"> <!--ส่งภาพจากฐานข้อมูล ให้ javascript-->
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>

                            <!--Toggle Switch ใช้ checkbox + Bootstrap-->
                            <!--สวิตช์การทำงาน ดำเนินการเสร็จ , ยังไม่ดำเนินการ // $protest->id(มีเพื่อแยกปุ่มกดแต่ละรายงานให้ได้ผลลัพธ์แตกต่างกัน)-->
                            <div class="form-check form-switch position-absolute top-0 end-0 m-2">
                                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault<?php echo e($protest->id); ?>"
                                    data-protest-id="<?php echo e($protest->id); ?>" onchange="updateProtestStatus(<?php echo e($protest->id); ?>, this.checked)">
                                <label class="form-check-label protest-status text-warning" for="flexSwitchCheckDefault<?php echo e($protest->id); ?>">ยังไม่ดำเนินการ</label>
                            </div>
      
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
                <!--แสดงลิงค์แบ่งหน้า-->
                <div class="d-flex justify-content-center mt-4">
                    <?php echo e($protests->links()); ?>

                </div>
            </div>
        </div>
    </div>

    <!-- สร้างกล่องขยายภาพให้ใหญ่ (สัมพันธ์กับตัวที่เรียกใช้ข้างบน data-bs-toggle="modal", data-bs-target="#imageModal")-->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <img src="" class="modal-image w-100" alt="Full size image"> <!--ภาพยังว่าง เพราะสร้างแค่กล่องเก็บ-->
                </div>
            </div>
        </div>
    </div>

    <!--อิมพอท bootstrap เพื่อเรียกใช้ ปุ่ม modal, ปุ่มdropdown, อื่นๆ-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!--จาวาสคริป-->
    <script>
        //ขยายภาพใหญ่ขึ้น 
        var imageModal = document.getElementById('imageModal')
        imageModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget //รูปที่ถูกคลิก
            var imageUrl = button.getAttribute('data-bs-image') //นำภาพมาแสดง
            var modalImage = imageModal.querySelector('.modal-image') //อ้างอิงไปที่ class .modal-image
            modalImage.src = imageUrl //ใส่ url ให้ img src ในกล่องภาพ
        })


        //ฟังก์ชันตรวจสอบเงื่อนไข checkbox ดำเนินการสำเร็จ, ยังไม่ดำเนินการ
        function updateProtestStatus(protestId, isChecked) {
          const label = document.querySelector(`label[for="flexSwitchCheckDefault${protestId}"]`);
          
          if (isChecked) { //ดำเนินการเสร็จ ให้ขึ้นสีเขียว
            label.textContent = 'ดำเนินการเสร็จแล้ว';
            label.classList.remove('text-warning');
            label.classList.add('text-success');
          } else {  //ยังไม่ดำเนินการ ให้ขึ้นสีส้ม
            label.textContent = 'ยังไม่ดำเนินการ';
            label.classList.remove('text-success');
            label.classList.add('text-warning');
          }
          
          // บันทึกปุ่ม checkbox การดำเนินการค้างไว้หน้าเว็บ
          localStorage.setItem(`protest_${protestId}_status`, isChecked);
        }


        //checkbox การทำงานแอดมิน
        document.addEventListener('DOMContentLoaded', function() {
            //รับ element checkbox
          const checkboxes = document.querySelectorAll('input[type="checkbox"][data-protest-id]'); 
          
          //วนลูป checkbox
          checkboxes.forEach(checkbox => {
            const protestId = checkbox.dataset.protestId; //ตรวจสอบ id ตรงกับ checkbox 
            const status = localStorage.getItem(`protest_${protestId}_status`); //นำค่าที่บันทึกไว้ มาแสดง
            
            //ถ้ามีสถานะที่บันทึกไว้ 
            if (status === 'true') { 
              checkbox.checked = true; //ตั้งให้ checkbox เป็นติ๊กแล้ว
              updateProtestStatus(protestId, true); //และเข้าใช้ฟังก์ชัน ตรวจสอบ checkbox
            }
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
</html><?php /**PATH C:\xampp\htdocs\fraudcheck\fraudcheck\resources\views/protests/index.blade.php ENDPATH**/ ?>