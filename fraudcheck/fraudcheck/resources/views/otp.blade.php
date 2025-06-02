<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
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
            border: 1px solid #ced4da;
        }

        .form-control:focus {
            border-color: #6a11cb;
            box-shadow: 0 0 0 0.2rem rgba(106, 17, 203, 0.25);
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
    </style>
</head>

<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center mb-4">ยืนยันรหัส OTP</h2>
                        <!--ส่งไป Route::post('/verify-otp')-->
                        <form action="/verify-otp" method="POST">
                            @csrf <!--ป้องกัน request จากเว็บอื่น-->
                            <div class="mb-4">
                                <label for="otp" class="form-label">กรุณากรอกหมายเลข OTP<br>(หมายเลข OTP
                                    ถูกส่งในอีเมลที่ทำการสมัคร)</label>
                                <!--ช่องกรอก otp / แจ้งเตือนรหัส otp ผิด-->
                                <input type="text" class="form-control @error('otp') is-invalid @enderror" id="otp" name="otp" required>
                                
                                <!--แจ้งเตือน otp ผิด-->
                                @error('otp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-custom btn-primary">ยืนยัน OTP</button>
                            </div>
                        </form>
                 
                <!--ส่ง OTP ซ้ำ-->
                 <form action="{{ route('otp.resend') }}" method="POST" class="mt-3 text-center">
                     @csrf
                        <button type="submit" class="btn btn-outline-secondary">ส่ง OTP อีกครั้ง</button>
                 </form>
                 
                 <!--แจ้งเตือน success จาก controller ส่ง OTP ใหม่เรียบร้อยแล้ว-->
                @if(session('success'))
                    <p class="text-success text-center mt-3" style="font-weight: 500;">
                     {{ session('success') }}
                    </p>
                @endif



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

</html>
