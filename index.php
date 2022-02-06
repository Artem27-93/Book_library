<?php
include 'main.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Books Library</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="functions.js?v=1.0.4"></script>
    <style>
        #tab-btn-1:checked~#content-1,
        #tab-btn-2:checked~#content-2
        {
            display: block;
        }


        .tabs>input[type="radio"] {
            display: none;
        }

        .tabs>div {
            /* скрыть контент по умолчанию */
            display: none;
            border: 1px solid #e0e0e0;
            padding: 10px 15px;
            font-size: 16px;
        }

        .tabs>label {
            display: inline-block;
            text-align: center;
            vertical-align: middle;
            user-select: none;
            background-color: #f5f5f5;
            border: 1px solid #e0e0e0;
            padding: 2px 8px;
            font-size: 16px;
            line-height: 1.5;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out;
            cursor: pointer;
            position: relative;
            top: 1px;
        }

        .tabs>label:not(:first-of-type) {
            border-left: none;
        }

        .tabs>input[type="radio"]:checked+label {
            background-color: #fff;
            border-bottom: 1px solid #fff;
        }


        .list {
            visibility: collapse;
        }
        .paginator {
            line-height: 150%;
        }
        .paginator > span {
            display: inline-block;
            margin-right: 10px;
            cursor: pointer;
        }
        .paginator_active {
            color: red;
        }

        .scale {
            transition: 0.8s; /* Время эффекта */
        }
        .scale:hover {
            transform: scale(1.5); /* Увеличиваем масштаб */
        }


    </style>
</head>
<body>
	<div class="container">
		<div class="row" style="margin-top: 25px">
            <div class="col mt-1 tabs">
                <input type="radio" name="tab-btn" id="tab-btn-1" value="" checked>
                <label for="tab-btn-1">Книги</label>
                <input type="radio" name="tab-btn" id="tab-btn-2" value="">
                <label for="tab-btn-2">Авторы</label>

			<div id="content-1">
                <div style="display: flex;justify-content: space-between">
				    <button class="btn btn-success mb-1" data-toggle="modal" data-target="#ModalBook" onclick="initSelect()"><i class="fa fa-user-plus"></i></button>
                    <button class="btn btn-primary" onclick="sortTable('books',1)">Сортировать по названию</button>
                </div>
                <input class="form-control" style="margin: 10px 0;" type="text" placeholder="Поиск по названию/автору" id="search-book" onkeyup="tableSearch('books',this,'search-book')">
				<table id="books" class="table shadow ">
					<thead class="thead-dark">
						<tr>
							<th>№</th>
							<th>Название</th>
							<th>Описание</th>
							<th>Картинка</th>
							<th>Автор</th>
							<th>Публикация</th>
                            <th></th>

						</tr>
                    </thead>
                        <tbody class="page">
						<?php

                        foreach ($result as $key => $value) { ?>
						<tr class="list">
                            <td class="num_str"><?=++$key ?></td>
							<td><?=$value['name'] ?></td>
							<td><?=$value['descr'] ?></td>
							<td><img class="scale" width="80px" height="80px" src="<?=$value['image'] ?>" alt="img#">
                            </td>
							<td><?=$value['authors'] ?></td>
							<td><?=$value['date_ins'] ?></td>
							<td>
                                <div style="display: flex;align-items: center;flex-direction: column;margin: 10px 0;">
                                    <a href="?edit=<?=$value['id'] ?>" class="btn btn-success btn-sm" data-toggle="modal" data-target="#editModal<?=$value['id'] ?>"><i class="fa fa-edit"></i></a>
                                    <a href="?delete=<?=$value['id'] ?>" style="margin-top: 10px;" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal<?=$value['id'] ?>"><i class="fa fa-trash"></i></a>
                                </div>
								<?php require 'modal1.php'; ?>
							</td>
						</tr> <?php } ?>
                    </tbody>
				</table>

                Страницы:
                <div class="paginator" onclick="pagination(event)"></div>


			</div>
            <div id="content-2">
                <div style="display: flex;justify-content: space-between">
                    <button class="btn btn-success mb-1" data-toggle="modal" data-target="#ModalAuthors"><i class="fa fa-user-plus"></i></button>
                    <button class="btn btn-primary" onclick="sortTable('authors',1)">Сортировать по имени</button>
                </div>
                <input class="form-control" style="margin: 10px 0;" type="text" placeholder="Поиск по имени/фамилии" id="search-author" onkeyup="tableSearch('authors',this,'search-author')">
                <table id="authors" class="table shadow ">
                    <thead class="thead-dark">
                    <tr>
                        <th>№</th>
                        <th>Имя</th>
                        <th>Фамилия</th>
                        <th>Отчество</th>
                        <th></th>

                    </tr>
                    </thead>
                    <tbody class="page">
                    <?php

                    foreach ($result_auth as $key => $value) { ?>
                        <tr class="">
                            <td class="num_str"><?=++$key ?></td>
                            <td><?=$value['name'] ?></td>
                            <td><?=$value['surname'] ?></td>
                            <td><?=$value['patronymic'] ?></td>
                            <td>
                                <div style="display: flex;align-items: center;justify-content: space-around;">
                                    <a href="?edit=<?=$value['id'] ?>" class="btn btn-success btn-sm" data-toggle="modal" data-target="#editModalAuth<?=$value['id'] ?>"><i class="fa fa-edit"></i></a>
                                    <a href="?delete=<?=$value['id'] ?>" style="" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModalAuth<?=$value['id'] ?>"><i class="fa fa-trash"></i></a>
                                </div>
                                    <?php require 'modal2.php'; ?>
                            </td>
                        </tr> <?php } ?>
                    </tbody>
                </table>
            </div>
		</div>
        </div>
	</div>

<script>
    var count = $('#books tbody>tr').length;//всего записей
    var cnt = 5; //сколько отображаем сначала
    var cnt_page = Math.ceil(count / cnt); //кол-во страниц

    //выводим список страниц
    var paginator = document.querySelector(".paginator");
    var page = "";
    for (var i = 0; i < cnt_page; i++) {
        page += "<span data-page=" + i * cnt + "  id=\"page" + (i + 1) + "\">" + (i + 1) + "</span>";
    }
    paginator.innerHTML = page;

    //выводим первые записи {cnt}
    var div_num = document.querySelectorAll(".list");
    for (var i = 0; i < div_num.length; i++) {
        if (i < cnt) {
            div_num[i].style.visibility = "visible";
        }
    }
    var main_page = document.getElementById("page1");
    main_page.classList.add("paginator_active");
</script>
</body>
</html>