<?php


//Ajax方法和参数解析
$func = $_REQUEST["function"];
if (function_exists($func)) {
    $fs = isset($_REQUEST["age"]) ? explode("//,//", $_REQUEST["age"]) : array();
    echo call_user_func_array($func, $fs);
}


//Ajax调用方法
function Login($name, $password, $admin = 'none')
{
    $name = preg_replace('# #', '', $name);
    $password = preg_replace('# #', '', $password);
    $conn = MySQL();
    $sql = "SELECT * FROM user_center WHERE username_t LIKE '$name'";
    if ($admin == "admin") {
        $sql = $sql . " AND id = 1";
    }
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $password = md5($password . $row['password_offset']);
        if ($password  == $row['password_t']) {
            session_start();
            $_SESSION['username'] = $name;
            $_SESSION['login'] = true;
            $_SESSION['showToast'] = true;
            $id = $row['id'];
            if ($id == 1) {
                $_SESSION['showAdminToast'] = true;
            }
            $_SESSION['login_time'] = $row['login_time'];
            $_SESSION['login_ip'] = $row['login_ip'];
            $loginTimes = (int)$row['login_times'] + 1;
            date_default_timezone_set("Etc/GMT-8");
            $time = date("Y-m-d H:i:s");
            $ip = getIp();
            $browse_info = browse_info();
            $os = get_login_os();
            $city = getCity($ip);
            $sql = "UPDATE user_center SET login_time = '$time', login_times = '$loginTimes', login_ip = '$ip',login_browse = '$browse_info',login_os = '$os' ,login_city = '$city' WHERE id = $id";
            $result = $conn->query($sql);
            $result = $conn->query("INSERT INTO `login_log`(`user_id`, `time`) VALUES ('$id','$time')");
            return  "true";
        }
    } else if ($admin == "admin")
        return  "NoAdmin";
}
function Logout()
{
    session_start();
    if (isset($_SESSION['username']))   unset($_SESSION['username']);
    if (isset($_SESSION['login']))  $_SESSION['login'] = false;
    if (isset($_SESSION['showToast']))  $_SESSION['showToast'] = true;
    if (isset($_SESSION['login_time']))   unset($_SESSION['login_time']);
    if (isset($_SESSION['login_ip']))   unset($_SESSION['login_ip']);
    return  "true";
}
function Setting(
    $WebSite_Title,
    $WebSite_Subtitle,
    $WebSite_Url,
    $WebSite_Keywords,
    $WebSite_Description,
    $WebSite_Email,
    $WebSite_ICP,
    $WebSite_Copyright,
    $WebSite_LoginOut
) {
    $WebSite_Title = "define('WebSite_Title', '$WebSite_Title');\n";
    $WebSite_Subtitle = "define('WebSite_Subtitle', '$WebSite_Subtitle');\n";
    $WebSite_Url = "define('WebSite_Url', '$WebSite_Url');\n";
    $WebSite_Keywords = "define('WebSite_Keywords', '$WebSite_Keywords');\n";
    $WebSite_Description = "define('WebSite_Description', '$WebSite_Description');\n";
    $WebSite_Email = "define('WebSite_Email', '$WebSite_Email');\n";
    $WebSite_ICP = "define('WebSite_ICP', '$WebSite_ICP');\n";
    $WebSite_Copyright = "define('WebSite_Copyright', '$WebSite_Copyright');\n";
    $WebSite_LoginOut = "define('WebSite_LoginOut', '$WebSite_LoginOut');\n";
    $string = "<?php\n $WebSite_Title $WebSite_Subtitle $WebSite_Url $WebSite_Keywords $WebSite_Description $WebSite_Email $WebSite_ICP $WebSite_Copyright $WebSite_LoginOut";
    file_put_contents('./config.php', $string);
    return  "true";
}
function ReadSet($show_num, $page_num, $carousel_num, $hot_num, $category_num, $Live2Ds, $ones)
{
    $show_num = "define('WebSite_show_num', '$show_num');\n";
    $page_num = "define('WebSite_page_num', '$page_num');\n";
    $carousel_num = "define('WebSite_carousel_num', '$carousel_num');\n";
    $hot_num = "define('WebSite_hot_num', '$hot_num');\n";
    $category_num = "define('WebSite_category_num', '$category_num');\n";
    $Live2Ds = "define('WebSite_Live2Ds', '$Live2Ds');\n";
    $ones = "define('WebSite_ones', '$ones');\n";
    $string = "<?php\n $show_num $page_num $carousel_num $hot_num $category_num $Live2Ds $ones";
    file_put_contents('./config_read.php', $string);
    return  "true";
}
function Reg($name, $password)
{
    $name = preg_replace('# #', '', $name);
    $password = preg_replace('# #', '', $password);
    $conn = MySQL();
    $pw = $password;
    // $sql = "SELECT * FROM user_center WHERE upper(username_t) LIKE upper('$name')";
    $sql = "SELECT * FROM user_center WHERE username_t LIKE '$name'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0)
        return "该用户名已被使用..";
    else {
        $md5 =  md5(time() . mt_rand(1, 1000000));
        $md5 = substr($md5, 4, 4) . substr($md5, 12, 4);
        $password = md5($password . $md5);
        $loginTimes = 0;
        date_default_timezone_set("Etc/GMT-8");
        $time = date("Y-m-d H:i:s");
        $sql = "INSERT INTO user_center 
        (username_t, password_t, password_offset,login_time,login_times)
         VALUES ('$name','$password','$md5','$time','$loginTimes')";
        $conn->query($sql);
        Login($name, $pw);
        return "true";
    }
}
function Comment($articleId, $userId, $content)
{
    $conn = MySQL();
    date_default_timezone_set("Etc/GMT-8");
    $time = date("Y-m-d H:i:s");
    $sql = "INSERT INTO comment (content, date, article_id,user_id) VALUES ('$content','$time','$articleId','$userId')";
    $conn->query($sql);
    return  "true";
}
function Delete($id, $table)
{
    $conn = MySQL();
    if ($table == "notice") {
        if ($conn->query("UPDATE `notice` SET `content`= '',`date`='9999-00-00' WHERE `id` = $id"))
            return "true";
    } else if ($table == "classify") {
        $name =  $conn->query("SELECT name FROM `classify` WHERE id = $id")->fetch_assoc()['name'];
        if ($conn->query("UPDATE $table SET `name`= '' WHERE `$table`.`id` = $id"))
            if ($conn->query("DELETE FROM article WHERE classify LIKE '$name'"))
                return "true";
    } else {
        if ($table == "user_center") {
            if ($conn->query("DELETE FROM `comment` WHERE `user_id` = $id"));
        }
        if ($table == "article") {
            if ($conn->query("DELETE FROM `comment` WHERE `article_id` = $id"));
        }
        if ($conn->query("DELETE FROM $table WHERE `$table`.`id` = $id"))
            return "true";
    }
}
function Notice($id, $content, $date)
{
    $conn = MySQL();
    if ($conn->query("UPDATE `notice` SET `content`= '$content',`date`='$date' WHERE `id` = $id"))
        return "true";
}
function Category($id, $name)
{
    $conn = MySQL();
    if ($conn->query("UPDATE `classify` SET `name`= '$name' WHERE `id` = $id"))
        return "true";
}
function DeleteAll($id, $table)
{
    $conn = MySQL();
    if ($table == "notice") {
        if ($conn->query("UPDATE `notice` SET `content`= '',`date`='0000-00-00' WHERE id IN ($id)"))
            return "true";
    } else {
        if ($conn->query("DELETE FROM $table WHERE id IN ($id)"))
            return "true";
    }
}
function AdminInfo($username, $old_password, $password, $id = 1, $user = 0)
{
    $conn = MySQL();
    $row = $conn->query("SELECT `password_t`,`password_offset` FROM `user_center` WHERE `id` = $id")->fetch_assoc();
    $password = md5($password . $row['password_offset']);
    if (md5($old_password . $row['password_offset']) == $row['password_t'] || ($id != 1 && $user = 0))
        if ($conn->query("UPDATE user_center SET username_t = '$username', password_t = '$password' WHERE id = $id")) {
            if ($id == 1 || $user != 0) Logout();
            return "true";
        }
}
function AddChat($chatContent, $userId)
{
    $conn = MySQL();
    date_default_timezone_set("Etc/GMT-8");
    $time = date("Y-m-d H:i:s");
    $sql = "INSERT INTO chat (content, date, user_id) VALUES ('$chatContent','$time','$userId')";
    $conn->query($sql);
    return  "true";
}


