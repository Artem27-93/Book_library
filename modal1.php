
<!--Добавление новой книги-->
<div class="modal fade" tabindex="-1" role="dialog" id="ModalBook">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow">
            <div class="modal-header">
                <h5 class="modal-title">Добавить новую книгу</h5>
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
                    <div class="form-group selector">
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


<!-- Модальное окно редактирования книги-->
<div class="modal fade" id="editModal<?=$value['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content shadow">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Редактировать книгу</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" data-num="<?=$value['id'] ?>">
        	<div class="form-group">
        		<input type="text" class="form-control edit_name"  value="<?=$value['name'] ?>" placeholder="Название">
        	</div>
        	<div class="form-group">
        		<input type="text" class="form-control edit_descr" value="<?=$value['descr'] ?>" placeholder="Описание">
        	</div>
        	<div class="form-group">
        		<input type="text" class="form-control edit_image"  value="<?=$value['image'] ?>" placeholder="URL картинки">
        	</div>
            <div class="form-group">
                <input type="text" class="form-control edit_authors"  value="<?=$value['authors'] ?>" placeholder="Автор">
            </div>
        	<div class="modal-footer">
        		<button class="btn btn-primary" onclick="updateRow(this, 'books_lib');">Обновить</button>
        	</div>
      </div>
    </div>
  </div>
</div>

<!-- Модальное окно удаления книги -->
<div class="modal fade" id="deleteModal<?=$value['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content shadow">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Удалить книгу <span style="color: darkred;"><?=$value['name'] ?></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
          <button name="" onclick="deleteRow(<?=$value['id'] ?>, 'books_lib');" class="btn btn-danger">Удалить</button>

      </div>
    </div>
  </div>
</div>
