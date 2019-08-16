<?php include '../config.php' ?>
<!doctype html>
<html lang="zh-CN">

<head>
  <meta charset="utf-8">
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>管理用户 - <?php echo WebSite_Title ?>博客管理系统</title>
  <?php include '../tool.php'; ?>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body class="user-select">
  <section class="container-fluid">
    <?php include 'header.php';
    $page_num = $conn->query("SELECT COUNT(*) FROM user_center")->fetch_assoc()['COUNT(*)'];
    $user_num = $page_num;
    $amount = 15;
    if ($page_num / $amount > (int)($page_num / $amount))
      $page_num =  (int)($page_num / $amount) + 1;
    else
      $page_num = (int)$page_num / $amount;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    if ($page > $page_num || $Toast == "NewTitle") $page = $page_num;
    $sql = "SELECT * FROM user_center ORDER BY `user_center`.`id` ASC LIMIT " . ($page - 1) * $amount . "," . $amount;
    $result = $conn->query($sql);
    ?>
    <div class="row">
      <?php include 'aside.php' ?>
      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-lg-10 col-md-offset-2 main" id="main">
        <h1 class="page-header">操作</h1>
        <ol class="breadcrumb">
          <li><a data-toggle="modal" data-target="#addUser">增加用户</a></li>
        </ol>
        <h1 class="page-header">管理 <span class="badge"><?php echo $user_num ?></span></h1>
        <div class="table-responsive">
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th><span class="glyphicon glyphicon-th-large"></span> <span class="visible-lg">ID</span></th>
                <th><span class="glyphicon glyphicon-user"></span> <span class="visible-lg">用户名</span></th>
                <th><span class="glyphicon glyphicon-comment"></span> <span class="visible-lg">评论</span></th>
                <th><span class="glyphicon glyphicon-time"></span> <span class="visible-lg">上次登录时间</span></th>
                <th><span class="glyphicon glyphicon-pushpin"></span> <span class="visible-lg">登录次数</span></th>
                <th><span class="glyphicon glyphicon-pencil"></span> <span class="visible-lg">操作</span></th>
              </tr>
            </thead>
            <tbody class="commentList">
              <?php while ($result && $row = $result->fetch_assoc()) { ?>
                <tr>
                  <td><?php echo $row['id'] ?></td>
                  <td rel="<?php echo $row['id'] ?>"><?php echo $row['username_t'] ?></td>
                  <td><?php echo $conn->query("SELECT COUNT(*) FROM comment WHERE `user_id` = " . $row['id'])->fetch_assoc()['COUNT(*)'] ?></td>
                  <td><?php echo $row['login_time'] == "0000-00-00 00:00:00" ? "<i>从未登陆</i>" : $row['login_time'] ?></td>
                  <td><?php echo $row['login_times'] ?></td>
                  <td>
                    <?php if ($row['id'] == "1") echo "<a>Admin</a>";
                    else {
                      ?><a rel="<?php echo $row['id'] ?>" name="see">修改</a> <a rel="<?php echo $row['id'] ?>" name="delete">删除</a>
                    <?php } ?>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>

        </div>
        <footer class="message_footer">
          <nav>
            <div class="btn-toolbar operation" role="toolbar">
              <span class="prompt-text"><strong>注：</strong>在非极端情况下，最好不要进行任何的用户修改和删除操作，删除一位用户将会一同删除Ta的所有评论！</span>
            </div>
            <ul class="pagination pagenav quotes">
              <li <?php echo $page == 1 ? "class=\"disabled\"" : "class=\"canClick\"" ?>>
                <a href="/Admin/manageUser-1" aria-label="Previous">
                  &laquo;
                </a>
              </li>
              <?php
              for ($i = 0; $i < $page_num; $i++) {
                ?>
                <li <?php echo $page == (1 + $i) ? "class=\"active\"" : "class=\"canClick\"" ?>>
                  <a href="/Admin/manageUser-<?php echo (1 + $i) ?>">
                    <?php echo (1 + $i) ?>
                  </a>
                </li>
              <?php
            }
            ?>
              <li <?php echo $page == $page_num ? "class=\"disabled\"" : "class=\"canClick\"" ?>>
                <a href="/Admin/manageUser-<?php echo $page_num ?>" aria-label="Next">
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
              data: "function=Delete&age=" + id + "//,//user_center",
              cache: false, //不缓存此页面   
              success: function(data) {
                if (data == "true") {
                  iziToast.success({
                    title: '成功',
                    message: '您所选择的用户已经成功删除',
                    position: 'bottomRight',
                    transitionIn: 'bounceInLeft',
                    zindex: 1100,
                    pauseOnHover: false,
                  });
                  CanClick("/Admin/manageUser.php?page=<?php echo $page ?>");
                }
              }
            });
            $('#deleteModal').modal('hide');
          });
        } else {
          $('#seeUser input[name=user_id]').val(id);
          str = $('td[rel=' + id + ']').text();
          $('#seeUser input[name=seeUser_name]').val(str);
          $('#seeUser').modal('show');
          $('#SeeUserButton').click(function() {
            username = $('#seeUser input[name=seeUser_name]').val();
            password = $('#seeUser input[name=password]').val();
            new_password = $('#seeUser input[name=new_password]').val();
            if (password != new_password) {
              iziToast.error({
                title: '错误',
                message: '两次输入的密码不一致',
                position: 'topCenter',
                transitionIn: 'fadeInDown',
                zindex: 1100,
                pauseOnHover: false,
                onOpening: function() {
                  $('#seeUser input[name=new_password]').focus();
                },
              });
              return;
            }
            $('#SeeUserButton').unbind("click");
            $.ajax({
              type: "POST",
              url: "/ajax.php",
              data: "function=AdminInfo&age=" + username + "//,//" + password + "//,//" + password + "//,//" + id,
              cache: false, //不缓存此页面   
              success: function(data) {
                if (data == "true") {
                  CanClick("/Admin/manageUser.php");
                  iziToast.success({
                    title: '成功',
                    message: '您所进行的修改用户信息操作已完成',
                    position: 'bottomRight',
                    transitionIn: 'bounceInLeft',
                    zindex: 1100,
                    pauseOnHover: false,
                  });
                }
              }
            });
            $('#seeUser').modal('hide');
          });
        }
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
            message: '您未选中任何一位想要删除的用户',
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
              data: "function=DeleteAll&age=" + values + "//,//user_center",
              cache: false, //不缓存此页面  
              success: function(data) {
                if (data == "true") {
                  if (arr.length == <?php echo $result->num_rows ?>) {
                    CanClick("/Admin/manageUser.php?page=<?php echo $page - 1 ?>");
                  } else {
                    CanClick("/Admin/manageUser.php?page=<?php echo $page ?>");
                  }
                  iziToast.success({
                    title: '成功',
                    message: '您所选择的' + arr.length + '位用户已经成功删除',
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