<?php include '../config.php' ?>
<!doctype html>
<html lang="zh-CN">

<head>
  <meta charset="utf-8">
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>喵窝博客管理系统</title>
  <?php include '../tool.php'; ?>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body class="user-select">
  <section class="container-fluid">
    <?php include 'header.php' ?>
    <div class="row">
      <?php include 'aside.php' ?>
      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-lg-10 col-md-offset-2 main" id="main">
        <h1 class="page-header">信息总览</h1>
        <div class="row placeholders">
          <div class="col-xs-6 col-sm-3 placeholder">
            <h4>文章</h4>
            <span class="text-muted"><?php echo $conn->query("SELECT COUNT(*) FROM article")->fetch_assoc()['COUNT(*)'] ?> 篇</span>
          </div>
          <div class="col-xs-6 col-sm-3 placeholder">
            <h4>评论</h4>
            <span class="text-muted"><?php echo $conn->query("SELECT COUNT(*) FROM comment")->fetch_assoc()['COUNT(*)'] ?> 条</span>
          </div>
          <div class="col-xs-6 col-sm-3 placeholder">
            <h4>友链</h4>
            <span class="text-muted"><?php echo $conn->query("SELECT COUNT(*) FROM links")->fetch_assoc()['COUNT(*)'] ?> 条</span>
          </div>
          <div class="col-xs-6 col-sm-3 placeholder">
            <h4>访问量</h4>
            <span class="text-muted"><?php echo $conn->query("SELECT sum(view) FROM article")->fetch_assoc()['sum(view)'] ?></span>
          </div>
        </div>
        <h1 class="page-header">状态</h1>
        <div class="table-responsive">
          <table class="table table-striped table-hover">
            <tbody>
              <tr>
                <td>登录者: <span><?php echo $username ?></span>，这是您第 <span><?php echo $row_U['login_times'] ?></span> 次登录</td>
              </tr>
              <tr>
                <td>上次登录时间: <?php echo $login_time ?> , 上次登录IP: <?php echo $login_ip ?></td>
              </tr>
            </tbody>
          </table>
        </div>
        <h1 class="page-header">系统信息</h1>
        <div class="table-responsive">
          <table class="table table-striped table-hover">
            <thead>
              <tr> </tr>
            </thead>
            <tbody>
              <tr>
                <td>管理员个数:</td>
                <td>1 人（Only One）</td>
                <td>服务器软件:</td>
                <td><?php echo apache_get_version() ?></td>
              </tr>
              <tr>
                <td>浏览器:</td>
                <td><?php echo $row_U['login_browse'] ?></td>
                <td>PHP版本:</td>
                <td><?php echo PHP_VERSION ?></td>
              </tr>
              <tr>
                <td>操作系统:</td>
                <td><?php echo $row_U['login_os'] ?></td>
                <td>PHP运行方式:</td>
                <td><?php echo ucwords(php_sapi_name()) ?></td>
              </tr>
              <tr>
                <td>登录者IP:</td>
                <td><?php echo $row_U['login_ip'] ?></td>
                <td>MYSQL版本:</td>
                <td><?php
                    echo $conn->query("select VERSION()")->fetch_assoc()['VERSION()'];
                    ?></td>
              </tr>
              <tr>
                <td>程序编码:</td>
                <td><?php
                    $encode = mb_detect_encoding("编码", array("ASCII", 'UTF-8', "GB2312", "GBK", 'BIG5'));
                    echo $encode; ?></td>
                <td>当前时间:</td>
                <td><?php date_default_timezone_set("Etc/GMT-8");
                    echo date("Y-m-d H:i:s"); ?></td>
              </tr>
            </tbody>
            <tfoot>
              <tr></tr>
            </tfoot>
          </table>
        </div>
        <footer>
          <h1 class="page-header">程序信息</h1>
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <tbody>
                <tr>
                  <td><span style="display:inline-block; width:8em">版权所有</span> POWERED BY SINER</td>
                </tr>
                <tr>
                  <td><span style="display:inline-block;width:8em">页面加载时间</span> PROCESSED IN <?php echo time() - $startTime + 0.1 . "s"; ?> SECONDS </td>
                </tr>
                <tr>
                  <td><span style="display:inline-block; width:8em">站点支持：</span> <a href="http://www.scmanga.cn/" target="_blank">S.C 动漫社区</a></td>
                </tr>
              </tbody>
            </table>
          </div>
        </footer>
      </div>
    </div>
  </section>
  <?php include 'modal.php' ?>
</body>

</html>