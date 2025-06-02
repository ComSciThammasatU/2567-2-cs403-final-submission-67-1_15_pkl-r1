<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Form</title>
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

        .form-control,
        .form-select {
            border-radius: 10px;
            padding: 0.75rem 1rem;
            border: 1px solid #e0e0e0;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .btn-back {
            background-color: #6c757d;
            color: white;
            border: none;
        }

        .btn-back:hover {
            background-color: #5a6268;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <div class="hero text-center">
            <h1>ค้นหา</h1>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">

                        <!--ส่งไป Route::post('/search')-->
                        <form method="POST" action="<?php echo e(route('search')); ?>">
                            <?php echo csrf_field(); ?>  <!--csrf ป้องกัน request จากเว็บอื่น-->
                            <div class="mb-3"> <!--ช่องกรอกชื่อ-->
                                <label for="name" class="form-label">ชื่อ :</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>
                            <div class="mb-3"> <!--ช่องกรอกนามสกุล-->
                                <label for="surname" class="form-label">นามสกุล :</label>
                                <input type="text" class="form-control" id="surname" name="surname">
                            </div>
                            <div class="mb-3"> <!--ช่องกรอกเลขบัตรประชาชน-->
                                <label for="idcard" class="form-label">เลขบัตรประชาชน (กรุณากรอกหมายเลข 13 หลัก) :</label>
                                <input type="text" class="form-control" id="idcard" name="idcard">
                            </div>
                            <div class="mb-3"> <!--ช่องกรอกพร้อมเพลย์-->
                                <label for="telephone" class="form-label">Promtpay,Truemoney Wallet (กรุณากรอกหมายเลข 10 หลัก) :</label>
                                <input type="text" class="form-control" id="telephone" name="telephone">
                            </div>
                            <div class="mb-3"> <!--ช่องเลือกชนิดธนาคาร-->
                                <label for="bankType" class="form-label">ธนาคาร :</label>
                                <select name="bankType" id="bankType" class="form-select">
                                    <option value="">เลือกธนาคาร</option>
                                    <option value="ธนาคาร กรุงเทพ จำกัด (มหาชน)">ธนาคาร กรุงเทพ จำกัด (มหาชน)</option>
                                    <option value="ธนาคาร กรุงไทย จำกัด (มหาชน)">ธนาคาร กรุงไทย จำกัด (มหาชน)</option>
                                    <option value="ธนาคาร กรุงศรีอยุธยา จำกัด (มหาชน)">ธนาคาร กรุงศรีอยุธยา จำกัด
                                        (มหาชน)</option>
                                    <option value="ธนาคาร กสิกรไทย จำกัด (มหาชน)">ธนาคาร กสิกรไทย จำกัด (มหาชน)</option>
                                    <option value="ธนาคาร เกียรตินาคิน จำกัด (มหาชน)">ธนาคาร เกียรตินาคิน จำกัด (มหาชน)
                                    </option>
                                    <option value="ธนาคาร ซีไอเอ็มบี ไทย จำกัด (มหาชน)">ธนาคาร ซีไอเอ็มบี ไทย จำกัด
                                        (มหาชน)</option>
                                    <option value="ธนาคาร ทหารไทยธนชาต จำกัด (มหาชน)">ธนาคาร ทหารไทยธนชาต จำกัด (มหาชน)
                                    </option>
                                    <option value="ธนาคาร ทิสโก้ จำกัด (มหาชน)">ธนาคาร ทิสโก้ จำกัด (มหาชน)</option>
                                    <option value="ธนาคาร ไทยพาณิชย์ จำกัด (มหาชน)">ธนาคาร ไทยพาณิชย์ จำกัด (มหาชน)
                                    </option>
                                    <option value="ธนาคาร ยูโอบี จำกัด (มหาชน)">ธนาคาร ยูโอบี จำกัด (มหาชน)</option>
                                    <option value="ธนาคาร แลนด์ แอนด์ เฮ้าส์ จำกัด (มหาชน)">ธนาคาร แลนด์ แอนด์ เฮ้าส์
                                        จำกัด (มหาชน)</option>
                                    <option value="ธนาคาร สแตนดาร์ดชาร์เตอร์ด (ไทย) จำกัด (มหาชน)">ธนาคาร
                                        สแตนดาร์ดชาร์เตอร์ด (ไทย) จำกัด (มหาชน)</option>
                                    <option value="ธนาคาร ไอซีบีซี (ไทย) จำกัด (มหาชน)">ธนาคาร ไอซีบีซี (ไทย) จำกัด
                                        (มหาชน)</option>
                                    <option value="ธนาคาร ไทยเครดิต จำกัด (มหาชน)">ธนาคาร ไทยเครดิต จำกัด (มหาชน)
                                    </option>
                                    <option value="ธนาคาร พัฒนาวิสาหกิจขนาดกลางและขนาดย่อมแห่งประเทศไทย">ธนาคาร
                                        พัฒนาวิสาหกิจขนาดกลางและขนาดย่อมแห่งประเทศไทย</option>
                                    <option value="ธนาคาร เพื่อการเกษตรและสหกรณ์การเกษตร">ธนาคาร
                                        เพื่อการเกษตรและสหกรณ์การเกษตร</option>
                                    <option value="ธนาคาร เพื่อการส่งออกและนำเข้าแห่งประเทศไทย">ธนาคาร
                                        เพื่อการส่งออกและนำเข้าแห่งประเทศไทย</option>
                                    <option value="ธนาคาร ออมสิน">ธนาคาร ออมสิน</option>
                                    <option value="ธนาคาร อิสลามแห่งประเทศไทย">ธนาคาร อิสลามแห่งประเทศไทย</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="bankAccount" class="form-label">เลขบัญชีธนาคาร (กรุณาใส่เลขบัญชีธนาคารให้ครบถ้วน) :</label>
                                <input type="text" class="form-control" id="bankAccount" name="bankAccount">
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-custom btn-main">ค้นหา</button>

                                <!--แสดงปุ่มสำหรับผู้ใช้งานที่ Login-->
                                <?php if(Auth::check()): ?>
                                    <a href="/profile" class="btn btn-custom btn-secondary-custom">กลับไปหน้า Profile</a>
                                <?php else: ?>
                                <!--ไม่ได้ Login-->
                                    <div class="d-grid gap-2 mt-3">
                                        <a href="/" class="btn btn-custom btn-secondary-custom">กลับไปหน้าแรก</a>
                                    </div>
                                <?php endif; ?>
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
</html>
<?php /**PATH C:\xampp\htdocs\fraudcheck\fraudcheck\resources\views/search.blade.php ENDPATH**/ ?>