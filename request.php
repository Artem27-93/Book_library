<?php
include 'config.php';
include 'main.php';

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

    $data['state'] = 'SUCCESS';

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


}else if($input['act'] == 'addNewAuthor') {
    $name = isset($input['name']) ? $input['name'] : '';
    $surname = isset($input['surname']) ? $input['surname'] : '';
    $patronymic = isset($input['patronymic']) ? $input['patronymic'] : '';

    $sql = ("INSERT INTO `authors`(`name`, `surname`, `patronymic`) VALUES(?,?,?)");

    $query = $pdo->prepare($sql);
    $query->execute([$name, $surname, $patronymic]);


    $sql = $pdo->prepare("SELECT * FROM `authors` ORDER BY id DESC");
    $sql->execute();
    $result = $sql->fetchAll();
    $countArr = count($result[0]);
    $nextRow = ++$countArr + 1;
    $id_create = $result[0]['id'];
    $table = '<tr class="">
                            <td class="num_str">'.$nextRow.'</td>
                            <td>'.$name.'</td>
                            <td>'.$surname.'</td>
                            <td>'.$patronymic.'</td>
                            <td>
                                <div style="display: flex;align-items: center;flex-direction: column;">
                                    <a href="?edit='.$id_create.'" class="btn btn-success btn-sm" data-toggle="modal" data-target="#editModalAuth'.$id_create.'"><i class="fa fa-edit"></i></a>
                                    <a href="?delete='.$id_create.'" style="margin-top: 10px;" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModalAuth'.$id_create.'"><i class="fa fa-trash"></i></a>
                                </div>
                                
                                
<div class="modal fade" id="editModalAuth'.$id_create.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Редактировать запись № '.$nextRow.'</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" data-num="'.$id_create.'">
                <div class="form-group">
                    <input type="text" class="form-control edit_name"  value="'.$name.'" placeholder="Имя">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control edit_surname" value="'.$surname.'" placeholder="Фамилия">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control edit_patronymic"  value="'.$patronymic.'" placeholder="Отчество">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" onclick="updateRow(this, \'authors\');">Обновить</button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="deleteModalAuth'.$id_create.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Удалить запись № '.$nextRow.'</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button name="" onclick="deleteRow('.$id_create.', \'authors\');" class="btn btn-danger">Удалить</button>

            </div>
        </div>
    </div>
</div>

                                   
                            </td>
                        </tr>';

    $data['state'] = 'SUCCESS';
    $data['table'] = $table;
}else if($input['act'] == 'editBook'){
    $id = $input['id'];
    $table = $input['table'];
    $name = isset($input['name'])?$input['name']:'';
    $descr = isset($input['descr'])?$input['descr']:'';
    $image = isset($input['image'])?$input['image']:'';
    $authors = isset($input['authors'])?$input['authors']:'';


    $sql = ("UPDATE $table SET name=?, descr=?, image=?, authors=? WHERE id=?");

    $query = $pdo->prepare($sql);
    $query->execute([$name, $descr, $image, $authors,$id]);
    $data['state'] = 'SUCCESS';
}else if($input['act'] == 'editAuthors') {
    $id = $input['id'];
    $table = $input['table'];
    $name = isset($input['name'])?$input['name']:'';
    $surname = isset($input['surname'])?$input['surname']:'';
    $patronymic = isset($input['patronymic'])?$input['patronymic']:'';

    $sql = ("UPDATE $table SET name=?, surname=?, patronymic=? WHERE id=?");

    $query = $pdo->prepare($sql);
    $query->execute([$name, $surname, $patronymic,$id]);

    $data['state'] = 'SUCCESS';


}else if($input['act'] == 'deleteBook'){
    $id = $input['id'];
    $table = $input['table'];
    $sql = "DELETE FROM $table WHERE id=?";
    $query = $pdo->prepare($sql);
    $query->execute([$id]);
    $data['state'] = 'SUCCESS';
}else if($input['act'] == 'deleteAuthors'){
    $id = $input['id'];
    $table = $input['table'];
    $sql = "DELETE FROM $table WHERE id=?";
    $query = $pdo->prepare($sql);
    $query->execute([$id]);
    $data['state'] = 'SUCCESS';
}else if($input['act'] == 'getListAuthors'){
    $sql = $pdo->prepare("SELECT * FROM `authors`");
    $sql->execute();
    $result = $sql->fetchAll();

    $list = '<input class="form-control authors" name="authors" list="autors_list" placeholder="Введите автора или выберите из списка.." />
<datalist id="autors_list">';
    foreach ($result as $key => $value){
        $list .= '<option>'.$value['surname'].' '.$value['name'].' '.$value['patronymic'].'</option>';
    }
    $list .= '</select>';
    $data['state'] = 'SUCCESS';
    $data['result'] = $list;

}

$data = json_encode($data);

die($data);