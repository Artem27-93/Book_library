/**
 * Created by artem on 01.02.22.
 */
//добавление новой книги
function addBook(param){
    var name = $('.modal-body .name').val();
    var descr = $('.modal-body .descr').val();
    var image =  $('.modal-body .image').val();
    var authors =  $('.modal-body .authors').val();

    if(name != '' && authors != ''){
        $.getJSON('request.php',
            {
                act: 'addNewBook',
                name: name,
                descr:descr,
                image:image,
                authors:authors
            },
            function(json) {
                if(json['state'] == 'SUCCESS'){
                    alert('Добавлена новая книга');
                    $(param).parent().parent().parent().parent('.fade').removeClass('show');
                    $('.modal-backdrop').removeClass('show');
                    document.location.reload();
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
//обновление существующей книги
function updateBook(param){
   var dataBlock = $(param).parent().parent();
    var id = $(dataBlock).attr('data-num');
   var name = $(dataBlock).children('div').find('input.edit_name').val();
   var descr = $(dataBlock).children('div').find('input.edit_descr').val();
   var image = $(dataBlock).children('div').find('input.edit_image').val();
   var authors = $(dataBlock).children('div').find('input.edit_authors').val();

   var object = {'act':'editBook','id':id, 'name':name,'descr':descr,'image':image,'authors':authors};

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
function tableSearch(table,param) {
    if($(param).val() == ''){
        pagination(null,'page1');
        return false;
    }else{
        var phrase = document.getElementById('search-text');
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