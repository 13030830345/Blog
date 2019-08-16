<?php include 'config.php' ?>
<!doctype html>
<html lang="zh-CN">

<head>
  <meta charset="utf-8">
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>404错误！很抱歉，您要找的页面不存在 - | 喵窝 | 我的个人博客 | Powered By Siner</title>
  <?php include 'tool.php' ?>
  <link rel="stylesheet" type="text/css" href="/css/style.css">
  <style type="text/css">
    .panel {
      padding: 80px 20px 0px;
      min-height: 500px;
      cursor: default;
    }

    .text-center {
      margin: 0 auto;
      text-align: center;
      border-radius: 10px;
      max-width: 900px;
      -moz-box-shadow: 0px 0px 5px rgba(0, 0, 0, .3);
      -webkit-box-shadow: 0px 0px 5px rgba(0, 0, 0, .3);
      box-shadow: 0px 0px 5px rgba(0, 0, 0, .1);

    }

    .float-left {
      float: left !important;
    }

    .float-right {
      float: right !important;
    }

    img {
      border: 0;
      vertical-align: bottom;
    }

    h2 {
      padding-top: 20px;
      font-size: 20px;
    }

    .padding-big {
      padding: 20px;
    }

    .alert {
      border-radius: 5px;
      padding: 15px;
      border: solid 1px #ddd;
      background-color: #f5f5f5;
    }
  </style>
</head>

<body class="user-select">
  <?php
  include 'header.php'
  ?>
  <section class="container">
    <div class="panel">
      <div class="text-center">
        <h2>
          <strong>404错误！很抱歉，您要找的页面不存在</strong>
        </h2>
        <div class="padding-big"> <a href="/index.php" class="btn btn-primary">返回首页</a></div>
      </div>
    </div>
  </section>
  </section>
  <?php include 'footer.php';
  include 'live2d.php' ?>
</body>

</html>