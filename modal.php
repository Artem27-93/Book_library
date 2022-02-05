<!-- Модальное окно редактирования книги-->
<div class="modal fade" id="editModal<?=$value['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content shadow">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Редактировать запись № <?=$value['id'] ?></h5>
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
        		<button class="btn btn-primary" onclick="updateBook(this);">Обновить</button>
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
        <h5 class="modal-title" id="exampleModalLabel">Удалить запись № <?=$key ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
        <form action="?id=<?=$value['id'] ?>" method="post">
        	<button type="submit" name="delete_submit" class="btn btn-danger">Удалить</button>
    	</form>
      </div>
    </div>
  </div>
</div>
