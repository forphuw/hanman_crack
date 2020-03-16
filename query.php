<?php
require_once('./php_fun.php');
$type = $_GET['tp'];
$keyword = $_GET['wd'];
if(!isset($type)){
    echo "请输入访问类型";
    exit;
}
header("Content-Type: text/json;charset=utf-8");
date_default_timezone_set("Asia/Shanghai");

/*	get_search_json()
// @param{url:请求网址，带关键字}
   @return 统一返回json格式
*/
function get_search_json($url){
    $headerArray =array("Host: xxmh60.com","Connection: keep-alive","Cache-Control: max-age=0","Upgrade-Insecure-Requests: 1","DNT: 1","User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36","Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8","Accept-Language: zh-CN,zh;q=0.9");
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch,CURLOPT_HTTPHEADER,$headerArray);
    //curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
    $output = curl_exec($ch);
    curl_close($ch);
    $json = json_decode($output,true);
      
    return $json;
  }
  
  $kw = urlencode($keyword);
  $url="";
  switch($type){
    case "ml":
        $url="http://xxmh60.com/home/query/directory/?bookId=".$kw;
        break;
    default:
        exit;
  }

$json = json_encode(get_search_json($url));
echo $json;

//check if save this json to file
$dirname = './manhua/'.$keyword."/";
$filename = $keyword."-mulu.json";
if(!is_dir($dirname)){
    //if no this direct, create it , and get it from web
    createfile($dirname);
    //and write json to it
    file_put_contents($dirname."".$filename, $json);
}else{
    //if this direct exists, just write json to file
    file_put_contents($dirname."".$filename, $json);
}
?>
