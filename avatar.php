<?php
if (!empty($_FILES['avatar_file']['tmp_name'])) {
    //拿到图片后缀名
    $str = strrchr($_FILES['avatar_file']['type'], "/");
    $postfix = preg_replace('/\//', ".", $str);
    $source = "./tmp/" . uniqid('tmp') . $postfix;
    move_uploaded_file($_FILES['avatar_file']['tmp_name'], $source);
    session_start();
    $username = $_SESSION['username'];
    $dst_img = './Uploads/avatar/' . $username . '.png';
    $percent = 1;  #原图压缩，不缩放
    $post = json_decode($_POST['avatar_data'], true);
    $image = (new imgcompress($source, $percent, $post['x'], $post['y'], $post['width'], $post['height']))->compressImg($dst_img);
    $conn = MySQL();
    $conn->query("UPDATE user_center SET avatar = '/Uploads/avatar/$username.png' WHERE username_t LIKE '$username'");
    echo "true";
}

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

class imgcompress
{

    private $src;
    private $image;
    private $imageinfo;
    private $percent = 0.5;
    private $x, $y;
    private $w, $h;
    /**
     * 图片压缩
     * @param $src 源图
     * @param float $percent  压缩比例
     */
    public function __construct($src, $percent = 1, $x, $y, $w, $h)
    {
        $this->src = $src;
        $this->percent = $percent;
        $this->x = $x;
        $this->y = $y;
        $this->w = $w;
        $this->h = $h;
    }


    /** 高清压缩图片
     * @param string $saveName  提供图片名（可不带扩展名，用源图扩展名）用于保存。或不提供文件名直接显示
     */
    public function compressImg($saveName = '')
    {
        $this->_openImage();
        if (!empty($saveName)) $this->_saveImage($saveName);  //保存
        else $this->_showImage();
    }

    /**
     * 内部：打开图片
     */
    private function _openImage()
    {
        list($width, $height, $type, $attr) = getimagesize($this->src);
        $this->imageinfo = array(
            'width' => 300,
            'height' => 300,
            'type' => image_type_to_extension($type, false),
            'attr' => $attr
        );
        $fun = "imagecreatefrom" . $this->imageinfo['type'];
        $this->image = $fun($this->src);
        $this->_thumpImage();
    }
    /**
     * 内部：操作图片
     */
    private function _thumpImage()
    {
        $new_width = $this->imageinfo['width'] * $this->percent;
        $new_height = $this->imageinfo['height'] * $this->percent;
        $image_thump = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($image_thump, $this->image, 0, 0, $this->x, $this->y, $new_width, $new_height, $this->w, $this->h);
        imagedestroy($this->image);
        $this->image = $image_thump;
    }
    /**
     * 输出图片:保存图片则用saveImage()
     */
    private function _showImage()
    {
        header('Content-Type: image/' . $this->imageinfo['type']);
        $funcs = "image" . $this->imageinfo['type'];
        $funcs($this->image);
    }
    /**
     * 保存图片到硬盘：
     * @param  string $dstImgName  1、可指定字符串不带后缀的名称，使用源图扩展名 。2、直接指定目标图片名带扩展名。
     */
    private function _saveImage($dstImgName)
    {
        if (empty($dstImgName)) return false;
        $allowImgs = ['.jpg', '.jpeg', '.png', '.bmp', '.wbmp', '.gif'];
        $dstExt =  strrchr($dstImgName, ".");
        $sourseExt = strrchr($this->src, ".");
        if (!empty($dstExt)) $dstExt = strtolower($dstExt);
        if (!empty($sourseExt)) $sourseExt = strtolower($sourseExt);
        //有指定目标名扩展名
        if (!empty($dstExt) && in_array($dstExt, $allowImgs)) {
            $dstName = $dstImgName;
        } elseif (!empty($sourseExt) && in_array($sourseExt, $allowImgs)) {
            $dstName = $dstImgName . $sourseExt;
        } else {
            $dstName = $dstImgName . $this->imageinfo['type'];
        }
        $funcs = "image" . $this->imageinfo['type'];
        $funcs($this->image, $dstName);
    }

    /**
     * 销毁图片
     */
    public function __destruct()
    {
        imagedestroy($this->image);
        unlink($this->src);
    }
}
