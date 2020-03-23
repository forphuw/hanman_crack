<?php
set_time_limit(0);
require_once('./php_fun.php');
$ido = $_GET['oid'];//chapter
$id = $_GET['id'];//pages
//global various
//$userName = "8201391bb";//
$userName = "d".substr(md5(time()),0,9);//73a2ba79d
echo $userName." | ";
$urlreg = "http://xxmh60.com/user/register?userName=".$userName."&password=123456";
$urllogin = "http://xxmh60.com/user/login?userName=".$userName."&password=123456";
$urlqiandao = "http://xxmh60.com/user/getBillingAccount/qiandao";
$urlbuy = "http://xxmh60.com/user/order/submit?bookId=".$ido."&chapterId=".$id;
$urlimglist ="http://xxmh60.com/home/query/chapter?bookId=".$ido."&chapterId=".$id;


class CurlLoginCookie
{
    public $imglistA = array();
    public $token = "11ad976a2770e4ebc0f9426e4b4f65b9";
    public $printStr = array();
    //注册接口，先注册
    public function register()
    {
        $re = $this->post_curl($GLOBALS['urlreg'], [], 1);
      $json = json_decode($re,true);
      $this->token = $json['content']['token'];
      $this->printStr['register'] = $json['code']."-".$json['msg']."-".$this->token." | ";
      echo $this->printStr['register'];
    }
//登录接口，获取cookie
    public function userdetail()
    {
        $re = $this->post_curl("http://xxmh60.com/user/detail?ticket=", []);
      	$json = json_decode($re,true);
          $ct = 0;
          while($json['code']!=200)
          {
            $re = $this->post_curl("http://xxmh60.com/user/detail?ticket=", [],1);
      	    $json = json_decode($re,true);
              sleep(1);
              $ct++;
              if($ct>5)
                break;
          }
      	$this->token = $json['content']['token'];
      	$this->printStr['userdetail'] = $json['code']."-".$json['msg']."-".$this->token." | ";
          echo $this->printStr['userdetail'];
    }
    //登录接口，获取cookie
    public function login()
    {
        $re = $this->post_curl($GLOBALS['urllogin'], [],1);
      	$json = json_decode($re,true);
          $ct = 0;
          while($json['code']!=200)
          {
            $re = $this->post_curl($GLOBALS['urllogin'], [],1);
      	    $json = json_decode($re,true);
              sleep(1);
              $ct++;
              if($ct>5)
                break;
          }
      	$this->token = $json['content']['token'];
      	$this->printStr['login'] = $json['code']."-".$json['msg']."-".$this->token." | ";
          echo $this->printStr['login'];
    }
	//执行登录后的签到
    public function qiandao()
    {
        $ct=0;
        $re = $this->post_curl($GLOBALS['urlqiandao'],[]);

        $json = json_decode($re, true);
        while($json['code']!=200)
          {
            $re = $this->post_curl($GLOBALS['urlqiandao'],[]);
      	    $json = json_decode($re,true);
              sleep(1);
              $ct++;
              if($ct>5)
                break;
          }
		$this->printStr['qiandao'] = $json['code']."-qiaodao ".$json['msg']." | ";
        echo $this->printStr['qiandao'];
        //var_dump($re);
    }
    //执行登录后的购买
    public function buy()
    {
        $ct=0;
        $re = $this->post_curl($GLOBALS['urlbuy'],[]);

        $json = json_decode($re, true);
        while($json['code']!=200)
          {
            $re = $this->post_curl($GLOBALS['urlbuy'],[]);
      	    $json = json_decode($re,true);
              sleep(1);
              $ct++;
              if($ct>5)
                break;
          }
		$this->printStr['buy'] = $json['code']."-buy ".$json['msg']." | ";
        echo $this->printStr['buy'];
        //var_dump($re);
    }
    //获得图片list
    public function getImgList(){
        $ct=0;
        $re = $this->post_curl($GLOBALS['urlimglist'],[]);
      //var_dump($re);
      $json = json_decode($re,true);
      while($json['code']!=200)
          {
            $re = $this->post_curl($GLOBALS['urlimglist'],[]);
      	    $json = json_decode($re,true);
              sleep(1);
              $ct++;
              if($ct>5)
                break;
          }
        $this->imglistA = $json;
      $this->printStr['getImgList'] = $json['code']."-imgs ".$json['msg']." | ";
      echo $this->printStr['getImgList'];
    }
    //发送请求
    function post_curl($url, $params=[], $needtoken=0){
      if($needtoken){//only register or login
      	$headerArray =array("User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36","DNT: 1","Content-Type: text/plain;charset=UTF-8","Accept: */*","Referer: http://xxmh60.com/","Accept-Language: zh-CN,zh;q=0.9");
      }else{
        $headerArray =array("ticket: ".$this->token,"User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36","DNT: 1","Content-Type: text/plain;charset=UTF-8","Accept: */*","Referer: http://xxmh60.com/","Accept-Language: zh-CN,zh;q=0.9","Cookie:PHPSESSID=".substr(md5(time()),0,26)."; ticket=".$this->token);
    }
      $ch = curl_init();

        curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
        
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 30 );
        curl_setopt( $ch, CURLOPT_TIMEOUT , 30);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
		curl_setopt($ch,CURLOPT_HTTPHEADER,$headerArray);
      
