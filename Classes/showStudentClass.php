<!--防止未授權訪問-->
<?php include("../Admin/rejectAccessAdmin.php"); ?>

<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/Styles/cm.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <h1>學生選修課程管理</h1>
    <div>
    <form action="getStudentClass.php" method="POST">
        <select id = 'readStudent'>
        </select>
        <input type = 'button' name='readClass' value = '選修課程'>
    </form>
    <script type="text/javascript">
      $(document).ready(function() {
            $('[name = "readClass"]').click(function() { 
                var childs = document.getElementById('readStudent').children.length;
                if(childs==0){ 
                    alert("沒有學生"); 
                }
                else{
                    $.ajax({
                        type: "POST", //傳送方式
                        url: "getStudentClass.php", //傳送目的地
                        dataType: "json", //資料格式
                        data: { //傳送資料
                            student: $('#readStudent').val()
                        },
                        success: function(data) {
                            if (data.success === true) {
                                var st = document.getElementById('studentToAdd');
                                st.innerHTML = $('#readStudent').val();
                                //顯示選修課程
                                var classList = document.getElementById('classList');
                                var child = classList.lastElementChild;
                                while (classList.childElementCount>1) { 
                                    classList.removeChild(child); 
                                    child = classList.lastElementChild; 
                                } 
                                let i;
                                for(i=0;i<data.classes.length;i++){
                                    let classData = data.classes[i];
                                    showClassData(classData[0],classData[1],classData[2],classData[3],classData[4],classData[5],data.account);
                                }
                                //顯示所有課程
                                var classesList = document.getElementById('readClasses');
                                var child = classesList.lastElementChild;
                                while (classesList.childElementCount>1) { 
                                    classesList.removeChild(child); 
                                    child = classesList.lastElementChild; 
                                } 
                                for(i=0;i<data.allClasses.length;i++){
                                    let classData = data.allClasses[i];
                                    addClassOption(classData[0],classData[1],classData[2],classData[3],classData[4],classData[5]);
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
    <!--課程列-->
    <table id='classList'>
        <tr>
            <th colspan="7">課程列表</th>
        </tr>
        <tr class='alHead'>
            <td>學期</td>
            <td>代碼</td>
            <td>名稱</td>
            <td>教授</td>
            <td>學分</td>
            <td>類型</td>
            <td>刪除</td>
        </tr>
    </table>
    <!--新增選修課程-->
    <br/>
    <form action="addStudentClass.php" method="POST">
        新增選修課程:<p id='studentToAdd'></p>
        <select id = 'readClasses'>
        </select>
        <input type = 'button' name='addStudentClass' value = '新增選修課程'>
    </form>
    <script type="text/javascript">
    //
      $(document).ready(function() {
            $('[name = "addStudentClass"]').click(function() { 
                var childs = document.getElementById('readStudent').children.length;
                if(childs==0){ 
                    alert("沒有學生"); 
                }
                else{
                    var st = document.getElementById('studentToAdd');
                    $.ajax({
                        type: "POST", //傳送方式
                        url: "addStudentClass.php", //傳送目的地
                        dataType: "json", //資料格式
                        data: { //傳送資料
                            student: st.innerHTML,
                            class: $('#readClasses').val()
                        },
                        success: function(data) {
                            if (data.success === true) {
                                alert('新增完成');
                                window.location.reload();
                            }
                            else {
                                alert("新增失敗");
                            }
                        }
                    })
                }
            })
      });
      function addClassOption( Semester , Code , Name , Professor , Credit , Category) {
        var class_List = document.getElementById('readClasses');
        var newOption = document.createElement('option');
        newOption.value = Code;
        var classSemester;   //課程學期
        if(Semester.slice(3)==1){
            classSemester = Semester.slice(0,3)+" 上學期";
        }
        else {
            classSemester = Semester.slice(0,3)+" 下學期";
        }

        var classCategory;     //課程種類
        if(Category=='A') classCategory = "必修";
        else classCategory = "選修";
        newOption.innerHTML = classSemester+" "+Name+" 教授:"+Professor+" 學分:"+Credit+" 類型："+classCategory;
        class_List.appendChild(newOption);
    }
      //Show class data
      function showClassData( Semester , Code , Name , Professor , Credit , Category, st) {
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
        var classcode = document.createElement("td");     //課程代碼
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

        //移除
        var btnContainer = document.createElement("td");
        var rmBtn = document.createElement("input");
        rmBtn.type = 'button'; 
        rmBtn.onclick=function() { 
            removeClassChoosen(Code,st);
        };

        rmBtn.value = "移除";
        rmBtn.style = "width:60px;height:30px;margin: auto;font-size: 18px;";
        btnContainer.appendChild(rmBtn);
        newRow.appendChild(btnContainer);
    }
     
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
    </div>
</body>
</html>

<script>
    function removeClassChoosen(code,theStudent) { 
        $.ajax({
            type: "POST", //傳送方式
            url: "removeStudentClass.php", //傳送目的地
            dataType: "json", //資料格式
            data: { //傳送資料
                Code: code,
                Student: theStudent
            },
            success: function(data) {
                if (data.success === true) {
                    alert("移除成功");
                    window.location.reload();
                }
                else {
                    alert("移除失敗");
                }
            }
        })
    }

    function addStudentOption(name,account) {
        var studentList=document.getElementById('readStudent');
        var newOption = document.createElement("option");
        newOption.value = account;
        newOption.innerHTML = name+"("+account+")";
        studentList.appendChild(newOption);
    }


</script>
<?php
$csvfile = '../Admin/user_identity.csv';

$file = fopen($csvfile, "r");
$row = 0;

while ($data = fgetcsv($file, 1000, ",")) {
    if($data[0]==='st'){
        echo "<script type='text/javascript'>addStudentOption('$data[3]','$data[1]');</script>";
    }
    $row++;
}
fclose($file);
?>
