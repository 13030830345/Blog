<?php include '../config.php' ?>
<!doctype html>
<html lang="zh-CN">

<head>
  <meta charset="utf-8">
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php include '../tool.php';
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM links WHERE id = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      $rowA = $result->fetch_assoc();
    } else {
      unset($id);
    }
  } ?>
  <title><?php echo isset($id) ? "更新" : "增加"; ?>友情链接 - <?php echo WebSite_Title ?>博客管理系统</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body class="user-select">
  <section class="container-fluid">
    <?php include 'header.php' ?>
    <div class="row">
      <?php include 'aside.php' ?>
      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-lg-10 col-md-offset-2 main" id="main">
        <div class="row">
          <form action="fLink" method="post" class="add-fFink-form" autocomplete="off" draggable="false">
            <div class="col-md-9">
              <h1 class="page-header"><?php echo isset($id) ? "修改" : "增加"; ?>友情链接</h1>
              <div class="add-article-box">
                <h2 class="add-article-box-title"><span>名称</span></h2>
                <div class="add-article-box-content">
                  <input type="text" id="fLink-name" name="name" class="form-control" placeholder="在此处输入名称" required autofocus autocomplete="off" value="<?php echo isset($id) ? $rowA['title'] : ""; ?>" maxlength="8">
                  <span class="prompt-text">例如：<?php echo WebSite_Title ?>博客</span> </div>
              </div>
              <div class="add-article-box">
                <h2 class="add-article-box-title"><span>图标地址</span></h2>
                <div class="add-article-box-content">
                  <input type="text" id="fLink-imgUrl" name="imgUrl" class="form-control" placeholder="在此处输入图标地址" required autocomplete="off" value="<?php echo isset($id) ? $rowA['icon'] : ""; ?>">
                  <span class="prompt-text">图像地址是可选的，可以为网站LOGO地址，以下是预览效果（系统将在你输入Web地址后自动尝试补足图标）：</span>
                  <div class="plinks">
                    <a>
                      <img src="<?php echo isset($id) ? $rowA['icon'] : "/favicon.ico"; ?>" width="16" height="16" style="margin-right:8px" id="LinkIcon">
                      <span id="LinkName"><?php echo isset($id) ? $rowA['title'] : "喵窝博客"; ?></span>
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <h1 class="page-header">操作</h1>
              <div class="add-article-box">
                <h2 class="add-article-box-title"><span>WEB地址</span></h2>
                <div class="add-article-box-content">
                  <input type="text" id="fLink-url" name="url" class="form-control" placeholder="在此处输入URL地址" required autocomplete="off" value="<?php echo isset($id) ? $rowA['link'] : "http://"; ?>">
                  <span class="prompt-text">例子：<code>http://www.scmanga.cn/</code>——不要忘了<code>http://</code></span> </div>
              </div>
              <div class="add-article-box">
                <h2 class="add-article-box-title"><span>保存</span></h2>
                <div class="add-article-box-content">
                  <p>
                    <label>状态：</label>
                    <span class="article-status-display"><?php echo isset($id) ? "已存在" : "未增加"; ?></span></p>
                  <p>
                    <label>target：</label>
                    <input type="radio" name="target" value="_blank" <?php echo isset($id) && $rowA['target'] != "_blank" ? "" : "checked" ?> />_blank&nbsp;&nbsp;
                    <input type="radio" name="target" value="_self" <?php echo isset($id) && $rowA['target'] == "_self" ? "checked" : "" ?> />_self&nbsp;&nbsp;
                    <input type="radio" name="target" value="_top" <?php echo isset($id) && $rowA['target'] == "_top" ? "checked" : "" ?> />_top
                  </p>
                  <p>
                    <label>rel：</label>
                    <input type="radio" name="rel" value="nofollow" <?php echo isset($id) && $rowA['rel'] != "nofollow" ? "" : "checked" ?> />nofollow
                    &nbsp;&nbsp;<input type="radio" name="rel" value="none" <?php echo isset($id) && $rowA['rel'] == "none" ? "checked" : "" ?> />none
                  </p>
                </div>
                <div class="add-article-box-footer">
                  <p><input type="hidden" value="<?php echo isset($id) ? $id : 0; ?>" name="fLinkID"></p>
                  <button class="btn btn-primary" type="submit" name="submit">增加</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
  <?php include 'modal.php' ?>
  <script>
    $('input[name=url]').on("change", function() {
      $('#LinkIcon').attr("src", $('input[name=url]').val() != "" ? $('input[name=url]').val() + "/favicon.ico" : "/favicon.ico");
      $('input[name=imgUrl]').val($('input[name=url]').val() != "" ? $('input[name=url]').val() + "/favicon.ico" : "/favicon.ico")
    })
    $('input[name=imgUrl]').on("change", function() {
      $('#LinkIcon').attr("src", $('input[name=imgUrl]').val());
    })
    $('input[name=name]').on("change", function() {
      $('#LinkName').text($('input[name=name]').val() != "" ? $('input[name=name]').val() : "喵窝博客");
    })
  </script>
</body>

</html>