<?php $startTime = time(); ?>
<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/css/bootstrap-switch.min.css">
<link rel="stylesheet" type="text/css" href="/css/iziToast.min.css">
<link rel="stylesheet" type="text/css" href="/css/nprogress.css">
<link rel="stylesheet" type="text/css" href="/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="/css/cropper.min.css">
<link rel="stylesheet" type="text/css" href="/css/avatar.css">
<link rel="stylesheet" href="/live2d/css/live2d.css" />
<link rel="apple-touch-icon-precomposed" href="/images/icon.png">
<link rel="shortcut icon" href="/favicon.ico">
<meta name="keywords" content="<?php echo WebSite_Keywords ?>">
<meta name="description" content="<?php echo WebSite_Description ?>">
<script src="/js/jquery-2.1.4.min.js"></script>
<script src="/js/nprogress.js"></script>
<script src="/js/jquery.lazyload.min.js"></script>
<!--[if gte IE 9]>
  <script src="js/jquery-1.11.1.min.js" type="text/javascript"></script>
  <script src="js/html5shiv.min.js" type="text/javascript"></script>
  <script src="js/respond.min.js" type="text/javascript"></script>
  <script src="js/selectivizr-min.js" type="text/javascript"></script>
<![endif]-->
<?php
$servername = "localhost";
$sql_username = "root";
$qsl_password = "";
$dbname = "blog";

// 创建连接
$conn = new mysqli($servername, $sql_username, $qsl_password, $dbname);
$conn->query("set names utf8");
// Check connection
if ($conn->connect_error) {
  die("连接失败: " . $conn->connect_error);
}
$Toast = "";
$title = "";
$mes = "";
include 'config_read.php';
?>