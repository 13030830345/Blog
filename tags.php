<?php include 'config.php' ?>
<!doctype html>
<html lang="zh-CN">

<head>
  <meta charset="utf-8">
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>标签云 - | <?php echo WebSite_Title ?> | <?php echo WebSite_Subtitle ?> | Powered By <?php echo WebSite_Copyright ?></title>
  <?php
  include 'tool.php';
  $sql = "SELECT label FROM article";
  $result = $conn->query($sql);
  $arr = "";
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $label = $row['label'];
      $arr = $label != "" ? $arr == "" ? $label : $arr . "," . $label : $arr;
    }
  }
  $arr = array_unique(explode(",", strtoupper($arr)));
  ?>
  <link rel="stylesheet" type="text/css" href="/css/style.css">
</head>

<body class="user-select">
  <?php include 'header.php' ?>
  <section class="container container-page">
    <div class="pageside">
      <div class="pagemenus">
        <ul class="pagemenu">
          <li><a class="active" href="tags">标签云</a></li>
          <li><a href="readers">读者墙</a></li>
          <li><a href="links">友情链接</a></li>
        </ul>
      </div>
    </div>
    <div class="content">
      <header class="article-header">
        <h1 class="article-title">标签云</h1>
      </header>
      <ul class="plinks ptags">
        <?php
        foreach ($arr as $value) {
          $sql = "SELECT * FROM article WHERE upper(label) LIKE upper('%" . $value . "%')";
          $result = $conn->query($sql);
          $num  = $result->num_rows;
          ?>
          <li><a href="search-<?php echo $value ?>" title="<?php echo $value ?>"><?php echo $value ?> <span class="badge"><?php echo $num ?></span></a></li>
        <?php
      }
      ?>
      </ul>
    </div>
  </section>
  <?php include 'footer.php' ?>
</body>

</html>