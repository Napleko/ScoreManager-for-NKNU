<!--防止未授權訪問-->
<?php include("../Admin/rejectAccessAdmin.php"); ?>

<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/Styles/cm.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <h1>學生資訊管理</h1>
    <div>
    <!--課程列-->
    <table id='classList'>
        <tr>
            <th colspan="4">學生列表</th>
        </tr>
        <tr class='alHead'>
            <td>學號</td>
            <td>姓名</td>
            <td>入學年分</td>
            <td>修改</td>
        </tr>
    </table>
      <script type="text/javascript">
      function showStudentData( Code , Name , Time, row) {
        var stList = document.getElementById('classList');
        var newRow = document.createElement("tr");
        stList.appendChild(newRow);
        //學號
        var code = document.createElement("td");   
        code.innerHTML = Code;
        newRow.appendChild(code);
        //姓名
        var name = document.createElement("td");
        name.innerHTML = Name;
        newRow.appendChild(name);
        //入學年分
        var time = document.createElement("td");
        if(Time.slice(3)==1){
            time.innerHTML = Time.slice(0,3)+" 上學期";
        }
        else{
            time.innerHTML = Time.slice(0,3)+" 下學期";
        }
        newRow.appendChild(time);

        //修改
        var btnContainer2 = document.createElement("td");
        var chBtn = document.createElement("input");
        chBtn.type = 'button'; 
        chBtn.onclick=function() { 
            setUpChangeStudent(Code , Name , Time, row);
        };

        chBtn.value = "修改";
        chBtn.style = "width:60px;height:30px;margin: auto;font-size: 18px;";
        btnContainer2.appendChild(chBtn);
        newRow.appendChild(btnContainer2);
    }
    
      function setUpChangeStudent(Code , Name , Time, row){
            var showOldCode = document.getElementById('oldCode');
            showOldCode.innerHTML = Code;
            var newCode = document.getElementById('classCode2');
            newCode.value = Code;
            var newName = document.getElementById('className2');
            newName.value = Name;
            var newProfessor = document.getElementById('classProfessor2');
            newProfessor.value = Time.slice(0,3);
            var newCategory = document.getElementById('classCategory2');
            newCategory.value = Time.slice(3);
      }
      </script>
      <!--學生修改-->
      </br>
    <form action="changeStudent.php" method="POST">
            舊學號：<label id = 'oldCode'></label>
            <input type = 'text' id = 'classCode2' placeholder = '新學號'>
            <input type = 'text' id = 'className2' placeholder = '姓名'>
            <input type = 'number' id = 'classProfessor2' placeholder = '學年'>
            <select id = 'classCategory2'>
                <option value = '1'>上學期</option>
                <option value = '2'>下學期</option>
            </select>
            <input type = 'button' class = 'newUser' id = 'changeClass' value = '修改資訊'>
    </form>
    <script type="text/javascript">
    $(document).ready(function() {
          $('#changeClass').click(function() { 
                var oldCode = document.getElementById('oldCode'); 

                if(oldCode.innerHTML==''||$('#classCode2').val()==''||$('#className2').val()==''||
                $('#classProfessor2').val()=='') {
                    alert("資料有誤");
                }
                else{
                    $.ajax({
                        type: "POST", //傳送方式
                        url: "changeStudent.php", //傳送目的地
                        dataType: "json", //資料格式
                        data: { //傳送資料
                            oldCode: oldCode.innerHTML,
                            newCode: $('#classCode2').val(),
                            name: $('#className2').val(),
                            semester: $('#classProfessor2').val()+$('#classCategory2').val(),
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

<?php
$csvfile = '../Admin/user_identity.csv';
// Read .CSV
$file = fopen($csvfile, "r");
$row = 0;

while ($data = fgetcsv($file, 1000, ",")) {
    if($data[0]==='st'){
        echo "<script type='text/javascript'>showStudentData('$data[1]','$data[3]','$data[4]','$row');</script>";
    }
    $row++;
}
fclose($file);
?>
