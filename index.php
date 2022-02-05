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
    <script src="functions.js?v=1.0.1"></script>
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


    </style>
</head>
<body>
	<div class="container">
		<div class="row" style="margin-top: 50px">
            <div class="col mt-1 tabs">
                <input type="radio" name="tab-btn" id="tab-btn-1" value="" checked>
                <label for="tab-btn-1">Книги</label>
                <input type="radio" name="tab-btn" id="tab-btn-2" value="">
                <label for="tab-btn-2">Авторы</label>

			<div id="content-1" class="">
				<?=$success ?>
				<button class="btn btn-success mb-1" data-toggle="modal" data-target="#Modal"><i class="fa fa-user-plus"></i></button>
                <button class="btn btn-primary" onclick="sortTable('books',1)">Сортировать по названию</button>
                <input class="form-control" style="margin: 10px 0;" type="text" placeholder="Поиск по названию/автору" id="search-text" onkeyup="tableSearch('books',this)">
				<table id="books" class="table shadow ">
					<thead class="thead-dark">
						<tr>
							<th>№ п/п</th>
							<th>Название</th>
							<th>Описание</th>
							<th>Картинка</th>
							<th>Автор</th>
							<th>Дата публикации</th>
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
							<td><img width="100px" height="100px" src="<?=$value['image'] ?>" alt="img#">
                            </td>
							<td><?=$value['authors'] ?></td>
							<td><?=$value['date_ins'] ?></td>
							<td>
								<a href="?edit=<?=$value['id'] ?>" class="btn btn-success btn-sm" data-toggle="modal" data-target="#editModal<?=$value['id'] ?>"><i class="fa fa-edit"></i></a> 
								<a href="?delete=<?=$value['id'] ?>" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal<?=$value['id'] ?>"><i class="fa fa-trash"></i></a>
								<?php require 'modal.php'; ?>
							</td>
						</tr> <?php } ?>
                    </tbody>
				</table>

                Страницы:
                <div class="paginator" onclick="pagination(event)"></div>


			</div>
            <div id="content-2">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque, fugiat nam? Aliquid animi facere id illo mollitia nemo quidem! Ab accusantium ad corporis doloremque eos maxime officiis quo repudiandae voluptate.</p>
            </div>
		</div>
        </div>
	</div>
	<!-- Modal -->
	<div class="modal fade" tabindex="-1" role="dialog" id="Modal">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content shadow">
	      <div class="modal-header">
	        <h5 class="modal-title">Добавить пользователя</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <form action="" method="post">
	        	<div class="form-group">
	        		<input type="text" class="form-control name" name="name" value="" placeholder="Название книги">
	        	</div>
	        	<div class="form-group">
	        		<input type="text" class="form-control descr" name="descr" value="" placeholder="Краткое описание">
	        	</div>
	        	<div class="form-group">
	        		<input type="text" class="form-control image" name="image" value="" placeholder="URL Картинки">
	        	</div>
                <div class="form-group">
                    <input type="text" class="form-control authors" name="authors" value="" placeholder="Введите автора">
                </div>

	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
	        <button type="button" name="submit" class="btn btn-primary" onclick="addBook(this);">Добавить</button>
	      </div>
	  		</form>
	    </div>
	  </div>
	</div>



<script>
    //пагинация
    var count = $('#books tbody>tr').length;//всего записей
    var cnt = 2; //сколько отображаем сначала
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

    //листаем
    function pagination(event,page) {
        var id;
        var e = event || window.event;
        var target;
        if(page){
            id = page;
            target = $('#'+page)[0];
        }else{
            target = e.target;
            id = target.id;
        }
        console.log(id);

        if (target.tagName.toLowerCase() != "span") return;

        var num = id.substr(4);


        var data_page = +target.dataset.page;

        main_page.classList.remove("paginator_active");
        main_page = document.getElementById(id);
        main_page.classList.add("paginator_active");

        var j = 0;
        for (var i = 0; i < div_num.length; i++) {

            var data_num = div_num[i];
            div_num[i].style.visibility = "collapse";
            /*if (data_num <= data_page || data_num >= data_page)
                div_num[i].style.visibility = "collapse";*/


        }
        for (var i = data_page; i < div_num.length; i++) {
            if (j >= cnt) break;
            div_num[i].style.visibility = "visible";

            j++;
        }


    }

</script>
</body>
</html>