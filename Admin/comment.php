<?php include '../config.php' ?>
<!doctype html>
<html lang="zh-CN">

<head>
  <meta charset="utf-8">
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>评论 - <?php echo WebSite_Title ?>博客管理系统</title>
  <?php include '../tool.php';
  $page_num = $conn->query("SELECT COUNT(*) FROM comment")->fetch_assoc()['COUNT(*)'];
  $comment_num = $page_num;
  $amount = 15;
  if ($page_num / $amount > (int)($page_num / $amount))
    $page_num =  (int)($page_num / $amount) + 1;
  else
    $page_num = (int)$page_num / $amount;
  $page = isset($_GET['page']) ? $_GET['page'] : 1;
  if ($page > $page_num) $page = $page_num;
  ?>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body class="user-select">
  <section class="container-fluid">
    <?php include 'header.php' ?>
    <div class="row">
      <?php include 'aside.php';
      $sql = "SELECT * FROM comment ORDER BY `comment`.`article_id` , `comment`.`date` ASC LIMIT " . ($page - 1) * $amount . "," . $amount . "";
      $result = $conn->query($sql);
      ?>
      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-lg-10 col-md-offset-2 main" id="main">
        <form action="" method="post" id="DeleteAll">
          <h1 class="page-header">管理 <span class="badge"><?php echo $comment_num ?></span></h1>
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th><span class="glyphicon glyphicon-th-large"></span> <span class="visible-lg">选择</span></th>
                  <th><span class="glyphicon glyphicon-paperclip"></span> <span class="visible-lg">文章标题</span></th>
                  <th class="hidden-sm"><span class="glyphicon glyphicon-comment"></span> <span class="visible-lg">评论内容</span></th>
                  <th><span class="glyphicon glyphicon-user"></span> <span class="visible-lg">用户</span></th>
                  <th><span class="glyphicon glyphicon-time"></span> <span class="visible-lg">日期</span></th>
                  <th><span class="glyphicon glyphicon-pencil"></span> <span class="visible-lg">操作</span></th>
                </tr>
              </thead>
              <tbody class="commentList">
                <?php
                while ($result && $row = $result->fetch_assoc()) {
                  $str = $conn->query("SELECT `title` FROM `article` WHERE id=" . $row['article_id'])->fetch_assoc()['title'];
                  ?>
                  <tr>
                    <td><input type="checkbox" class="input-control" name="checkbox[]" value="<?php echo $row['id'] ?>" /></td>
                    <td>
                      <a href="/article-<?php echo $row['article_id'] ?>" title="<?php echo $str ?>">
                        <?php echo mb_substr($str, 0, 4, 'utf-8') . "..." ?>
                      </a>
                    </td>
                    <td class="article-title"><?php echo $row['content'] ?></td>
                    <td><?php echo $conn->query("SELECT `username_t` FROM `user_center` WHERE `id` = 1")->fetch_assoc()['username_t'] ?></td>
                    <td><?php echo $row['date'] ?></td>
                    <td><a rel="<?php echo $row['id'] ?>">删除</a></td>
                  </tr>
                <?php
              }
              ?>
              </tbody>
            </table>
          </div>
          <footer class="message_footer">
            <nav>
              <div class="btn-toolbar operation" role="toolbar">
                <div class="btn-group" role="group"> <a class="btn btn-default" onClick="select()">全选</a> <a class="btn btn-default" onClick="reverse()">反选</a> <a class="btn btn-default" onClick="noselect()">不选</a> </div>
                <div class="btn-group" role="group">
                  <button type="submit" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="删除全部选中" name="checkbox_delete">删除</button>
                </div>
              </div>
              <ul class="pagination pagenav quotes">
                <li <?php echo $page == 1 ? "class=\"disabled\"" : "class=\"canClick\"" ?>>
                  <a href="/Admin/comment-1" aria-label="Previous">
                    &laquo;
                  </a>
                </li>
                <?php
                for ($i = 0; $i < $page_num; $i++) {
                  ?>
                  <li <?php echo $page == (1 + $i) ? "class=\"active\"" : "class=\"canClick\"" ?>>
                    <a href="/Admin/comment-<?php echo (1 + $i) ?>">
                      <?php echo (1 + $i) ?>
                    </a>
                  </li>
                <?php
              }
              ?>
                <li <?php echo $page == $page_num ? "class=\"disabled\"" : "class=\"canClick\"" ?>>
                  <a href="/Admin/comment-<?php echo $page_num ?>" aria-label="Next">
                    &raquo;
                  </a>
                </li>
              </ul>
            </nav>
          </footer>
        </form>
      </div>
    </div>
  </section>
  <?php include 'modal.php' ?>
  <script>
    $(function() {
      $('.canClick a').click(function(event) {
        str = $(this).attr('href');
        CanClick(str);
        event.preventDefault();
      });
      $("#main table tbody tr td a").click(function() {
        var name = $(this);
        Delete(name);
      });

      function Delete(name) {
        var id = name.attr("rel"); //对应id  
        if (event.srcElement.outerText == "删除") {
          $('#deleteModal').modal('show');
          $('#deleteButton').click(function() {
            $('#deleteButton').unbind("click");
            $.ajax({
              type: "POST",
              url: "/ajax.php",
              data: "function=Delete&age=" + id + "//,//comment",
              cache: false, //不缓存此页面   
              success: function(data) {
                if (data == "true") {
                  iziToast.success({
                    title: '成功',
                    message: '您所选择的评论已经成功删除',
                    position: 'bottomRight',
                    transitionIn: 'bounceInLeft',
                    zindex: 1100,
                    pauseOnHover: false,
                  });
                  CanClick("/Admin/comment-<?php echo $page ?>");
                }
              }
            });
            $('#deleteModal').modal('hide');
          });
        };
      };

      function CanClick(str) {
        $.ajax({
          url: str,
          context: $('commentList'),
          success: function(data) {
            commentList = $(data).find('.commentList').html();
            quotes = $(data).find('.quotes').html();
            $(".commentList").html(commentList);
            $(".quotes").html(quotes);
            $('.disabled a,.active a').click(function(event) {
              event.preventDefault();
            });
            $('.canClick a').click(function(event) {
              str = $(this).attr('href');
              CanClick(str);
              event.preventDefault();
            });
            $("#main table tbody tr td a").click(function() {
              var name = $(this);
              Delete(name);
            });
          }
        });
      };

      $("#DeleteAll").submit(function(event) {
        event.preventDefault();
        var arr = new Array();
        $("input:checkbox:checked").each(function(i) {
          arr[i] = $(this).val();
        });
        var values = arr.join(",");
        if (values == "") {
          iziToast.warning({
            title: '提示',
            message: '您未选中任何一条想要删除的评论',
            position: 'bottomRight',
            transitionIn: 'bounceInLeft',
            zindex: 1100,
            pauseOnHover: false,
          });
        } else {
          $('#deleteModal').modal('show');
          $('#deleteButton').click(function() {
            $('#deleteButton').unbind("click");
            $.ajax({
              type: "POST",
              url: "/ajax.php",
              data: "function=DeleteAll&age=" + values + "//,//comment",
              cache: false, //不缓存此页面  
              success: function(data) {
                if (data == "true") {
                  if (arr.length == <?php echo $result->num_rows ?>) {
                    CanClick("/Admin/comment-<?php echo $page - 1 == 0 ? "1" : $page - 1 ?>");
                  } else {
                    CanClick("/Admin/comment-<?php echo $page ?>");
                  }
                  iziToast.success({
                    title: '成功',
                    message: '您所选择的' + arr.length + '条评论已经成功删除',
                    position: 'bottomRight',
                    transitionIn: 'bounceInLeft',
                    zindex: 1100,
                    pauseOnHover: false,
                  });
                }
              }
            });
            $('#deleteModal').modal('hide');
          });
        }
      })
    });
  </script>
</body>

</html>