<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"> <!--import สัญลักษณ์ขีดถูก-->
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
        .profile-picture {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid #fff;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
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
        .modal-content {
            border-radius: 15px;
            border: none;
        }
        .modal-header {
            background-color: #f8f9fa;
            border-bottom: none;
            border-radius: 15px 15px 0 0;
        }
        .modal-footer {
            border-top: none;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <!--แสดงภาพโปรไฟล์-->                                                                                                <!--ลิงค์รูปชั่วคราว--> 
                        <img src="<?php echo e(Auth::user()->profile_picture ? asset('storage/profile_pictures/'.Auth::user()->profile_picture) : 'https://via.placeholder.com/150'); ?>"
                         alt="Profile Picture" class="profile-picture mb-4">
                        <h3 class="card-title mb-3"><?php echo e(Auth::user()->username); ?></h3> <!--แสดง username --> 
                        <p class="card-text"><strong>ID:</strong> <?php echo e(Auth::user()->id); ?></p>  <!--แสดงเลข ID --> 
                        <p class="card-text"><strong>อีเมล:</strong> <?php echo e(Auth::user()->email); ?></p> <!--แสดง email --> 
                        <p class="card-text"><strong>สถานะ:</strong> <?php echo e(Auth::user()->role); ?></p> <!--แสดง สถานะ --> 
                    </div>
                </div>
                <div class="d-grid gap-3">
                    
                    <!--Checkroll ว่าเป็น ผู้ใช้งาน หรือ แอดมิน--> 
                    <?php if(Auth::user()->role !== 'admin'): ?> <!--ผู้ใช้งาน -->
                        <a href="<?php echo e(route('user.reports')); ?>" class="btn btn-custom btn-main">ดูรายงาน</a>
                    <?php endif; ?>
                    <a href="/search" class="btn btn-custom btn-main">ค้นหารายงาน</a> <!--ปุ่มนี้มีทั้ง ผู้ใช้งาน และ แอดมิน--> 
                    <?php if(Auth::user()->role === 'admin'): ?> <!--แอดมิน -->
                        <a href="/reportlist" class="btn btn-custom btn-main">ดูการส่งรายงาน</a>
                        <a href="<?php echo e(route('protests.index')); ?>" class="btn btn-custom btn-main">ดูการแจ้งลบรายงาน</a>
                    <?php endif; ?>

                    <!--ผู้ใช้งาน และ แอดมิน-->
                    <a href="<?php echo e(url('/editprofile')); ?>" class="btn btn-custom btn-secondary-custom">แก้ไขข้อมูลส่วนตัว</a>
                    <a href="<?php echo e(route('editpassword')); ?>" class="btn btn-custom btn-secondary-custom">เปลี่ยนรหัสผ่าน</a>
                    
                    <a href="/logout" class="btn btn-custom btn-danger">ออกจากระบบ</a>
                </div>
                <div class="text-center mt-4">
                    <a href="/" class="btn btn-custom btn-secondary-custom">หน้าหลัก</a>
                </div>
            </div>
        </div>
    </div>

    <!-- สร้างกล่อง modal 'สำเร็จ' ในหน้า profile-->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">แจ้งเตือน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center"> <!-- จัดข้อความ + ไอคอนตรงกลาง -->
                    <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                    <p class="mb-0">ดำเนินการสำเร็จ</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>

     <!-- สร้างกล่อง modal 'ไม่สำเร็จ' ในหน้า profile-->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-danger">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="errorModalLabel">แจ้งเตือน</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <i class="fas fa-times-circle fa-4x text-danger mb-3"></i>
                    <p class="mb-0">ดำเนินการไม่สำเร็จ</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // แสดง Modal Success
            <?php if(session('success')): ?>
                if (!sessionStorage.getItem('shown_success')) {
                    const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                    successModal.show();
                    sessionStorage.setItem('shown_success', 'true');
                }
            <?php endif; ?>
    
            // แสดง Modal Error
            <?php if(session('error')): ?>
                if (!sessionStorage.getItem('shown_error')) {
                    const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                    errorModal.show();
                    sessionStorage.setItem('shown_error', 'true');
                }
            <?php endif; ?>
        });
    
        // ล้าง Modal เมื่อ back กลับ
        window.addEventListener('beforeunload', function () {
            sessionStorage.removeItem('shown_success');
            sessionStorage.removeItem('shown_error');
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
</html><?php /**PATH C:\xampp\htdocs\fraudcheck\fraudcheck\resources\views/profile.blade.php ENDPATH**/ ?>