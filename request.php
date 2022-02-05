<?php
include 'config.php';
error_reporting(E_ALL);

$input = $_REQUEST;
$data = array();
$dir = __DIR__."/img";

function isStart($str, $substr)
{
    $result = strpos($str, $substr);
    if ($result === 0) {
        return true;
    } else {
        return false;
    }
}

function save_image($inPath,$outPath)
{ //Download images from remote server
    $in=    fopen($inPath, "rb");
    $out=   fopen($outPath, "wb");
    while ($chunk = fread($in,8192))
    {
        fwrite($out, $chunk, 8192);
    }
    fclose($in);
    fclose($out);
}


if($input['act'] == 'addNewBook'){
    $name = isset($input['name'])?$input['name']:'';
    $descr = isset($input['descr'])?$input['descr']:'';
    $image = isset($input['image'])?$input['image']:'';
    $authors = isset($input['authors'])?$input['authors']:'';

    $sql = ("INSERT INTO `books_lib`(`name`, `descr`, `image`,`authors`,`date_ins`) VALUES(?,?,?,?,now())");

    $query = $pdo->prepare($sql);
    $query->execute([$name, $descr, $image, $authors]);

    if($image != ''){
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        if(isStart($image, 'https://')){
            $arr = explode( '/', $image);
            $ref =$arr[count($arr)-1];
            save_image($image,__DIR__.'/img/'.$ref);
        }
    }

    $data['state'] = 'SUCCESS';
}else if($input['act'] == 'editBook'){
    $id = $input['id'];
    $name = isset($input['name'])?$input['name']:'';
    $descr = isset($input['descr'])?$input['descr']:'';
    $image = isset($input['image'])?$input['image']:'';
    $authors = isset($input['authors'])?$input['authors']:'';


    $sql = ("UPDATE books_lib SET name=?, descr=?, image=?, authors=? WHERE id=?");

    $query = $pdo->prepare($sql);
    $query->execute([$name, $descr, $image, $authors,$id]);
    $data['state'] = 'SUCCESS';
}

$data = json_encode($data);

die($data);