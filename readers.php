<?php include 'config.php' ?>
<!doctype html>
<html lang="zh-CN">

<head>
  <meta charset="utf-8">
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>读者墙 - | <?php echo WebSite_Title ?> | <?php echo WebSite_Subtitle ?> | Powered By <?php echo WebSite_Copyright ?></title>
  <?php include 'tool.php'; ?>
  <link rel="stylesheet" type="text/css" href="/css/style.css">
</head>

<body class="user-select">
  <?php include 'header.php' ?>
  <section class="container container-page">
    <div class="pageside">
      <div class="pagemenus">
        <ul class="pagemenu">
          <li><a href="tags">标签云</a></li>
          <li><a class="active" href="readers">读者墙</a></li>
          <li><a href="links">友情链接</a></li>
        </ul>
      </div>
    </div>
    <div class="content">
      <header class="article-header">
        <h1 class="article-title">读者墙</h1>
        <?php
        $a = array();
        $temp = 2;
        $sql = "SELECT * FROM comment WHERE 1 ORDER BY `comment`.`user_id` ASC";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
          if ($row['user_id'] != 1)
            array_push($a, $row['user_id']);
        }
        $b = array_count_values($a);
        arsort($b);
        $c = array_keys($b);
        ?>
      </header>
      <div class="readers">
        <?php
        $i = 1;
        $t = array("金牌读者", "银牌读者", "铜牌读者", "普通读者");
        foreach ($c as $value) {
          $sql = "SELECT * FROM user_center WHERE id = $value";
          $result = $conn->query($sql);
          $row = $result->fetch_assoc();
          ?>
          <a class="item-readers item-readers-<?php echo $i ?>" rel="nofollow">
            <h4>【<?php echo $t[$i - 1] ?>】<small>评论：<?php echo $b[$value] ?></small></h4>
            <?php if ($row['avatar'] != "") { ?>
              <img class="avatar" height="36" width="36" src="<?php echo $row['avatar'] ?>">
            <?php } else { ?>
              <svg class="avatar" data-jdenticon-value="<?php echo $row['username_t'] ?>" width="36" height="36"></svg>
            <?php } ?>
            <strong><?php echo $row['username_t'] ?></strong>http://www.ylsat.com/
          </a>
          <?php
          if ($i >= 4) $i = 4;
          else $i++;
        } ?>
      </div>
    </div>
  </section>
  <?php include 'footer.php' ?>
</body>

</html>