        curl_setopt( $ch , CURLOPT_POST , true );
        curl_setopt( $ch , CURLOPT_POSTFIELDS , http_build_query($params));
  
        curl_setopt( $ch , CURLOPT_URL , $url );

        $response = curl_exec( $ch );
      	curl_close($ch);
      	//var_dump($response);
        if ($response === FALSE) {
          return false;
        }
        return $response;
    }

    //启动
    public function start()
    {
        try{
            $this->register();
            //$this->login();
            $this->userdetail();
            $this->qiandao();
            $this->buy();
            $this->getImgList();
        }catch(\Exception $e){
            print($e);
        }
    }

}



function getFromWeb($username){
    $myfile = fopen("users.html", "ab+");
            fwrite($myfile, $username."<br>");
    fclose($myfile);
    $obj = new CurlLoginCookie();
    $obj->start();
    $resA = $obj->imglistA;
    $printStrm = $obj->printStr;
    return [$resA,$printStrm];
    //var_dump($resA);
}
$resA = array();$getFromWeb1 = true;$printStr='';
//check if save this json to file
$dirname = './manhua/'.$ido."/";
$filename = $ido."-".$id.".json";
if(!is_dir($dirname)){
    //you should visit this page from readml.php first. so redirect to readml.php
    createfile($dirname);
    $res = getFromWeb($userName);
    $resA = $res[0];
    $printStr = $res[1];
    //and write json to it
    $json = json_encode($resA);
    file_put_contents($dirname."".$filename, $json);
}else{
    //if this direct exists, check the file is existed? and write to file
    if(!file_exists($dirname."".$filename)){
        $res = getFromWeb($userName);
        $resA = $res[0];
        $printStr = $res[1];
        //and write json to it
        $json = json_encode($resA);
        file_put_contents($dirname."".$filename, $json);
    }else{
        //the direct and file exsit, read this file
        $getFromWeb1 = false;
        $json = file_get_contents($dirname."".$filename);
        //change json to array
        $resA = json_decode($json,true);
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <!--声明文档兼容模式，表示使用IE浏览器的最新模式-->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!--设置视口的宽度(值为设备的理想宽度)，页面初始缩放值<理想宽度/可见宽度>-->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
  <title><?php echo $resA['content']['title'] ?></title>
  <link href="./images/logo.png" rel="icon" type="image/x-ico">
 
  <!-- 引入Bootstrap核心样式文件 -->
  <!-- 新 Bootstrap 核心 CSS 文件 -->
  <link href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?011528a62aaa2933a3a62bbe1af55f44";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>

</head>
<body>
 
<div class="container">
    <div class="row">
         <?php 
         //echo "用户:".$userName." 您好 | ";
           // if($getFromWeb1){foreach($obj->printStr as $val){echo $val;}}
         $i=0;
         foreach($resA['content']['imageList'] as $img){ $i++;if($i>3)break;?>
                <img width="100%" src="<?php echo $img['url']; ?>" >
                
        <?php } ?>
        
       
    </div>
</div>
<div id="bottom" class="text-center"><img id="loading" src="https://lzyxcf.com/res/loading.svg"><font id="endtext" style="display:none;">主人，你已经到底了～</font></div>
<script src="https://cdn.bootcss.com/jquery/3.4.1/jquery.min.js"></script>
<script>
var imgList = eval(<?php echo json_encode($resA['content']['imageList']);?>);
var nowindex = 2;//from 0 现在已经显示3张图片了
$(window).scroll(function(){
    //var h=$(document.body).height();//网页文档的高度
    var c = $(document).scrollTop();//滚动条距离网页顶部的高度
    var h=$("#bottom").offset().top;//id为div的元素距离网页顶部的距离
    if (h-c<680){
    //console.log("我已经到底部啦");
    addImg();
    }
})

function addImg(){
    var div = $(".row");
    for(i=0;i<3;i++){//一次显示3张图片
        nowindex++;
        if(nowindex==imgList.length){//图片已经显示完了
            $("#loading").css("display","none");
            $("#endtext").css("display","block");
            break;
        }
        div.append('<img width="100%" src="'+imgList[nowindex].url+'" >');
        
    }
    
}
</script>
</body>
</html>
