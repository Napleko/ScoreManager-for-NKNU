<!--防止未授權訪問-->
<?php include("../Admin/rejectAccessAdmin.php"); ?>

<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/Styles/cm.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <h1>課程管理</h1>
    <div>
    <form action="showClass.php" method="POST">
        <select id = 'readSemester'>
            <option value = 'all'>所有學期</option>
        </select>
        <input type = 'button' name='readClass' value = '瀏覽課程'>
    </form>
    <script type="text/javascript">
      $(document).ready(function() {
            $('[name = "readClass"]').click(function() { 
                var childs = document.getElementById('readSemester').children.length;
                if(childs==1){ 
                    alert("沒有課程"); 
                }
                else{
                    $.ajax({
                        type: "POST", //傳送方式
                        url: "showClass.php", //傳送目的地
                        dataType: "json", //資料格式
                        data: { //傳送資料
                            semester: $('#readSemester').val()
                        },
                        success: function(data) {
                            if (data.success === true) {
                                var class_List = document.getElementById('classList');
                                var child = class_List.lastElementChild;
                                while (class_List.childElementCount>1) { 
                                    class_List.removeChild(child); 
                                    child = class_List.lastElementChild; 
                                } 
                                let i;
                                for(i=0;i<data.classes.length;i++){
                                    let classData = data.classes[i];
                                    showClassData(classData[0],classData[1],classData[2],classData[3],classData[4],classData[5],classData[6]);
                                }
                            }
                            else {
                                alert("讀取失敗");
                            }
                        }
                    })
                }
            })
      });
      </script>
    </div>
    <div>
    <form action="addClass.php" method="POST">
            新增課程：
            <input type = 'number' name = 'classSemester' placeholder = '學年'>
            <select name = 'classType'>
                <option value = '1'>上學期</option>
                <option value = '2'>下學期</option>
            </select>
            <input type = 'text' name = 'classCode' placeholder = '代碼'>
            <input type = 'text' name = 'className' placeholder = '名稱'>
            <input type = 'text' name = 'classProfessor' placeholder = '授課教授'>
            <input type = 'number' name = 'classCredit' placeholder = '學分'>
            <select name = 'classCategory'>
                <option value = ''>課程類型</option>
                <option value = 'A'>必修</option>
                <option value = 'B'>選修</option>
            </select>
            <input type = 'button' class = 'newUser' name = 'addClass' value = '新增課程'>
    </form>
    <!--課程列-->
    <table id='classList'>
        <tr>
            <th colspan="8">課程列表</th>
        </tr>
        <tr class='alHead'>
            <td>學期</td>
            <td>代碼</td>
            <td>名稱</td>
            <td>教授</td>
            <td>學分</td>
            <td>類型</td>
            <td>刪除</td>
            <td>修改</td>
        </tr>
    </table>
      <script type="text/javascript">
      function showClassData( Semester , Code , Name , Professor , Credit , Category, row) {
        var class_List = document.getElementById('classList');
        var newRow = document.createElement("tr");
        class_List.appendChild(newRow);

        var classSemester = document.createElement("td");   //課程學期
        if(Semester.slice(3)==1){
            classSemester.innerHTML = Semester.slice(0,3)+" 上學期";
        }
        else {
            classSemester.innerHTML = Semester.slice(0,3)+" 下學期";
        }
        newRow.appendChild(classSemester);
        var classcode = document.createElement("td");     //課程代碼起
        classcode.innerHTML = Code;
        newRow.appendChild(classcode);
        var classname = document.createElement("td");       //課程名稱
        classname.innerHTML = Name;
        newRow.appendChild(classname);
        var classprofessor = document.createElement("td");     //課程教授
        classprofessor.innerHTML = Professor;
        newRow.appendChild(classprofessor);
        var classcredit = document.createElement("td");     //課程學分
        classcredit.innerHTML = Credit;
        newRow.appendChild(classcredit);
        var classCategory = document.createElement("td");     //課程種類
        if(Category=='A') classCategory.innerHTML = "必修";
        else classCategory.innerHTML = "選修";
        newRow.appendChild(classCategory);

        //刪除
        var btnContainer = document.createElement("td");
        var rmBtn = document.createElement("input");
        rmBtn.type = 'button'; 
        rmBtn.onclick=function() { 
            removeClass(row);
        };

        rmBtn.value = "刪除";
        rmBtn.style = "width:60px;height:30px;margin: auto;font-size: 18px;";
        btnContainer.appendChild(rmBtn);
        newRow.appendChild(btnContainer);
        //修改
        var btnContainer2 = document.createElement("td");
        var chBtn = document.createElement("input");
        chBtn.type = 'button'; 
        chBtn.onclick=function() { 
            setUpChangeClass(Code , Name , Professor , Credit , Category);
        };

        chBtn.value = "修改";
        chBtn.style = "width:60px;height:30px;margin: auto;font-size: 18px;";
        btnContainer2.appendChild(chBtn);
        newRow.appendChild(btnContainer2);
    }
      $(document).ready(function() {
          $('[name = "addClass"]').click(function() { 
              if($('[name = "classSemester"]').val()=='') alert("請輸入學年");
              else{$.ajax({
                  type: "POST", //傳送方式
                  url: "addClass.php", //傳送目的地
                  dataType: "json", //資料格式
                  data: { //傳送資料
                      semester: $('[name = "classSemester"]').val()+$('[name = "classType"]').val(),
                      code: $('[name = "classCode"]').val(),
                      name: $('[name = "className"]').val(),
                      professor: $('[name = "classProfessor"]').val(),
                      credit: $('[name = "classCredit"]').val(),
                      category: $('[name = "classCategory"]').val()
                  },
                  success: function(data) {
                    if (data.success === true) {
                      alert("新增成功");
                      window.location.reload();
                    }
                    else {
                      alert("新增失敗");
                    }
                  }
              })}
          })
      });

      function setUpChangeClass(Code , Name , Professor , Credit , Category){
            var showOldCode = document.getElementById('oldCode');
            showOldCode.innerHTML = Code;
            var newCode = document.getElementById('classCode2');
            newCode.value = Code;
            var newName = document.getElementById('className2');
            newName.value = Name;
            var newProfessor = document.getElementById('classProfessor2');
            newProfessor.value = Professor;
            var newCredit = document.getElementById('classCredit2');
            newCredit.value = Credit;
            var newCategory = document.getElementById('classCategory2');
            newCategory.value = Category;
      }
      </script>
    <form action="changeClass.php" method="POST">
            舊代碼：<label id = 'oldCode'></label>
            <input type = 'text' id = 'classCode2' placeholder = '新代碼'>
            <input type = 'text' id = 'className2' placeholder = '名稱'>
            <input type = 'text' id = 'classProfessor2' placeholder = '授課教授'>
            <input type = 'number' id = 'classCredit2' placeholder = '學分'>
            <select id = 'classCategory2'>
                <option value = ''>課程類型</option>
                <option value = 'A'>必修</option>
                <option value = 'B'>選修</option>
            </select>
            <input type = 'button' class = 'newUser' id = 'changeClass' value = '修改課程'>
    </form>
    <script type="text/javascript">
    $(document).ready(function() {
          $('#changeClass').click(function() { 
                var oldCode = document.getElementById('oldCode'); 

                if(oldCode.innerHTML==''||$('#classCode2').val()==''||$('#className2').val()==''||
                $('#classProfessor2').val()==''||$('#classCredit2').val()==''||$('#classCategory2').val()=='') {
                    alert("資料有誤");
                }
                else{
                    $.ajax({
                        type: "POST", //傳送方式
                        url: "changeClass.php", //傳送目的地
                        dataType: "json", //資料格式
                        data: { //傳送資料
                            oldCode: oldCode.innerHTML,
                            newCode: $('#classCode2').val(),
                            name: $('#className2').val(),
                            professor: $('#classProfessor2').val(),
                            credit: $('#classCredit2').val(),
                            category: $('#classCategory2').val()
                        },
                        success: function(data) {
                        if (data.success === true) {
                            alert("修改成功");
                            window.location.reload();
                        }
                        else {
                            alert("修改失敗");
                        }
                    }
                })}
          })
    });
    </script>
    </div>
