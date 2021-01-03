<!--防止未授權訪問-->
<?php include("Admin/rejectAccessAdmin.php"); ?>

<html>
<head>
    <title>管理員系統</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="Styles/admin.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <h1>管理員系統</h1>
    <div class = 'operation'>
    <div class = 'menu'>
        <button onclick="AM()">帳戶管理</button> <br/>
        <button onclick="CM()">課程管理</button>
        <div>
            <h2>學生管理</h2>
            <button onclick="SM()">學生資訊</button> <br/>
            <button onclick="SC()">選修課程</button> <br/>
            <button onclick="ES()">修改課程成績</button> <br/>
            <button onclick="SS()">產生成績單</button> <br/>
        </div>
        <button name='logout' class='logout'>登出</button>
    </div>
    <iframe class = 'page' id='am'></iframe>
    </div>

    </iframe>
    <!--登出帳戶功能-->
    <script type="text/javascript">
    $(document).ready(function() {
          $('[name = "logout"]').click(function() { 
              $.ajax({
                  type: "POST", //傳送方式
                  url: "logout.php", //傳送目的地
                  dataType: "json", //資料格式
                  data: { //傳送資料
                    submission: 'true'
                  },
                  success: function(data) {
                    if (data.success === true) {
                      alert('已登出');
                      window.location.href = `index.html`;
                    }
                    else {
                      alert(data.success);
                    }
                  },
                  error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert(XMLHttpRequest.readyState+", "+textStatus+", "+errorThrown);
                    console.warn(XMLHttpRequest.responseText);
                  }
              })
          })
      });
      // Show up Acount Management
      function AM() {
            var showHtml = document.getElementById("am");
            showHtml.src = '/Admin/AccountManager.php';
      }
      function CM(){
        var showHtml = document.getElementById("am");
            showHtml.src = '/Classes/ClassManager.php';
      }
      function ES() {
        var showHtml = document.getElementById("am");
            showHtml.src = '/Admin/editScoreAdmin.php';
      }
      function SC(){
        var showHtml = document.getElementById("am");
            showHtml.src = '/Classes/showStudentClass.php';
      }
      function SM(){
        var showHtml = document.getElementById("am");
            showHtml.src = '/Student/StudentManager.php';
      }
      function SS(){
        var showHtml = document.getElementById("am");
            showHtml.src = '/Student/studentSelect.php';
      }
    </script>
</body>

</html>