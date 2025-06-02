<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แจ้งลบรายงาน</title>
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
        h6 {
            font-size: 16px
           
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="card">
            <div class="card-body">
                <h2 class="text-center mb-4">แจ้งลบรายงาน</h2>
                
                <h4>หมายเลขรายงานที่แจ้ง: <?php echo e($report->id); ?></h4>  <!--แสดงเลขรายงาน-->
              
                <h4>หมายเลขผู้รายงาน: <?php echo e(Auth::user()->id); ?></h4> <!--แสดงเลขรายงาน-->

                <!--ส่งไป Route::post('protest.store')-->
                <form action="<?php echo e(route('protest.store', $report->id)); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?> <!--ป้องกันการส่ง request จากที่อื่น-->
                    <div class="mb-4">
                        <label class="form-label">เหตุผลในการคัดค้าน</label>
                        <!--ปุ่มเลือก-->
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="reason" id="reason1" value="1" checked>
                            <label class="form-check-label" for="reason1">กรอกข้อมูลรายงานผิดพลาด</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="reason" id="reason2" value="2">
                            <label class="form-check-label" for="reason2">อื่น ๆ (กรณีพบข้อมูลที่ถูกกลั่นแกล้ง)</label>
                        </div>
                    </div>
                        <!--ช่องกรอกอีเมล กรณีเลือกอื่นๆ-->
                    <div class="mb-4">
                        <label for="description" class="form-label">
                            <span style="color: red;">***</span> กรณีเลือกอื่น ๆ โปรดระบุอีเมล และผู้ดูแลระบบจะส่งข้อมูลไปสอบถาม<span style="color: red;">***</span>
                        </label>
                        <textarea class="form-control" id="description" name="description" rows="5" disabled></textarea>
                    </div>
                    <div class="mb-4">
                        <span style="color: red;">***</span> แนบภาพไฟล์รายงาน ที่ต้องการให้ผู้ดูแลระบบดำเนินการ <span style="color: red;">***</span>
                        <!-- ตัวอย่างการแคปหน้าจอ -->
                                    <div class="mb-4">
                                        <h6 class="mb-3">ตัวอย่างการแคปหน้าจอ</h6>
                                        <div class="d-flex gap-3">
                                            <!--ตัวอย่างที่1 ตั้งจุดขยายภาพ-->
                                            <div class="example-image-container text-center">
                                                <img src="https://i.ibb.co/Bcs3GF9/Screenshot-1-0.jpg" 
                                                     alt="กรณี 1" 
                                                     class="img-thumbnail w-50 cursor-pointer example-img" 
                                                     data-bs-toggle="modal" 
                                                     data-bs-target="#imageModal" 
                                                     data-img-src="https://i.ibb.co/Bcs3GF9/Screenshot-1-0.jpg" 
                                                     data-img-title="กรณี 1">
                                                <small class="d-block mt-2">กรณี 1<br>กรอกข้อมูลรายงานผิดพลาด</small>
                                            </div>
                                            <!--ตัวอย่างที่2 ตั้งจุดขยายภาพ-->
                                            <div class="example-image-container text-center">
                                                <img src="https://i.ibb.co/SwRCvVF/Screenshot-2-0.jpg" 
                                                     alt="กรณี 2" 
                                                     class="img-thumbnail w-50 cursor-pointer example-img" 
                                                     data-bs-toggle="modal" 
                                                     data-bs-target="#imageModal" 
                                                     data-img-src="https://i.ibb.co/SwRCvVF/Screenshot-2-0.jpg" 
                                                     data-img-title="กรณี 2">
                                                <small class="d-block mt-2">กรณี 2<br>อื่น ๆ (กรณีพบข้อมูลที่ถูกกลั่นแกล้ง)</small>
                                            </div>
                                        </div>
                                    </div>
                                    
                        <!--แนบไฟล์ภาพ เลือกได้หลายไฟล์ (multiple)-->
                        <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*" max="3">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-custom btn-primary">ส่งคำคัดค้าน</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- สร้างกล่องขยายภาพ -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            //เปิดช่อง description สำหรับติ๊กช่อง2 (อื่น ๆ )
            const reasonRadios = document.querySelectorAll('input[name="reason"]'); //รับค่าปุ่ม 1,2
            const descriptionTextarea = document.getElementById('description'); //ช่องกรอกอีเมล

            reasonRadios.forEach(radio => { 
                radio.addEventListener('change', function() {
                    if (this.value === '1') { //ถ้ากดช่อง 1 (กรอกข้อมูลผิดพลาด)
                        descriptionTextarea.disabled = true; //ปิดช่องกรอกอีเมล
                        descriptionTextarea.required = false; //ไม่บังคับให้กรอก
                    } else { //ถ้ากดช่อง 2 (อื่น ๆ)
                        descriptionTextarea.disabled = false; //ไม่ปิดช่องกรอกอีเมล
                        descriptionTextarea.required = true; //บังคับให้กรอก
                    }
                });
            });

            //่javascript นำกล่องมาขยายใหญ่ภาพ
            document.addEventListener('DOMContentLoaded', function () {
                const imageModal = document.getElementById('imageModal');
                const modalImage = document.getElementById('modalImage');
                const modalTitle = document.getElementById('imageModalTitle');
                const exampleImages = document.querySelectorAll('.example-img');

                exampleImages.forEach(image => {
                    image.addEventListener('click', function () {
                        const imgSrc = this.getAttribute('data-img-src');
                        const imgTitle = this.getAttribute('data-img-title');
                        
                        modalImage.src = imgSrc;
                        modalTitle.textContent = imgTitle;
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

<script>
    //เช็คการถูกต้องของภาพที่แนบส่ง นามสกุลภาพต้องตรง และขนาดไม่เกิน 5MB
    document.addEventListener('DOMContentLoaded', function () {
        const fileInputs = document.querySelectorAll('input[type="file"]');
    
        fileInputs.forEach(function (input) {
            input.addEventListener('change', function (event) {
                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/heic', 'image/heif'];
                const maxSizeMB = 5;
    
                for (const file of input.files) {
                    if (!allowedTypes.includes(file.type)) {
                        alert(`ไฟล์ ${file.name} ไม่ใช่ไฟล์ภาพที่รองรับ`);
                        input.value = ""; // ล้างค่า
                        return;
                    }
    
                    const fileSizeMB = file.size / (1024 * 1024);
                    if (fileSizeMB > maxSizeMB) {
                        alert(`ไฟล์ ${file.name} มีขนาดเกิน ${maxSizeMB}MB`);
                        input.value = ""; // ล้างค่า
                        return;
                    }
                }
            });
        });
    });
    </script>
</body>
</html><?php /**PATH C:\xampp\htdocs\fraudcheck\fraudcheck\resources\views/protest_form.blade.php ENDPATH**/ ?>