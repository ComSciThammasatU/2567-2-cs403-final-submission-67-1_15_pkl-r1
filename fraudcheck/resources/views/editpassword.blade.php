<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขรหัสผ่าน</title>
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
                        <h2 class="text-center mb-4">แก้ไขรหัสผ่าน</h2>
                        <!--ส่งไป Route::put('updatepassword')-->
                        <form id="changePasswordForm" action="{{ route('updatepassword') }}" method="POST">
                            @csrf <!--ป้องกันการรับ request จากภายนอก-->
                            @method('PUT') <!--ใช้ put เพื่อแก้ไข-->
                            <div class="mb-4">
                                <label for="current_password" class="form-label">รหัสผ่านปัจจุบัน</label>
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                            </div>
                            <div class="mb-4">
                                <label for="new_password" class="form-label">รหัสผ่านใหม่</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                            </div>
                            <div class="mb-4">
                                <label for="new_password_confirmation" class="form-label">ยืนยันรหัสผ่านใหม่</label>
                                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                                <div id="password-match-message" class="form-text mt-2"></div>
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

    <!-- สร้างกล่องแจ้งเตือน -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">แจ้งเตือน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                 <!-- ตั้งจุดข้อความ -->
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
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('changePasswordForm').addEventListener('submit', function(event) { 
                var newPassword = document.getElementById('new_password').value;
                var confirmPassword = document.getElementById('new_password_confirmation').value;
                var errorMessage = '';
        
                if (newPassword.length < 6) {
                    errorMessage = 'รหัสผ่านใหม่ต้องมีความยาวอย่างน้อย 6 ตัวอักษร';
                } else if (newPassword !== confirmPassword) {
                    errorMessage = 'รหัสผ่านใหม่และการยืนยันรหัสผ่านไม่ตรงกัน';
                }
                
                //แสดงข้อความ modal
                if (errorMessage) {
                    event.preventDefault();
                    var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                    document.getElementById('errorModalBody').textContent = errorMessage;
                    errorModal.show(); //แสดง
                }
            });
        });
        </script>

        <!--แสดง return back จาก controller ("รหัสผ่านปัจจุบันไม่ถูกต้อง")-->
        @if(session('error'))
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            document.getElementById('errorModalBody').textContent = {!! json_encode(session('error')) !!};
            errorModal.show(); //แสดง
        });
        </script>
        @endif
        
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