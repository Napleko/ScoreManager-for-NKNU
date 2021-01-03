<!--防止未授權訪問-->
<?php include("rejectAccessAdmin.php"); ?>

<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/Styles/am.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <h1>帳號管理</h1>
    <div>
        <form class = 'newUser' action="addAccount.php" method="POST">
            新增帳號：
            <select class = 'newUser' id = 'identity'>
                <option value = 'none'>請選擇身分</option>
                <option value = 'pr'>教授</option>
                <option value = 'st'>學生</option>
            </select>
            <input type = 'text' class = 'newUser' name = 'account' placeholder = '帳號'>
            <input type = 'password' class = 'newUser' name = 'pswd' placeholder = '密碼'>
            <input type = 'text' class = 'newUser' name = 'name' placeholder = '名稱'>
            <input type = 'button' class = 'newUser' name = 'addAccount' value = '新增帳號'>
        </form>
      <script type="text/javascript">
      $(document).ready(function() {
          $('[name = "addAccount"]').click(function() { 
              $.ajax({
                  type: "POST", //傳送方式
                  url: "addAccount.php", //傳送目的地
                  dataType: "json", //資料格式
                  data: { //傳送資料
                      identity: $("#identity").val(),
                      name: $('[name = "name"]').val(),
                      account: $('[name = "account"]').val(),
                      pswd: $('[name = "pswd"]').val()
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
              })
          })
      });
      </script>
	</div>
    <!--帳號列-->
    <table id='accountList'>
        <tr>
            <th colspan="6">帳號列表</th>
        </tr>
        <tr class='alHead'>
            <td>身分</td>
            <td>帳號</td>
            <td>名字</td>
            <td>密碼</td>
            <td>修改密碼</td>
            <td>刪除帳號</td>
        </tr>
    </table>
</body>
</html>

<script>
    function showAccounts(uID,act,pswd,name,row) {
        //帳號列表
        var account_List=document.getElementById('accountList');
        var newRow = document.createElement("tr");
        account_List.appendChild(newRow);
        //身分
        var uid = document.createElement("td");
        switch(uID){
            case 'st':
                uid.innerHTML = "學生";
                break;
            case 'pr':
                uid.innerHTML = "教授";
                break;
            case 'op':
                uid.innerHTML = "管理員";
                break;
            default:
                uid.innerHTML = "錯誤";
        }
        newRow.appendChild(uid);
        //帳號
        var account = document.createElement("td");
        account.innerHTML = act;
        newRow.appendChild(account);
        //名字
        var showName = document.createElement("td");
        showName.innerHTML = name;
        newRow.appendChild(showName);
        //密碼
        var password = document.createElement("td");
        password.innerHTML = pswd;
        newRow.appendChild(password);
        //修改
        var btnContainer2 = document.createElement("td");
        var chText = document.createElement("input");
        chText.type = 'text';
        chText.style = "width:160px;height:30px;margin: auto;font-size: 18px;";
        chText.id = "changePassword"+row;
        chText.placeholder = '新密碼';
        var chBtn = document.createElement("input");
        chBtn.type = 'button';
        chBtn.onclick=function() { 
            changePassword(row);
        };
        chBtn.value = "修改";
        chBtn.style = "width:50px;height:30px;margin-left: 20px;margin-left: 20px;font-size: 18px;";
        btnContainer2.appendChild(chText);
        btnContainer2.appendChild(chBtn);
        newRow.appendChild(btnContainer2);
        //刪除
        var btnContainer = document.createElement("td");
        if(row!=0){
            var rmBtn = document.createElement("input");
            rmBtn.type = 'button'; 
            rmBtn.onclick=function() { 
                removeAccount(row);
            };

            rmBtn.value = "刪除";
            rmBtn.style = "width:60px;height:30px;margin: auto;font-size: 18px;";
            btnContainer.appendChild(rmBtn);
        }
        newRow.appendChild(btnContainer);
    }
    function removeAccount(theIndex) { 
            $.ajax({
                type: "POST", //傳送方式
                url: "removeAccount.php", //傳送目的地
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
    function changePassword(theIndex) {
        $.ajax({
                type: "POST", //傳送方式
                url: "changePassword.php", //傳送目的地
                dataType: "json", //資料格式
                data: { //傳送資料
                    index: theIndex,
                    newPassword: $("#changePassword"+theIndex).val()
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
            })
    }
</script>

<?php
$csvfile = './user_identity.csv';

// Read .CSV
$file = fopen($csvfile, "r");
//$linesCount = count(file($csvfile));
$row = 0;
while ($data = fgetcsv($file, 1000, ",")) {
    $num = count($data);
    echo "<script type='text/javascript'>showAccounts('$data[0]','$data[1]','$data[2]','$data[3]','$row');</script>";
    $row++;
}
fclose($file);
?>
