
<!--Добавление нового автора-->
<div class="modal fade" tabindex="-1" role="dialog" id="ModalAuthors">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow">
            <div class="modal-header">
                <h5 class="modal-title">Добавить нового автора</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control name" name="name" value="" placeholder="Имя автора">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control surname" name="surname" title="Фамилия должна быть не менее 3-х символов" value="" placeholder="Фамилия автора">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control patronymic" name="patronymic" value="" placeholder="Отчество автора">
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button type="button" name="submit" class="btn btn-primary" onclick="addAuthors(this);">Добавить</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Модальное окно редактирования автора-->
<div class="modal fade" id="editModalAuth<?=$value['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Редактировать автора</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" data-num="<?=$value['id'] ?>">
                <div class="form-group">
                    <input type="text" class="form-control edit_name"  value="<?=$value['name'] ?>" placeholder="Имя">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control edit_surname" value="<?=$value['surname'] ?>" placeholder="Фамилия">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control edit_patronymic"  value="<?=$value['patronymic'] ?>" placeholder="Отчество">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" onclick="updateRow(this, 'authors');">Обновить</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Модальное окно удаления автора -->
<div class="modal fade" id="deleteModalAuth<?=$value['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Удалить автора <span style="color: darkred;"><?=$value['name'].' '.$value['surname'] ?></span> из списка</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button name="" onclick="deleteRow(<?=$value['id'] ?>, 'authors');" class="btn btn-danger">Удалить</button>

            </div>
        </div>
    </div>
</div>
