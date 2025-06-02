<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มรายงานมิจฉาชีพ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!--import สัญลักษณ์ขีดถูก-->

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

        .form-control,
        .form-select {
            border-radius: 30px;
            padding: 0.75rem 1.5rem;
            border: 1px solid #ced4da;
        }

        .form-control:focus,
        .form-select:focus {
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

        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.875em;
            margin-top: 0.25rem;
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

        .example-image-container img {
            max-width: 105px;
            /* ลดขนาดลง 70% จากเดิม 150px */
            height: auto;
            transition: transform 0.3s ease;
            /* เพิ่มเอฟเฟกต์ hover */
        }

        .example-image-container img:hover {
            transform: scale(1.1);
            /* ขยายภาพเมื่อชี้เมาส์ */
        }

        .example-image-container {
            flex: 1 1 auto;
            max-width: 120px;
            /* จำกัดพื้นที่ของคอนเทนเนอร์ */
        }

        .modal-xl {
             max-width: 80%; /* กำหนดให้ใหญ่ 95% ของหน้าจอ */
        }
        #modalImage {
            width: 100%; 
            height: 90vh; 
            object-fit: cover; /* บังคับให้รูปเต็ม modal แม้ภาพแตก */
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <div class="card">
            <div class="card-body">
                <h1 class="text-center mb-4">เพิ่มรายงาน</h1>

                <!--ส่งไป Route::post('reports.store')-->
                <form id="reportForm" action="<?php echo e(route('reports.store')); ?>" method="POST"
                    enctype="multipart/form-data">
                    <?php echo csrf_field(); ?> <!--csrf ป้องกัน request จากเว็บอื่น-->
                    <div class="mb-3">
                        <label for="name" class="form-label">ชื่อ :</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="surname" class="form-label">นามสกุล :</label>
                        <input type="text" name="surname" id="surname" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="idcard" class="form-label">เลขบัตรประชาชน (กรุณาใส่หมายเลข 13 หลัก) :</label>
                        <input type="text" name="idcard" id="idcard" class="form-control">
                        <div id="idcard-validation-message" class="form-text"></div> <!--แสดงข้อความการตรวจสอบ-->
                    </div>
                    <div class="mb-3">
                        <label for="telephone" class="form-label">PromptPay หรือ Truemoney Wallet (กรุณาใส่หมายเลข 10
                            หลัก) :</label>
                        <input type="text" name="telephone" id="telephone" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="bankType" class="form-label">ธนาคาร :</label>
                        <select name="bankType" id="bankType" class="form-select">
                            <option value="">เลือกธนาคาร</option>
                            <option value="ธนาคาร กรุงเทพ จำกัด (มหาชน)">ธนาคาร กรุงเทพ จำกัด (มหาชน)</option>
                            <option value="ธนาคาร กรุงไทย จำกัด (มหาชน)">ธนาคาร กรุงไทย จำกัด (มหาชน)</option>
                            <option value="ธนาคาร กรุงศรีอยุธยา จำกัด (มหาชน)">ธนาคาร กรุงศรีอยุธยา จำกัด (มหาชน)
                            </option>
                            <option value="ธนาคาร กสิกรไทย จำกัด (มหาชน)">ธนาคาร กสิกรไทย จำกัด (มหาชน)</option>
                            <option value="ธนาคาร เกียรตินาคิน จำกัด (มหาชน)">ธนาคาร เกียรตินาคิน จำกัด (มหาชน)</option>
                            <option value="ธนาคาร ซีไอเอ็มบี ไทย จำกัด (มหาชน)">ธนาคาร ซีไอเอ็มบี ไทย จำกัด (มหาชน)
                            </option>
                            <option value="ธนาคาร ทหารไทยธนชาต จำกัด (มหาชน)">ธนาคาร ทหารไทยธนชาต จำกัด (มหาชน)</option>
                            <option value="ธนาคาร ทิสโก้ จำกัด (มหาชน)">ธนาคาร ทิสโก้ จำกัด (มหาชน)</option>
                            <option value="ธนาคาร ไทยพาณิชย์ จำกัด (มหาชน)">ธนาคาร ไทยพาณิชย์ จำกัด (มหาชน)</option>
                            <option value="ธนาคาร ยูโอบี จำกัด (มหาชน)">ธนาคาร ยูโอบี จำกัด (มหาชน)</option>
                            <option value="ธนาคาร แลนด์ แอนด์ เฮ้าส์ จำกัด (มหาชน)">ธนาคาร แลนด์ แอนด์ เฮ้าส์ จำกัด
                                (มหาชน)</option>
                            <option value="ธนาคาร สแตนดาร์ดชาร์เตอร์ด (ไทย) จำกัด (มหาชน)">ธนาคาร สแตนดาร์ดชาร์เตอร์ด
                                (ไทย) จำกัด (มหาชน)</option>
                            <option value="ธนาคาร ไอซีบีซี (ไทย) จำกัด (มหาชน)">ธนาคาร ไอซีบีซี (ไทย) จำกัด (มหาชน)
                            </option>
                            <option value="ธนาคาร ไทยเครดิต จำกัด (มหาชน)">ธนาคาร ไทยเครดิต จำกัด (มหาชน)</option>
                            <option value="ธนาคาร พัฒนาวิสาหกิจขนาดกลางและขนาดย่อมแห่งประเทศไทย">ธนาคาร
                                พัฒนาวิสาหกิจขนาดกลางและขนาดย่อมแห่งประเทศไทย</option>
                            <option value="ธนาคาร เพื่อการเกษตรและสหกรณ์การเกษตร">ธนาคาร เพื่อการเกษตรและสหกรณ์การเกษตร
                            </option>
                            <option value="ธนาคาร เพื่อการส่งออกและนำเข้าแห่งประเทศไทย">ธนาคาร
                                เพื่อการส่งออกและนำเข้าแห่งประเทศไทย</option>
                            <option value="ธนาคาร ออมสิน">ธนาคาร ออมสิน</option>
                            <option value="ธนาคาร อิสลามแห่งประเทศไทย">ธนาคาร อิสลามแห่งประเทศไทย</option>
                        </select>
                        <div class="error-message">กรุณาเลือกธนาคารเมื่อกรอกเลขบัญชี</div>
                        <!--แจ้งเตือนเลือกธนาคารเล็กๆ-->
                    </div>
                    <div class="mb-3">
                        <label for="bankAccount" class="form-label">เลขบัญชี :</label>
                        <input type="text" name="bankAccount" id="bankAccount" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">จำนวนเงิน :</label>
                        <input type="text" name="amount" id="amount" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="productName" class="form-label">ชื่อสินค้า :</label>
                        <input type="text" name="productName" id="productName" class="form-control">
                    </div>
                    <div>
                        <p>หมายเหตุ*</p>
                        <p style="color: red;"> ผู้ใช้งานจำเป็นต้องปกปิดข้อมูลบางส่วนในภาพสลิปโอนเงิน
                            และรายงานบันทึกประจำวันก่อนส่งข้อมูลเข้าสู่ระบบ เช่น ชื่อ นามสกุล, เลขบัญชี, เลขบัตรประชาชน,
                            Prompay, Truemoney <br><br>การปกปิด ชื่อ-นามสกุล ( หลักฐานต่าง ๆ เช่น สลิปโอนเงิน, ภาพการพูดคุย, หลักฐานบันทึกประจำวัน ) <br>&nbsp;&nbsp;&nbsp;กรณีที่ 1 : มี 2 ตัวอักษร ปกปิดตัวอักษรสุดท้าย<br>&nbsp;&nbsp;&nbsp;กรณีที่ 2 : มี 3-4 ตัวอักษร ปกปิดตัวอักษรตำแหน่งกลาง( แสดงตัวอักษรแรก และตัวอักษรสุดท้าย )<br>&nbsp;&nbsp;&nbsp;กรณีที่ 3 : มี 5 ตัวอักษปกปิดตัวอักษรตำแหน่งกลาง( แสดงตัวอักษร 1 ตัวแรก และ 2 ตัวอักษรสุดท้าย )<br>&nbsp;&nbsp;&nbsp;กรณีที่ 4 : มี 6 ตัวอักษรขึ้นไปปกปิดตัวอักษรตำแหน่งกลาง( แสดงตัวอักษร 2 ตัวแรกและ 2 ตัวอักษรสุดท้าย )
                            <br><br>การปกปิด เลขบัตรประชาชน, PromtPay หรือ Truemoney, เลขธนาคาร <br>&nbsp;&nbsp;&nbsp;กรณีที่มีข้อมูล : ให้ปกปิดข้อมูล และเปิด 3 ตัวอักษรสุดท้าย</p>
                        <p style="color: red">*หากผู้ใช้งานไม่ปฏิบัติตามหมายเหตุ
                            รายงานของผู้ใช้งานจะถูกปฏิเสธจากผู้ดูแลระบบ*</p>
                    </div>


                    <div class="example-images mb-4">
                        <p class="mb-3 fw-bold">ตัวอย่างภาพ:</p>
                        <div class="d-flex flex-wrap gap-4 justify-content-start align-items-center">
                            <div class="example-image-container text-center">
                                <!--วางจุดขยายภาพ modal-->
                                <img src="https://i.ibb.co/xqQJ1QqZ/2.jpg"
                                    alt="ตัวอย่างหลักฐานการโอนเงิน" class="img-thumbnail cursor-pointer example-img"
                                    data-bs-toggle="modal" data-bs-target="#imageModal"
                                    data-img-src="https://i.ibb.co/xqQJ1QqZ/2.jpg"
                                    data-img-title="ตัวอย่างหลักฐานการโอนเงิน และวิธีการปกปิดข้อมูล">
                                <small class="d-block mt-2">ปกปิดการโอนเงิน</small>
                            </div>
                            <div class="example-image-container text-center">
                                <!--วางจุดขยายภาพ modal-->
                                <img src="https://i.ibb.co/YTLw2VCL/Screenshot-1.jpg"
                                alt="ตัวอย่างบันทึกประจำวัน" 
                                class="img-thumbnail cursor-pointer example-img"
                                data-bs-toggle="modal" 
                                data-bs-target="#imageModal"
                                data-img-src="https://i.ibb.co/YTLw2VCL/Screenshot-1.jpg"
                                data-img-title="ตัวอย่างบันทึกประจำวัน และแชทการพูดคุย">
                            <small class="d-block mt-2">ปกปิดใบแจ้งความ</small>
                            
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="product_images" class="form-label">รูปสินค้า (สูงสุด 3 รูป) :</label>
                        <input type="file" name="product_images[]" id="product_images" class="form-control"
                            multiple accept="image/*" max="3">
                    </div>
                    <div class="mb-3">
                        <label for="conversation_images" class="form-label">รูปการพูดคุยและหลักฐาน (สูงสุด 3 รูป)
                            :</label>
                        <input type="file" name="conversation_images[]" id="conversation_images"
                            class="form-control" multiple accept="image/*" max="3">
                    </div>

                    

                    <div class="mb-3">
                        <label for="payment_date" class="form-label">วันที่ทำการโอนเงิน :</label>
                        <input type="date" name="payment_date" id="payment_date" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="communication_platform" class="form-label">ช่องทาง Application
                            ที่ใช้พูดคุย:</label>
                        <input type="text" name="communication_platform" id="communication_platform"
                            class="form-control">
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-custom btn-primary" id="submitBtn">ส่งรายงาน</button>
                        <a href="/user-reports" class="btn btn-custom btn-secondary">ย้อนกลับ</a>
                    </div>
                </form>
            </div>
        </div>

        <!--กล่องขยายตัวอย่างภาพ-->
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel">ตัวอย่างภาพ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="modalImage" src="" alt="ตัวอย่างภาพขยาย" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <!--คำนวณเลขบัตรประชาชน (Export มาจาก public/js/thai-id-card.js)-->
        <script src="<?php echo e(asset('js/thai-id-card.js')); ?>"></script>

</body>

</html>

<script>
    //แสดงแจ้งเตือนเลขบัตรประชาชน
    document.addEventListener('DOMContentLoaded', function() {
        const idcardInput = document.getElementById('idcard'); //id ผู้ใช้งานกรอก
        const validationMessage = document.getElementById('idcard-validation-message'); //class แสดงข้อความเล็ก ๆ
        const submitBtn = document.getElementById('submitBtn'); //รับปุ่ม (ไว้ปิด 'ส่งข้อมูล' เมื่อกรอกเลขบัตรผิด)

        //เมื่อพิมพ์จะมีการเปลี่ยนค่า แจ้งเตือน
        idcardInput.addEventListener('input', function() { //'input' รับค่าจาก idcardInput(ตัวแปรบน)
            const idcard = this.value; // ผู้ใช้งานกรอกเข้ามา (this.value คือตัวแปร 'input'(เลข13หลัก))

            // ถ้ามีตัวอักษรที่ไม่ใช่ตัวเลข ให้แจ้งเตือนทันที
            if (!/^\d*$/.test(idcard)) {
                validationMessage.textContent = 'กรุณากรอกเฉพาะตัวเลขเท่านั้น'; //แสดงแจ้งเตือนเล็กๆ
                validationMessage.style.color = 'red'; //สีแจ้งเตือน
                submitBtn.disabled = true; //ปิดปุ่ม 'ส่งข้อมูล'
                return; //หยุดการทำงานทันที่ เมื่อมีตัวอักษร
            }
            //ตรวจสอบเลขเท่ากับ 13 หลัก
            if (idcard.length === 13) {
                //เรียกฟังก์ชันตรวจสอบเลขบัตรมาใช้
                if (ThaiIdCard.verify(idcard)) {
                    validationMessage.textContent = 'เลขบัตรประชาชนถูกต้อง'; //แสดงแจ้งเตือนเล็กๆ
                    validationMessage.style.color = 'green'; //สีแจ้งเตือน
                    submitBtn.disabled = false; //กล่อง'ส่งข้อมูล'ถูกเปิด
                } else {
                    validationMessage.textContent = 'เลขบัตรประชาชนไม่ถูกต้อง'; //แสดงแจ้งเตือนเล็กๆ
                    validationMessage.style.color = 'red'; //สีแจ้งเตือน
                    submitBtn.disabled = true; //ปิดปุ่ม 'ส่งข้อมูล'
                }
            }
            //ถ้าเลขไม่ใช่ 13 หลัก ให้ไม่แสดงข้อความ 
            else if (idcard.length > 0 && idcard.length < 13) {
                validationMessage.textContent = '';
                submitBtn.disabled = true; ///ปิดปุ่ม 'ส่งข้อมูล'
            }
            //กรณีลบข้อความไม่กรอกแล้ว ให้เปิด 'ส่งข้อมูลเหมือนเดิม' (idcard.length == 0)
             else {
                validationMessage.textContent = ''; //ไม่แสดงข้อความแจ้งเตือน
                submitBtn.disabled = false;
            }
        });

    });
</script>

<!--ขยาย modal ภาพ-->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const exampleImages = document.querySelectorAll('.example-img');
        const modalImage = document.getElementById('modalImage');
        const modalTitle = document.getElementById('imageModalLabel');

        exampleImages.forEach(function(image) { //วนตัวอย่างภาพเพื่อให้ตอบสนอง
            image.addEventListener('click', function() { //เมื่อคลิ๊กจะทำงานข้างใน
                const imgSrc = this.getAttribute('data-img-src'); //ดึงที่อยู่รูปภาพ
                const imgTitle = this.getAttribute('data-img-title'); //ดึง title ที่กำหนดไว้
                //ขยายภาพ
                modalImage.src = imgSrc;
                modalImage.alt = imgTitle;
                modalTitle.textContent =
                    imgTitle; //เปลี่ยน 'หลักฐานการบันทึกประจำวัน' แทน 'ตัวอย่าง'(imageModalLabel)
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

</html>
<?php /**PATH C:\xampp\htdocs\fraudcheck\resources\views/newreport.blade.php ENDPATH**/ ?>