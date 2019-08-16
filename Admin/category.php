<?php include '../config.php' ?>
<!doctype html>
<html lang="zh-CN">

<head>
  <meta charset="utf-8">
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>栏目 - <?php echo WebSite_Title ?>博客管理系统</title>
  <?php include '../tool.php';
  $page_num = $conn->query("SELECT COUNT(*) FROM classify")->fetch_assoc()['COUNT(*)'];
  $classify_num = $page_num;
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
      $sql = "SELECT * FROM classify LIMIT " . ($page - 1) * $amount . "," . $amount . "";
      $result = $conn->query($sql);
      ?>
      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-lg-10 col-md-offset-2 main" id="main">
        <div class="row">

          <h1 class="page-header">管理 <span class="badge"><?php echo $classify_num ?></span></h1>
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th><span class="glyphicon glyphicon-paperclip"></span> <span class="visible-lg">ID</span></th>
                  <th><span class="glyphicon glyphicon-file"></span> <span class="visible-lg">名称</span></th>
                  <th><span class="glyphicon glyphicon-pushpin"></span> <span class="visible-lg">总数</span></th>
                  <th><span class="glyphicon glyphicon-pencil"></span> <span class="visible-lg">操作</span></th>
                </tr>
              </thead>
              <tbody class="commentList">
                <?php
                while ($result && $row = $result->fetch_assoc()) {
                  ?>
                  <tr>
                    <td><?php echo $row['id'] ?></td>
                    <td class="article-title" rel="<?php echo $row['id'] ?>"><?php echo $row['name'] == "" ? "<i>NULL</i>" : $row['name'] ?></td>
                    <td>
                      <?php if ($row['name'] != "") echo $conn->query("SELECT COUNT(*) FROM article WHERE classify LIKE '" . $row['name'] . "'")->fetch_assoc()['COUNT(*)'] . "篇"; ?>
                    </td>
                    <td>
                      <a rel="<?php echo $row['id'] ?>">修改</a> <a rel="<?php echo $row['id'] ?>">删除</a>
                    </td>
                  </tr>
                <?php
              }
              ?>
              </tbody>
            </table>
            <span class="prompt-text"><strong>注：</strong>删除一个栏目也会删除栏目下的文章和子栏目,请谨慎删除！（栏目最大数量为5）</span>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php include 'modal.php' ?>
  <script type="text/javascript">
    $(function() {
      $("#main table tbody tr td a").click(function() {
        var name = $(this);
        Delete(name);
      });

      function Delete(name) {
        var id = name.attr("rel");
        if (event.srcElement.outerText == "删除") {
          $('#deleteModal').modal('show');
          $('#deleteButton').click(function() {
            $('#deleteButton').unbind("click");
            $.ajax({
              type: "POST",
              url: "/ajax.php",
              data: "function=Delete&age=" + id + "//,//classify",
              cache: false,
              success: function(data) {
                if (data == "true") {
                  CanClick("/Admin/category");
                  iziToast.success({
                    title: '成功',
                    message: '您所选择的栏目及其所有文章已经成功删除',
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
        } else {
          $('#categoryModal input[name=categoryID]').val(id);
          str = $('td[rel=' + id + ']').text().replace(/(^\s*)|(\s*$)/g, "");
          if (str == "NULL") {
            str = "";
          }
          var name = name.text();
          $('#categoryModal input[name=categoryName]').val(str);
          $('#categoryModal').modal('show');
          $('#categoryButton').click(function() {
            str = $('#categoryModal input[name=categoryName]').val();
            time = $('#categoryModal input[name=categoryDate]').val()
            $('#categoryButton').unbind("click");
            $.ajax({
              type: "POST",
              url: "/ajax.php",
              data: "function=Category&age=" + id + "//,//" + str,
              cache: false,
              success: function(data) {
                if (data == "true") {
                  CanClick("/Admin/category");
                  iziToast.success({
                    title: '成功',
                    message: '您所进行的' + name + '操作已完成',
                    position: 'bottomRight',
                    transitionIn: 'bounceInLeft',
                    zindex: 1100,
                    pauseOnHover: false,
                  });
                }
              }
            });
            $('#categoryModal').modal('hide');
          });
        };
      };

      function CanClick(str) {
        $.ajax({
          url: str,
          context: $('commentList'),
          success: function(data) {
            commentList = $(data).find('.commentList').html();
            $(".commentList").html(commentList);
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
    });
  </script>
</body>

</html>