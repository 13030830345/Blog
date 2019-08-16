<?php include '../config.php' ?>
<!doctype html>
<html lang="zh-CN">

<head>
  <meta charset="utf-8">
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>登录记录 - <?php echo WebSite_Title ?>博客管理系统</title>
  <?php include '../tool.php'; ?>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body class="user-select">
  <section class="container-fluid">
    <?php include 'header.php';
    $page_num = $conn->query("SELECT COUNT(*) FROM login_log")->fetch_assoc()['COUNT(*)'];
    $log_num = $page_num;
    $amount = 15;
    if ($page_num / $amount > (int)($page_num / $amount))
      $page_num =  (int)($page_num / $amount) + 1;
    else
      $page_num = (int)$page_num / $amount;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    if ($page > $page_num || $Toast == "NewTitle") $page = $page_num;
    $sql = "SELECT * FROM login_log ORDER BY `login_log`.`time` DESC LIMIT " . ($page - 1) * $amount . "," . $amount;
    $result = $conn->query($sql);
    ?>
    <div class="row">
      <?php include 'aside.php' ?>
      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-lg-10 col-md-offset-2 main" id="main">
        <!-- <h1 class="page-header">操作</h1>
        <ol class="breadcrumb">
          <li><a>清除所有登录记录</a></li>
        </ol> -->
        <h1 class="page-header">管理 <span class="badge"><?php echo $log_num ?></span></h1>
        <div class="table-responsive">
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th><span class="glyphicon glyphicon-th-large"></span> <span class="visible-lg">日志ID</span></th>
                <th><span class="glyphicon glyphicon-user"></span> <span class="visible-lg">用户</span></th>
                <th><span class="glyphicon glyphicon-time"></span> <span class="visible-lg">时间</span></th>
                <th><span class="glyphicon glyphicon-adjust"></span> <span class="visible-lg">IP</span></th>
                <th><span class="glyphicon glyphicon-remove"></span> <span class="visible-lg">删除</span></th>
              </tr>
            </thead>
            <tbody>
              <?php while ($result && $row = $result->fetch_assoc()) {
                $row_U = $conn->query("SELECT username_t,login_ip FROM user_center WHERE `id` = " . $row['user_id'])->fetch_assoc();
                ?>
                <tr>
                  <td><?php echo $row['id'] ?></td>
                  <td class="article-title">
                    <?php echo  $row_U['username_t'] ?>
                  </td>
                  <td><?php echo $row['time'] ?></td>
                  <td><?php echo $row_U['login_ip'] ?></td>
                  <td><a rel="1">删除</a></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <footer class="message_footer">
          <nav>
            <ul class="pagination pagenav quotes">
              <li <?php echo $page == 1 ? "class=\"disabled\"" : "class=\"canClick\"" ?>>
                <a href="/Admin/loginLog-1" aria-label="Previous">
                  &laquo;
                </a>
              </li>
              <?php
              for ($i = 0; $i < $page_num; $i++) {
                ?>
                <li <?php echo $page == (1 + $i) ? "class=\"active\"" : "class=\"canClick\"" ?>>
                  <a href="/Admin/loginLog-<?php echo (1 + $i) ?>">
                    <?php echo (1 + $i) ?>
                  </a>
                </li>
              <?php
            }
            ?>
              <li <?php echo $page == $page_num ? "class=\"disabled\"" : "class=\"canClick\"" ?>>
                <a href="/Admin/loginLog-<?php echo $page_num ?>" aria-label="Next">
                  &raquo;
                </a>
              </li>
            </ul>
          </nav>
        </footer>
      </div>
    </div>
  </section>
  <?php include 'modal.php' ?>
</body>

</html>