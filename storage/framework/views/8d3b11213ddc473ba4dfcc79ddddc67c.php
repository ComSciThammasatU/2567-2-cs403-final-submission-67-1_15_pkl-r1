<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!--รองรับขนาดหน้าจอในมือถือ-->
    <title>FraudCheck</title>
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
        .hero {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            padding: 4rem 0;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
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
        .btn-search {
            background-color: #ffc107;
            color: #333;
            border: none;
        }
        .btn-search:hover {
            background-color: #ffca2c;
            color: #333;
        }
        .btn-login {
            background-color: #ffffff;
            color: #333;
            border: none;
        }
        .btn-login:hover {
            background-color: #f8f9fa;
            color: #333;
        }
        .text-muted-link {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .text-muted-link:hover {
            color: #ffffff;
            text-decoration: underline;
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
        .form-control {
            border-radius: 30px;
            padding: 0.75rem 1.5rem;
        }
    </style>
</head>
<body>
             <!--แจ้งเตือนล็อคอินซ้อนกัน-->
                <?php if(session('error')): ?>
                <div class="alert alert-danger">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

    <?php if(auth()->guard()->check()): ?>
        <div style="position: absolute; top: 5px; right: 20px; z-index: 999;">
            <a href="<?php echo e(route('profile')); ?>" class="btn btn-outline-primary">โปรไฟล์ของฉัน</a>
        </div>
    <?php endif; ?>
    
    <div class="container my-5">
        <div class="hero text-center">
            <h1 class="mb-4">FraudCheck</h1>
            <div class="d-grid gap-3 col-lg-6 mx-auto">
                <a href="/search" class="btn btn-custom btn-search btn-lg">ค้นหารายงาน</a>
                <!--กำหนดจุด popup ล็อคอิน-->
                <a href="#" class="btn btn-custom btn-login btn-lg" data-bs-toggle="modal" data-bs-target="#loginModal">เข้าสู่ระบบ</a>
                <p class="mt-3">
                    <!--กำหนดจุด popup สมัครสมาชิก-->
                    <a href="#" class="text-muted-link me-5" data-bs-toggle="modal" data-bs-target="#registerModal">สมัครบัญชีผู้ใช้งานใหม่</a>
                    <a href="/guide" class="text-muted-link" >คำแนะนำผู้ใช้งาน</a>
                </p>
               
            </div>
        </div>
    </div>

    <!-- กล่อง Modal ล็อคอิน-->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered"> <!--จัด modal กึ่งกลาง-->
            <div class="modal-content"> 
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">เข้าสู่ระบบ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> <!--แถบปิด-->
                </div>
                <!--ระบบล็อคอิน-->
                <div class="modal-body">
                    <!--ส่งไป Route::post('/profile')-->
                    <form action="/profile" method="POST">
                        <?php echo csrf_field(); ?> <!--csrf ป้องกัน request จากเว็บอื่น-->
                        <div class="mb-3">
                            <label for="username" class="form-label">ชื่อผู้ใช้</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">รหัสผ่าน</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-custom btn-search w-100">เข้าสู่ระบบ</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- กล่อง Modal สมัครสมาชิก-->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">สมัครบัญชีผู้ใช้งานใหม่</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> <!--แถบปิด-->
                </div>
                <!--ระบบสมัครสมาชิก-->
                <div class="modal-body">
                     <!--ส่งไป Route::post('/register')-->
                    <form action="/register" method="POST" id="registerForm">
                        <?php echo csrf_field(); ?> <!--csrf ป้องกัน request จากเว็บอื่น-->
                        <div class="mb-3">
                            <label for="newUsername" class="form-label">ชื่อผู้ใช้ (ห้ามซ้ำ)</label>
                            <input type="text" class="form-control" id="newUsername" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="newEmail" class="form-label">อีเมล (ห้ามซ้ำ)</label>
                            <input type="email" class="form-control" id="newEmail" name="email" required>
                            <div id="emailHelp" class="form-text text-danger"></div> <!-- จุดแสดงข้อความเล็ก -->
                            
                        </div>

                        <div>
                            <p>หมายเหตุ* อีเมลที่สามารถใช้งานได้ ได้แก่</p>
                            <p style="color : red">@gmail.com, @yahoo.com, @icloud.com, @dome.tu.ac.th</p>
                        </div>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">รหัสผ่าน (กรอกรหัสผ่าน 6 ตัวขึ้นไป)</label>
                            <input type="password" class="form-control" id="newPassword" name="password" required>
                        </div>
                        <div id="passwordHelp" class="form-text text-danger"></div> <!--กำหนดจุดแจ้งเตือน-->
                        <button type="submit" class="btn btn-custom btn-search w-100">สมัครบัญชี</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- กล่อง modal แจ้งเตือน Error -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">แจ้งเตือน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- ตำแหน่งข้อความ Error (errorModalBody ตัวแปรแสดงแจ้งเตือน) -->
                <div class="modal-body" id="errorModalBody"> 
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        //แจ้งเตือน สมัครสมาชิก, ตรวจสอบเงื่อนไข
        document.getElementById('registerForm').addEventListener('submit', function(event) {
            var password = document.getElementById('newPassword').value;
            var email = document.getElementById('newEmail').value;
            var passwordHelp = document.getElementById('passwordHelp'); //รับค่าแจ้งเตือนเล็กๆ
            const emailHelp = document.getElementById('emailHelp'); //รับค่าแจ้งเตือนเล็กๆ
            // ตรวจสอบรหัสผ่าน
            if (password.length < 6) {
                event.preventDefault(); //หยุดส่งฟอร์ม เพื่อตรวจสอบเงื่อนไขก่อน
                passwordHelp.innerHTML = 'รหัสผ่านต้องมีความยาวอย่างน้อย 6 ตัวอักษร'; //แจ้งเตือนเล็กๆ
                showErrorModal('รหัสผ่านต้องมีความยาวอย่างน้อย 6 ตัวอักษร'); //ส่งไปแสดงฟังก์ชันล่าง
                return; //หยุด ไม่ให้ทำเงื่อนไขต่อไป
            }

            // ตรวจสอบอีเมล
            const allowedDomains = ['gmail.com', 'yahoo.com', 'icloud.com', 'dome.tu.ac.th'];
            const emailDomain = email.split('@')[1]; //ใช้หลัง @ เช่น gmail.com        
            //ตรวจสอบ ถ้าไม่มี @ หรือ ไม่ใช่อีเมลที่ระบุ ให้แจ้งเตือน
            if (!emailDomain || !allowedDomains.includes(emailDomain)) {
                event.preventDefault(); //หยุดส่งฟอร์ม เพื่อตรวจสอบเงื่อนไขก่อน
                emailHelp.innerHTML = 'กรุณาใช้อีเมลที่ลงท้ายด้วย @gmail.com, @yahoo.com, @icloud.com หรือ @dome.tu.ac.th'; //แจ้งเตือนเล็กๆ
                showErrorModal('ผู้ใช้งานกรอกอีเมลไม่ตรงเงื่อนไข กรุณาใช้อีเมลที่ลงท้ายด้วย @gmail.com, @yahoo.com, @icloud.com หรือ @dome.tu.ac.th'); //ส่งไปแสดงฟังก์ชันล่าง
                return; //หยุด ไม่ให้ทำเงื่อนไขต่อไป
            }
            
            passwordHelp.innerHTML = ''; //แสดง error เสร็จสิ้น ให้ล้างข้อความ
        });

        //นำข้อความมาแสดงเป็นป้าย (showErrorModal)
        function showErrorModal(message) { 
            var errorModal = new bootstrap.Modal(document.getElementById('errorModal')); //ตำแหน่งกล่องข้อความ

            document.getElementById('errorModalBody').innerHTML = message; //จุดที่แสดงกล่องแจ้งเตือน
            errorModal.show(); //แสดง
   
        }

        //แจ้งเตือน ล็อคอิน
        //นำตัวแปรจาก controller(return back) มาใช้
        <?php if(session('loginError')): ?>
            showErrorModal('การเข้าสู่ระบบผิดพลาด ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง');
        <?php endif; ?>

        //แจ้งเตือน สมัครสมาชิก
        //แสดง modal จาก controller(return Error)
        <?php if($errors->any()): ?>
        //ฟังก์ชันแปล message จาก อังกฤษเป็นไทย (ตั้งค่า)
        function replaceErrorMessage(message) { 
            if (message.includes('username')) {
                return 'ชื่อผู้ใช้ได้ถูกนำไปใช้แล้ว';
            } else if (message.includes('email')) {
                return 'อีเมล์นี้ได้ถูกนำไปใช้แล้ว';
            } 
            return message;
        }

        //รับค่า error จาก controller มาวนลูป (กรณี id กับ email ผิดพลาดทั้งคู่)
        var errorMessages = [
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                '<?php echo e($error); ?>', //ดึงข้อมูลจาก 'message' ใน controller
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        ];

        //ใช้ฟังก์ชันเปลี่ยน error เป็นภาษาไทย (ใช้งาน)
        var formattedErrorMessages = errorMessages.map(function(message) {
            return replaceErrorMessage(message); //ใช้ฟังก์ชันแปล
        });

        //นำ message ไทย มารวมกัน (เว้รบรรทัดด้วย <br>)
        var errorMessage = formattedErrorMessages.join('<br>');
        showErrorModal(errorMessage); //แสดง
        <?php endif; ?>
    </script>
    
</body>
</html><?php /**PATH C:\Users\MS\OneDrive\เดสก์ท็อป\แตกไฟล์โปรเจค\fraudcheck\resources\views/welcome.blade.php ENDPATH**/ ?>