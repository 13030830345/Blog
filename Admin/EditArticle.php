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
    $sql = "SELECT * FROM article WHERE id = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      $rowA = $result->fetch_assoc();
    } else {
      unset($id);
    }
  }
  ?>
  <title><?php echo isset($id) ? "更新" : "写"; ?>文章 - <?php echo WebSite_Title ?>博客管理系统</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body class="user-select">
  <section class="container-fluid">
    <?php include 'header.php' ?>
    <div class="row">
      <?php include 'aside.php' ?>
      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-lg-10 col-md-offset-2 main" id="main">
        <div class="row">
          <form action="article" method="post" class="add-article-form" id="articleAdd">
            <div class="col-md-9">
              <h1 class="page-header"><?php echo isset($id) ? "修改文章" : "撰写新文章"; ?> </h1>
              <div class="form-group">
                <label for="article-title" class="sr-only">标题</label>
                <input type="text" id="article-title" name="title" class="form-control" placeholder="在此处输入标题" required autofocus autocomplete="off" value="<?php echo isset($id) ? $rowA['title'] : ""; ?>">
              </div>
              <div class="form-group">
                <label for="article-content" class="sr-only">内容</label>
                <textarea type="text" name="content" id="article-content" placeholder="编辑器正在加载..." style="border: none;background: none">
                <?php echo isset($id) ? $rowA['content'] : "" ?>
              </textarea>
              </div>
              <div class="add-article-box">
                <h2 class="add-article-box-title"><span>概述</span></h2>
                <div class="add-article-box-content">
                  <textarea class="form-control" name="describe" autocomplete="off" style="height: 64px"><?php echo isset($id) ? $rowA['foreword'] : ""; ?></textarea>
                  <span class="prompt-text">概述是可选的手工创建的内容总结，在浏览文章页面显示</span>
                  <p>
                    <label>
                      <input type="checkbox" name="describe_on" style="margin-top: 2px;margin-right: 4px">自动生成概述
                    </label>
                    <label style="margin-left: 15px;">
                      <input type="checkbox" name="comment" style="margin-top: 2px;margin-right: 4px" <?php echo isset($id) ? $rowA['comment_off'] == '1' ? "checked" : "" : ""; ?>>禁止评论
                    </label>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <h1 class="page-header">操作</h1>
              <div class="add-article-box">
                <h2 class="add-article-box-title"><span>栏目</span></h2>
                <div class="add-article-box-content">
                  <ul class="category-list">
                    <?php
                    $sql = "SELECT * FROM classify";
                    $result = $conn->query($sql);
                    $i = 0;
                    while ($row = $result->fetch_assoc()) {
                      $i++;
                      ?>
                      <li>
                        <label>
                          <input name="category" type="radio" value="<?php echo $row['name'] ?>" <?php echo isset($id) ? ($rowA['classify'] == $row['name'] ? "checked" : "") : ($i == 1 ? "checked" : "") ?> <?php echo $row['name'] == "" ? "disabled='disabled'" : ""; ?>>
                          <?php echo $row['name'] == "" ? "<i>NULL</i>" : $row['name'] ?>
                          <em class="hidden-md">( 栏目ID: <span><?php echo $row['id'] ?></span> )</em>
                        </label>
                      </li>
                    <?php
                  }
                  ?>
                  </ul>
                </div>
              </div>
              <div class="add-article-box">
                <h2 class="add-article-box-title"><span>标签</span></h2>
                <div class="add-article-box-content">
                  <input type="text" class="form-control" placeholder="输入新标签" name="tags" autocomplete="off" value="<?php echo isset($id) ? $rowA['label'] : ""; ?>">
                  <span class="prompt-text">多个标签请用英文逗号(,)隔开</span> </div>
              </div>
              <div class="add-article-box">
                <h2 class="add-article-box-title"><span>作者</span></h2>
                <div class="add-article-box-content">
                  <input type="text" class="form-control" placeholder="输入作者名称" name="author" autocomplete="off" value="<?php echo isset($id) ? $rowA['author'] : $username; ?>">
                  <span class="prompt-text">请输入本文作者名称</span> </div>
              </div>
              <div class="add-article-box">
                <h2 class="add-article-box-title"><span>标题图片</span></h2>
                <div class="add-article-box-content">
                  <input type="text" class="form-control" placeholder="点击按钮选择图片" id="pictureUpload" name="titlePic" autocomplete="off" value="<?php echo isset($id) ? $rowA['image'] : ""; ?>">
                </div>
                <div class="add-article-box-footer">
                  <button class="btn btn-default" type="button" ID="upImage">选择</button>
                </div>
              </div>
              <div class="add-article-box">
                <h2 class="add-article-box-title"><span>发布</span></h2>
                <div class="add-article-box-content">
                  <p><label>状态：</label><span class="article-status-display"><?php echo isset($id) ? "已发布" : "未发布"; ?></span></p>
                  <p><label>发布于：</label><span class="article-time-display"><input style="border: none;" type="datetime" name="time" value="<?php echo isset($id) ? $rowA['date'] : ""; ?>" /></span></p>
                  <p><input type="hidden" value="<?php echo isset($id) ? $id : 0; ?>" name="articleID"></p>
                </div>
                <div class="add-article-box-footer">
                  <button class="btn btn-primary" type="submit" name="submit"><?php echo isset($id) ? "更新" : "发布"; ?></button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
  <?php include 'UEditor.php';
  include 'modal.php'; ?>
  <script>
    var can = <?php echo isset($id) ? 0 : 1; ?>;
    if (can) {
      $('input[name=time]').val(new Date().Format("yyyy-MM-dd hh:mm:ss"));
      setInterval(function() {
        $('input[name=time]').val(new Date().Format("yyyy-MM-dd hh:mm:ss"));
      }, 5000);
    }

    function textarea() {
      var text = $("textarea[name=describe]");
      var str = UE.getEditor('article-content').getContentTxt();
      if (str.length > 100) {
        text.text(str.substring(0, 100) + "...");
      } else {
        text.text(str.substring(0, 100));
      }
    }
    var Interval;
    $('input[name=describe_on]').click(function() {
      if ($(this).prop("checked")) {
        Interval = setInterval("textarea();", 1000);
      } else {
        clearInterval(Interval);
      }
    })
  </script>
</body>

</html>