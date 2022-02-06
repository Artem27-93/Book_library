/**
 * Created by artem on 01.02.22.
 */
//добавление новой книги
function addBook(param){
    var dataBlock = $(param).parent().parent();
    var name = $(dataBlock).children('div').find('input.name').val();
    var descr = $(dataBlock).children('div').find('input.descr').val();
    var image = $(dataBlock).children('div').find('input.image').val();
    var authors = $(dataBlock).children('div').find('input.authors').val();

    if(name != '' && authors != ''){
        var object = {
            'act': 'addNewBook',
            'name': name,
            'descr':descr,
            'image':image,
            'authors':authors
        };
        $.ajax({
            url: 'request.php',
            method: "POST",
            data: object,

            success: function (json) {
                var json = JSON.parse(json);
                alert('Добавлена новая книга!');
                $(param).parent().parent().parent().parent('.fade').removeClass('show');
                $('.modal-backdrop').removeClass('show');
                document.location.reload();

            },
            error: function(){
                alert('Ошибка записи в БД');
            }
        });
    }else{
        $('.modal-body .name').css('border-color','red');
        $('.modal-body .authors').css('border-color','red');
        setTimeout(function(){
            $('.modal-body .name').css('border-color','#ced4da');
            $('.modal-body .authors').css('border-color','#ced4da');
        },2000);
    }
}
//добавление нового автора
function addAuthors(param){
    var dataBlock = $(param).parent().parent();
    var name = $(dataBlock).children('div').find('input.name').val();
    var surname = $(dataBlock).children('div').find('input.surname').val();
    var patronymic =  $(dataBlock).children('div').find('input.patronymic').val();

    if(name != '' && surname != ''){
        if(surname.length < 3){
            $('.modal-body .surname').css('border-color', 'red');
            $('.modal-body .surname').val('Поле должно быть не менее 3-х символов!');
            setTimeout(function() {
                $('.modal-body .surname').css('border-color', '#ced4da');
                $('.modal-body .surname').val('');
            },2000);
            return false;
        }
        var object = {
            'act': 'addNewAuthor',
            'name': name,
            'surname':surname,
            'patronymic':patronymic
        };
        $.ajax({
            url: 'request.php',
            method: "POST",
            data: object,

            success: function (json) {
                var json = JSON.parse(json);
                alert('Добавлен новый автор!');
                $(param).parent().parent().parent().parent('.fade').removeClass('show');
                $('.modal-backdrop').removeClass('show');
                //document.location.reload();

                $('#authors tbody').append(json['table']);
            },
            error: function(){
                alert('Ошибка записи в БД');
            }
        });
    }else{
        $('.modal-body .name').css('border-color','red');
        $('.modal-body .surname').css('border-color','red');
        setTimeout(function(){
            $('.modal-body .name').css('border-color','#ced4da');
            $('.modal-body .surname').css('border-color','#ced4da');
        },2000);
    }
}
//обновление существующей книги/автора
function updateRow(param, table){
    var dataBlock = $(param).parent().parent();
    var id = $(dataBlock).attr('data-num');

    if(table == 'books_lib'){
        var name = $(dataBlock).children('div').find('input.edit_name').val();
        var descr = $(dataBlock).children('div').find('input.edit_descr').val();
        var image = $(dataBlock).children('div').find('input.edit_image').val();
        var authors = $(dataBlock).children('div').find('input.edit_authors').val();

        var object = {'act':'editBook','id':id, 'name':name,'descr':descr,'image':image,'authors':authors, 'table':table};
    }else if(table == 'authors'){
        var name = $(dataBlock).children('div').find('input.edit_name').val();
        var surname = $(dataBlock).children('div').find('input.edit_surname').val();
        var patronymic = $(dataBlock).children('div').find('input.edit_patronymic').val();

        var object = {'act':'editAuthors','id':id, 'name':name,'surname':surname,'patronymic':patronymic, 'table':table};
    }




    $.ajax({
        url: 'request.php',
        method: "POST",
        data: object,

       success: function () {
                alert('Данные по книге обновлены успешно!');
                $(param).parent().parent().parent().parent('.fade').removeClass('show');
                $('.modal-backdrop').removeClass('show');
                document.location.reload();
            },
        error: function(){
            alert('Ошибка записи в БД');
        }
    })
}

//удаление книги/автора из справочника
function deleteRow(param, table){
    var id = param;
    var act = '';
    if(table == 'books_lib'){
        act = 'deleteBook';
    }else if(table == 'authors'){
        act = 'deleteAuthors';
    }
        $.getJSON('request.php',
            {
                act: act,
                id:id,
                table:table
            },
            function(json) {
                if(json['state'] == 'SUCCESS'){
                    alert('Книга успешно удалена!');
                    $(param).parent().parent().parent().parent('.fade').removeClass('show');
                    $('.modal-backdrop').removeClass('show');
                    document.location.reload();
                }
            });
}
//сортировка таблицы
function sortTable(table,column) {

    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById(table);
    switching = true;
    dir = "asc";
    while (switching) {
        switching = false;
        rows = table.getElementsByTagName("TR");
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[column];
            y = rows[i + 1].getElementsByTagName("TD")[column];
            if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    shouldSwitch= true;
                    break;
                }
            } else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            switchcount ++;
        } else {
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}
//поиск по названию таблицы
function tableSearch(table,param, id) {
    if($(param).val() == ''){
        pagination(null,'page1');
        return false;
    }else{
        var phrase = document.getElementById(id);
        var table = document.getElementById(table);
        var regPhrase = new RegExp(phrase.value, 'i');
        var flag = false;
        for (var i = 1; i < table.rows.length; i++) {
            flag = false;
            for (var j = table.rows[i].cells.length - 1; j >= 0; j--) {
                flag = regPhrase.test(table.rows[i].cells[j].innerHTML);
                if (flag) break;
            }
            if (flag) {
                table.rows[i].style.visibility = "visible";
            } else {
                table.rows[i].style.visibility = "collapse";
            }
        }
    }

}

//листаем страницы для пагинации
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
    }
    for (var i = data_page; i < div_num.length; i++) {
        if (j >= cnt) break;
        div_num[i].style.visibility = "visible";

        j++;
    }


}

//показываю выпадающий список авторов
function initSelect(){
    $.getJSON('request.php',
        {
            act: 'getListAuthors'
        },
        function(json) {
            if(json['state'] == 'SUCCESS'){
                $('.modal-body .selector').empty().append(json['result']);
            }
        });
}
