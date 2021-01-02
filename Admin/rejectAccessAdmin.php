<script type="text/javascript">
    function rejectAccess(){
        alert("你沒有管理員權限!");
        window.location.href=`/index.html`;
    }
</script>

<?php session_start();
    // 權限驗證,沒有管理員權限則跳轉至首頁
    if($_SESSION['auth']!='a') {
        echo "<script type='text/javascript'>rejectAccess();</script>";
    }
?>