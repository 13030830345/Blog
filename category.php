<?php include 'config.php' ?>
<!doctype html>
<html lang="zh-CN">

<head>
  <meta charset="utf-8">
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php include 'tool.php';
  if (isset($_GET['id'])) {
    $sql = "SELECT * FROM classify where id = " . $_GET['id'];
    $row = $conn->query($sql)->fetch_assoc();
    $name = $row['name'];
    $sql = "SELECT * FROM article where classify LIKE  '$name'";
    $id = $_GET['id'];
  } else {
    $sql = "SELECT * FROM article where id = 1";
    $id = 1;
    $name = "前端技术";
  }
  $page_num = $conn->query($sql)->num_rows;
  $amount = 5;
  if ($page_num / $amount > (int)($page_num / $amount))
    $page_num =  (int)($page_num / $amount) + 1;
  else
    $page_num = (int)$page_num / $amount;
  $page = isset($_GET['page']) ? $_GET['page'] : 1;
  if ($page > $page_num) $page = $page_num;
  ?>
  <link rel="stylesheet" type="text/css" href="/css/style.css">
  <title><?php echo $name ?> - | <?php echo WebSite_Title ?> | <?php echo WebSite_Subtitle ?> | Powered By <?php echo WebSite_Copyright ?></title>
</head>

<body class="user-select">
  <?php include 'header.php';

  ?>
  <section class="container">
    <div class="content-wrap">
      <div class="content">
        <div class="title">
          <h3><?php echo $name; ?></h3>
        </div>
        <?php
        $sql = "SELECT * FROM article where classify LIKE '" . $name . "' ORDER BY `article`.`date` DESC LIMIT " . ($page - 1) * $amount . "," . $amount . "";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            ?>
            <article class="excerpt excerpt-<?php echo $row['id'] ?>"><a class="focus" href="article-<?php echo $row['id'] ?>" title=""><img class="thumb" data-original="<?php echo $row['image'] ?>" src="<?php echo $row['image'] ?>" alt=""></a>
              <header><a class="cat" href="program"><?php echo $row['classify'] ?><i></i></a>
                <h2><a href="article-<?php echo $row['id'] ?>" class="isArticle"><?php echo $row['title'] ?></a></h2>
              </header>
              <p class="meta">
                <time class="time"><i class="glyphicon glyphicon-time"></i><?php echo $row['date'] ?></time>
                <span class="views"><i class="glyphicon glyphicon-eye-open"></i> 共<?php echo $row['view'] ?>人围观</span> <a class="comment" href="article-<?php echo $row['id'] ?>"><i class="glyphicon glyphicon-comment"></i> 0个不明物体</a></p>
              <div class="note"><?php echo $row['foreword'] ?></div>
            </article>
          <?php
        }
      } else {
        echo "唔...这个页面没有内容呢！";
      }
      ?>
        <div class="ias_end" style="display:none"><a>已是最后一页</a></div>
        <nav class="pagination" style="display: none;">
          <ul>
            <li class="prev-page"></li>
            <?php
            for ($i = 0; $i < $page_num; $i++) {
              ?>
              <li <?php echo $page == (1 + $i) ? "class=\"active\"" : "" ?>>
                <a href="category-<?php echo $id ?>-<?php echo (1 + $i) ?>">
                  <?php echo (1 + $i) ?>
                </a>
              </li>
            <?php
          }
          ?>
            <li class="next-page"><a href="category-<?php echo $id ?>-<?php echo ($page + 1) > $page_num ? $page_num + 1 : ($page + 1) ?>">下一页</a></li>
            <li><span>共 <?php echo $page_num ?> 页</span></li>
          </ul>
        </nav>
      </div>
    </div>
    <aside class="sidebar">
      <?php include 'RightMenu.php' ?>
    </aside>
  </section>
  <script type="text/javascript">
    var page_num = <?php echo $page_num ?>;
  </script>
  <?php include 'footer.php' ?>
</body>

</html>