各檔案功能:
首頁：index.html
管理員頁：administrator.php
登出(後端)：logout.php
以錯誤方式進入登出頁時使用：logoutEXC.js
驗證身分(後端)：authorize.php
帳戶管理分頁：AccountManager.php
驗證網頁存取權(後端)(確認是否為管理員)：rejectAccessAdmin.php
新增帳號(後端)：addAccount.php
刪除帳號(後端)：removeAccount.php
修改密碼(後端)：changePassword.php
課程管理分頁：ClassManager.php
新增課程(後端)：addClass.php
刪除課程(後端)：removeClass.php
修改課程(後端)：changeClass.php
動態顯示課程(後端)：showClass.php
學生成績單頁：studentSelect.php
取得學生學期成績(後端)：getSemesterScore.php

管理員頁：
各功能對應的網頁內嵌於id='am'的iframe
按各功能按鈕會改變其src值

帳戶管理分頁：
-動態讀取帳戶資料並以表格顯示
-新增帳號
-刪除帳號
-修改密碼

課程管理分頁：
-動態讀取課程資訊
-新增課程
-刪除課程
-修改課程

學生成績單頁：
-取得學生列表
-產生學生學期成績單

安全性：
登入時php建立session,產生session變數auth,進入網頁時根據auth判斷用戶權限
登出或關閉瀏覽器時解除session

藉由網址直接呼叫檔案時,藉由"Admin/rejectAccessAdmin.php"的確認auth值,沒有權限的用戶會被送回首頁
