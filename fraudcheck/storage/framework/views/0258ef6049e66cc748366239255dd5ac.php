<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลส่วนตัว</title>
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
        .form-control {
            border-radius: 30px;
            padding: 0.75rem 1.5rem;
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
        .btn-secondary {
            background-color: #f8f9fa;
            color: #333;
            border: 1px solid #dee2e6;
        }
        .btn-secondary:hover {
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
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center mb-4">แก้ไขข้อมูลส่วนตัว</h2>
                        <!--ส่งไป Route::put('/updateprofile'), enctype(สามารถส่งฟอร์มไฟล์ภาพได้) -->
                        <form action="<?php echo e(route('updateprofile')); ?>" method="POST" enctype="multipart/form-data">

                            <?php echo csrf_field(); ?> <!--ป้องกัน request-->
                            <?php echo method_field('PUT'); ?> <!--แก้ไขข้อมูล-->

                            <div class="mb-4">
                                <label for="username" class="form-label">ชื่อผู้ใช้</label>
                                <input type="text" class="form-control" id="newUsername" name="username" value="<?php echo e(Auth::user()->username); ?>">
                            </div>
                            <div class="mb-4">
                                <label for="email" class="form-label">อีเมล</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo e(Auth::user()->email); ?>" required>
                            </div>

                            <div class="mb-4">
                                <label for="profile_picture" class="form-label">รูปโปรไฟล์</label>
                                <input type="file" class="form-control" id="profile_picture" name="profile_picture">
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-custom btn-primary">บันทึกการเปลี่ยนแปลง</button>
                                <a href="/profile" class="btn btn-custom btn-secondary">ยกเลิก</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
</html><?php /**PATH C:\xampp\htdocs\fraudcheck\fraudcheck\resources\views/editprofile.blade.php ENDPATH**/ ?>