//非Ajax调用方法：

//数据库连接
function MySQL()
{
    $servername = "localhost";
    $sql_username = "root";
    $qsl_password = "";
    $dbname = "blog";
    $conn = new mysqli($servername, $sql_username, $qsl_password, $dbname);
    $conn->query("set names utf8");
    // Check connection
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    }
    return $conn;
}

//获取访问者ip地址
function getIp()
{
    if ($_SERVER['REMOTE_ADDR']) {
        $cip = $_SERVER['REMOTE_ADDR'];
    } elseif (getenv("REMOTE_ADDR")) {
        $cip = getenv("REMOTE_ADDR");
    } elseif (getenv("HTTP_CLIENT_IP")) {
        $cip = getenv("HTTP_CLIENT_IP");
    } else {
        $cip = "unknown";
    }
    return $cip == "::1" ? "127.0.0.1" : $cip;
}
function getCity($ip) //获取地区
{
    $url = "http://ip.taobao.com/service/getIpInfo.php?ip=" . $ip; //淘宝借口需要填写ip
    $ip = json_decode(file_get_contents($url), true);
    $region = $ip['data']['region'];
    $city = $ip['data']['city'];
    $isp = $ip['data']['isp'];
    return  $region == $city ? $city . "市 " . $isp : $region . "省 " . $city . "市 " . $isp;
}
//获取系统
function get_login_os()
{
    $agent = $_SERVER['HTTP_USER_AGENT'];
    $os = false;
    if (preg_match('/win/i', $agent) && strpos($agent, '95')) {
        $os = 'Windows 95';
    } else if (preg_match('/win 9x/i', $agent) && strpos($agent, '4.90')) {
        $os = 'Windows ME';
    } else if (preg_match('/win/i', $agent) && preg_match('/98/i', $agent)) {
        $os = 'Windows 98';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 6.0/i', $agent)) {
        $os = 'Windows Vista';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 6.1/i', $agent)) {
        $os = 'Windows 7';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 6.2/i', $agent)) {
        $os = 'Windows 8';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 10.0/i', $agent)) {
        $os = 'Windows 10';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 5.1/i', $agent)) {
        $os = 'Windows XP';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 5/i', $agent)) {
        $os = 'Windows 2000';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt/i', $agent)) {
        $os = 'Windows NT';
    } else if (preg_match('/win/i', $agent) && preg_match('/32/i', $agent)) {
        $os = 'Windows 32';
    } else if (preg_match('/linux/i', $agent)) {
        $os = 'Linux';
    } else if (preg_match('/unix/i', $agent)) {
        $os = 'Unix';
    } else if (preg_match('/sun/i', $agent) && preg_match('/os/i', $agent)) {
        $os = 'SunOS';
    } else if (preg_match('/ibm/i', $agent) && preg_match('/os/i', $agent)) {
        $os = 'IBM OS/2';
    } else if (preg_match('/Mac/i', $agent) && preg_match('/PC/i', $agent)) {
        $os = 'Macintosh';
    } else if (preg_match('/PowerPC/i', $agent)) {
        $os = 'PowerPC';
    } else if (preg_match('/AIX/i', $agent)) {
        $os = 'AIX';
    } else if (preg_match('/HPUX/i', $agent)) {
        $os = 'HPUX';
    } else if (preg_match('/NetBSD/i', $agent)) {
        $os = 'NetBSD';
    } else if (preg_match('/BSD/i', $agent)) {
        $os = 'BSD';
    } else if (preg_match('/OSF1/i', $agent)) {
        $os = 'OSF1';
    } else if (preg_match('/IRIX/i', $agent)) {
        $os = 'IRIX';
    } else if (preg_match('/FreeBSD/i', $agent)) {
        $os = 'FreeBSD';
    } else if (preg_match('/teleport/i', $agent)) {
        $os = 'teleport';
    } else if (preg_match('/flashget/i', $agent)) {
        $os = 'flashget';
    } else if (preg_match('/webzip/i', $agent)) {
        $os = 'webzip';
    } else if (preg_match('/offline/i', $agent)) {
        $os = 'offline';
    } else if (preg_match('/iPhone OS 8/i', $agent)) {
        $os = 'iOS 8';
    } else if (preg_match('/YisouSpider/i', $agent)) {
        $os = '一搜引擎';
    } else if (preg_match('/Yahoo! Slurp/i', $agent)) {
        $os = '雅虎引擎';
    } else if (preg_match('/iPhone OS 6/i', $agent)) {
        $os = 'iOS 6';
    } else if (preg_match('/Baiduspider/i', $agent)) {
        $os = '百度引擎';
    } else if (preg_match('/iPhone OS 10/i', $agent)) {
        $os = 'iOS 10';
    } else if (preg_match('/Mac OS X 10/i', $agent)) {
        $os = 'Mac OS 10';
    } else if (preg_match('/Ahrefs/i', $agent)) {
        $os = 'Ahrefs SEO 引擎';
    } else if (preg_match('/JikeSpider/i', $agent)) {
        $os = '即刻引擎';
    } else if (preg_match('/Googlebot/i', $agent)) {
        $os = '谷歌引擎';
    } else if (preg_match('/bingbot/i', $agent)) {
        $os = '必应引擎';
    } else if (preg_match('/iPhone OS 7/i', $agent)) {
        $os = 'iOS 7';
    } else if (preg_match('/Sogou web spider/i', $agent)) {
        $os = '搜狗引擎';
    } else if (preg_match('/IP-Guide.com Crawler/i', $agent)) {
        $os = 'IP-Guide Crawler 引擎';
    } else if (preg_match('/VenusCrawler/i', $agent)) {
        $os = 'VenusCrawler 引擎';
    } else {
        $os = $agent;
    }
    return $os;
}

//获得访问者浏览器
function browse_info()
{
    if (!empty($_SERVER['HTTP_USER_AGENT'])) {
        $br = $_SERVER['HTTP_USER_AGENT'];
        if (preg_match('/MSIE/i', $br)) {
            $br = 'MSIE';
        } else if (preg_match('/Firefox/i', $br)) {
            $br = 'Firefox';
        } else if (preg_match('/Chrome/i', $br)) {
            $br = 'Chrome';
        } else if (preg_match('/Safari/i', $br)) {
            $br = 'Safari';
        } else if (preg_match('/Opera/i', $br)) {
            $br = 'Opera';
        } else {
            $br = 'Other';
        }
        return $br;
    } else {
        return 'unknown';
    }
}
