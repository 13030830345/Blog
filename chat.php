<?php
$servername = "localhost";
$sql_username = "root";
$qsl_password = "";
$dbname = "blog";
$conn = new mysqli($servername, $sql_username, $qsl_password, $dbname);
$conn->query("set names utf8");
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM user_center WHERE username_t LIKE '$username'";
    $result = $conn->query($sql);
    $result->num_rows > 0;
    $row = $result->fetch_assoc();
    $uid = $row['id'];
}
if (isset($uid)) {
    $sql = "SELECT * FROM (SELECT chat.id,chat.content,chat.date,chat.user_id,user_center.username_t,user_center.avatar
    FROM chat INNER JOIN user_center ON chat.user_id = user_center.id ORDER BY chat.date DESC LIMIT 0,5) AS T ORDER BY date ASC";
    $result = $conn->query($sql);
    $i = 1;
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $can = $row['user_id'] == $uid ?>
            <div class="chatInfo <?php if ($result->num_rows == $i) echo "chatInfo-noBorder" ?>">
                <div class="comment-avatar" <?php if ($can) echo 'style="float:right"' ?>>
                    <?php if ($row['avatar'] != "") { ?>
                        <img class="avatar" src="<?php echo $row['avatar'] ?>" alt="" />
                    <?php } else { ?>
                        <svg data-jdenticon-value="<?php echo $row['username_t'] ?>"></svg>
                    <?php } ?>
                </div>
                <div class="comment-main" <?php if ($can) echo 'style="float:right;margin-right: 10px"' ?>>
                    <?php if ($can) { ?>
                        <p style="text-align: right"><span class="time">(<?php echo $row['date'] ?>)</span><?php echo $row['username_t'] ?><br /><?php echo $row['content'] ?></p>
                    <?php } else { ?>
                        <p><?php echo $row['username_t'] ?><span class="time">(<?php echo $row['date'] ?>)</span><br /><?php echo $row['content'] ?></p>
                    <?php } ?>
                </div>
            </div>
            <?php
            if ($can) echo '<div class="clearFloat"></div>';
            $i++;
        }
    }
}
?>