</body>
</html>

<script>
    function removeClass(theIndex) { 
        $.ajax({
            type: "POST", //傳送方式
            url: "removeClass.php", //傳送目的地
            dataType: "json", //資料格式
            data: { //傳送資料
                index: theIndex
            },
            success: function(data) {
                if (data.success === true) {
                    alert("刪除成功");
                    window.location.reload();
                }
                else {
                    alert("刪除失敗");
                }
            }
        })
    }

    function addSemesterOption(semester) {
        var semester_List=document.getElementById('readSemester');
        var newOption = document.createElement("option");
        newOption.value = semester;
        if(semester.slice(3)==1){
            newOption.innerHTML = semester.slice(0,3)+" 上學期";
        }
        else{
            newOption.innerHTML = semester.slice(0,3)+" 下學期";
        }
        semester_List.appendChild(newOption);
    }


</script>
<?php
$csvfile = './class.csv';
// Read .CSV
$file = fopen($csvfile, "r");
//$linesCount = count(file($csvfile));
$row = 0;

$semesterArray = array();
$arraySize = 0;
while ($data = fgetcsv($file, 1000, ",")) {
    $semester = $data[0];
    $hasExisted = false;
    foreach($semesterArray as $value){
        if($semester==$value){
            $hasExisted = true;
            break;
        }
    }
    if(!$hasExisted){
        echo "<script type='text/javascript'>addSemesterOption('$data[0]');</script>";
        $semesterArray[$arraySize++] = $semester;
    }
    
    $row++;
}
fclose($file);
?>
