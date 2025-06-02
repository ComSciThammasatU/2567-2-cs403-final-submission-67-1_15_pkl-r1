//ตรวจสอบเลขบัตรประชาชน
var ThaiIdCard = {
    verify: function (id) {
        //ถ้า id(ไม่มีค่า) || ไม่ถึง 13 หลัก || มีตัวอักษรปนมาด้วย
        if (!id || id.length !== 13 || !/^\d*$/.test(id)){
             return false; //ส่ง false
        }
        let sum = 0;
        //เก็บผลรวมแต่ละหลัก                               
        for (let i = 0; i < 12; i++) {                  
            sum += parseInt(id.charAt(i)) * (13 - i); //charAt(i) ดึงตัวเลขตามตำแหน่ง i เช่น 1*(13-0)+4*(13-1)+1*(13-2)+..... 
        }

        //11-(นำผลรวม%11) , %10 คือให้ได้หลักหน่วย
        let check = (11 - (sum % 11)) % 10;
        return check === parseInt(id.charAt(12)); //ตรวจสอบผลลัพธ์กับหลัก 13ของเลขบัตร
    }
};

//1 4 1 9 9 0 1 8 1 3 3 8 1
//id.charAt(0) = 1 ,
//id.charAt(1) = 4 ,
//id.charAt(2) = 1 ,
//id.charAt(3) = 9 ,
    //...
//id.charAt(11) = 8 ,