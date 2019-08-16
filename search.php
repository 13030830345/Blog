<?php include 'config.php' ?>
<!doctype html>
<html lang="zh-CN">

<head>
  <meta charset="utf-8">
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php
  include 'tool.php';
  $keyword = "";
  if (isset($_REQUEST["keyword"])) {
    $keyword = $_REQUEST["keyword"];
  }
  $sql = "SELECT * FROM `article` WHERE upper(title) LIKE upper(\"%"  . $keyword . "%\") OR
upper(`foreword`) LIKE upper(\"%"  . $keyword . "%\") OR
upper(`author`) LIKE upper(\"%"  . $keyword . "%\") OR
upper(`classify`) LIKE upper(\"%"  . $keyword . "%\") OR
upper(`content`) LIKE upper(\"%"  . $keyword . "%\") OR
upper(`label`) LIKE upper(\"%"  . $keyword . "%\")";
  $page_num = $conn->query($sql)->num_rows;
  $num = $page_num;
  if ($num != 0 && $keyword != "") {
    $amount = 5;
    if ($page_num / $amount > (int)($page_num / $amount))
      $page_num =  (int)($page_num / $amount) + 1;
    else
      $page_num = (int)$page_num / $amount;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    if ($page > $page_num) $page = $page_num;
  }
  ?>
  <title><?php echo $keyword == "" ? "Nothing" : $keyword ?> - | <?php echo WebSite_Title ?> | <?php echo WebSite_Subtitle ?> | Powered By <?php echo WebSite_Copyright ?></title>
  <link rel="stylesheet" type="text/css" href="/css/style.css">
</head>

<body class="user-select">
  <?php
  include 'header.php'
  ?>
  <section class="container">
    <div class="fixed">
      <div class="widget widget_search title">
        <form class="navbar-form" action="" method="post">
          <div class="input-group">
            <input type="text" name="keyword" class="form-control" size="35" style=placeholder="请输入关键字" maxlength="15" autocomplete="off" value="<?php echo $keyword ?>">
            <span class="input-group-btn">
              <button class="btn btn-default btn-search" name="search" type="submit">搜索</button>
            </span>
          </div>
          <div class="more">
            <?php
            $str = "<a id=\"tips\">Null</a>";
            echo $keyword == "" ? str_replace('Null', '您未输入搜索内容！', $str) : ($num == 0 ? str_replace('Null', '抱歉，没有您想搜索的内容！', $str) : "")
            ?></div>
        </form>
      </div>
      <div class="content-wrap">
        <div class="content" style="margin-right: 0px;">
          <?php
          if ($num != 0 && $keyword != "") {
            $sql = "SELECT * FROM `article` WHERE upper(title) LIKE upper(\"%"  . $keyword . "%\") OR
          upper(`foreword`) LIKE upper(\"%"  . $keyword . "%\") OR
          upper(`author`) LIKE upper(\"%"  . $keyword . "%\") OR
          upper(`classify`) LIKE upper(\"%"  . $keyword . "%\") OR
          upper(`content`) LIKE upper(\"%"  . $keyword . "%\") OR
          upper(`label`) LIKE upper(\"%"  . $keyword . "%\") LIMIT " . ($page - 1) * $amount . "," . $amount . "";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
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
          }
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
                  <a href="search-<?php echo $keyword ?>-<?php echo (1 + $i) ?>">
                    <?php echo (1 + $i) ?>
                  </a>
                </li>
              <?php
            }
            ?>
              <li class="next-page"><a href="search-<?php echo $keyword ?>-<?php echo ($page + 1) > $page_num ? $page_num + 1 : ($page + 1) ?>">下一页</a></li>
              <li><span>共 <?php echo $page_num ?> 页</span></li>
            </ul>
          </nav>
        </div>
      </div>
  </section>
  <script type="text/javascript">
    var page_num = <?php echo $page_num ?>;
    $(function() {
      $("#tips").click(function() {
        $("input[name=keyword]").focus();
      })
    });
  </script>
  <?php include 'footer.php' ?>
</body>

</html>