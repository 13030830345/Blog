<?php include '../config.php' ?>
<!doctype html>
<html lang="zh-CN">

<head>
  <meta charset="utf-8">
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>公告 - <?php echo WebSite_Title ?>博客管理系统</title>
  <?php include '../tool.php';
  $notice_num = $conn->query("SELECT COUNT(*) FROM notice")->fetch_assoc()['COUNT(*)'];
  ?>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body class="user-select">
  <section class="container-fluid">
    <?php include 'header.php' ?>
    <div class="row">
      <?php include 'aside.php';
      $sql = "SELECT * FROM notice ORDER BY `notice`.`date` ASC";
      $result = $conn->query($sql);
      ?>
      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-lg-10 col-md-offset-2 main" id="main">
        <form action="" method="post" id="DeleteAll">
          <h1 class="page-header">管理 <span class="badge"><?php echo $notice_num ?></span></h1>
          <ol class="breadcrumb">
            <li>仅支持最多5条公告。</li>
          </ol>
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th><span class="glyphicon glyphicon-th-large"></span> <span class="visible-lg">选择</span></th>
                  <th><span class="glyphicon glyphicon-paperclip"></span> <span class="visible-lg">ID</span></th>
                  <th class="hidden-sm"><span class="glyphicon glyphicon-file"></span> <span class="visible-lg">内容</span></th>
                  <th><span class="glyphicon glyphicon-time"></span> <span class="visible-lg">日期</span></th>
                  <th><span class="glyphicon glyphicon-pencil"></span> <span class="visible-lg">操作</span></th>
                </tr>
              </thead>
              <tbody class="commentList">
                <?php
                while ($result && $row = $result->fetch_assoc()) {
                  ?>
                  <tr>
                    <td>
                      <input type="checkbox" class="input-control" name="checkbox[]" value="<?php echo $row['id'] ?>" <?php if ($row['content'] == "") echo "disabled=\"disabled\"" ?> />
                    </td>
                    <td><?php echo $row['content'] == "" ? "<i>NULL</i>" : $row['id'] ?></td>
                    <td class="article-title" rel="<?php echo $row['id'] ?>"><?php echo $row['content'] == "" ? ">>>该条公告暂无内容<<<" : $row['content'] ?>
                    </td>
                    <td><?php echo $row['date'] == "9999-00-00" ? "<i>NULL</i>" : $row['date'] ?></td>
                    <td>
                      <a rel="<?php echo $row['id'] ?>"><?php echo $row['content'] == "" ? "新增" : "修改" ?></a>
                      <a rel="<?php echo $row['id'] ?>" <?php echo $row['content'] == "" ? "class='isNull'" : "" ?>>删除</a>
                    </td>
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
            </nav>
          </footer>
        </form>
      </div>
    </div>
  </section>
  <?php include 'modal.php' ?>
  <script>
    $(function() {
      $("#main table tbody tr td a").click(function() {
        var name = $(this);
        if (name.attr("class") == "isNull") {
          iziToast.warning({
            title: '提示',
            message: '您选择进行删除的公告已经没有任何内容了！',
            position: 'bottomRight',
            transitionIn: 'bounceInLeft',
            zindex: 1100,
            pauseOnHover: false,
          });
        } else {
          Delete(name);
        }
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
              data: "function=Delete&age=" + id + "//,//notice",
              cache: false, //不缓存此页面   
              success: function(data) {
                if (data == "true") {
                  CanClick("/Admin/notice.php");
                  iziToast.success({
                    title: '成功',
                    message: '您所选择的公告已经成功清除',
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
          $('#noticeModal input[name=noticeID]').val(id);
          str = $('td[rel=' + id + ']').text().replace(/(^\s*)|(\s*$)/g, "");
          if (str == ">>>该条公告暂无内容<<<") {
            str = "";
          }
          var name = name.text();
          $('#noticeModal textarea[name=noticeContent]').val(str);
          $('#noticeModal').modal('show');
          $('#noticeButton').click(function() {
            str = $('#noticeModal textarea[name=noticeContent]').val();
            time = $('#noticeModal input[name=noticeDate]').val()
            $('#noticeButton').unbind("click");
            $.ajax({
              type: "POST",
              url: "/ajax.php",
              data: "function=Notice&age=" + id + "//,//" + str + "//,//" + time,
              cache: false, //不缓存此页面   
              success: function(data) {
                if (data == "true") {
                  CanClick("/Admin/notice.php");
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
            $('#noticeModal').modal('hide');
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
            message: '您未选中任何一条想要清除的公告',
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
              data: "function=DeleteAll&age=" + values + "//,//notice",
              cache: false, //不缓存此页面  
              success: function(data) {
                if (data == "true") {
                  CanClick("/Admin/notice.php");
                  iziToast.success({
                    title: '成功',
                    message: '您所选择的' + arr.length + '条公告已经成功清除',
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