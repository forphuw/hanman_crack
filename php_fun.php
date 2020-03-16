<?php
    //创建目录
/*
   *  @param  createfile //创建文件夹
   *  @param  createpath  // 创建的路径
   *  @param  file_exists() // 查看是否文件夹有同样的目录
   *  @param  file // 创建的的路径 基于文件夹 ./Public/Uploads/  下创建修改
   *  @param  mkdir // 创建文件夹的函数
   *  @param 2017/11/20  8:57
   */
 function createfile($path){
 
    $createpath = $path;
    $_createpath = iconv('utf-8', 'gb2312', $createpath);
    if (file_exists($_createpath) == false)
    {
        //检查是否有该文件夹，如果没有就创建，并给予最高权限
        if (mkdir($_createpath, 0700, true)) {
            $value['file'] ='文件夹创建成功';
            $value['state']='success';
        } else {
            $value['file'] ='文件夹创建失败';
            $value['state']='fail';
        }
    }
    else
    {
        $value['file'] ='文件夹已存在';
        $value['state']='fail';
    }
    return $value;
}
?>
