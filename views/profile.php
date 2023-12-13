<?php include 'layouts/header.php' ?>
<div class="main">
  <div class="form_row StatusRow">
    <div class="form_coll">
      <?php echo getStatus(); ?>
    </div>
  </div>
  <div class="form_row">
    <div class="form_coll">
      <h1>Профиль</h1>
    </div>
  </div>
  <form action="<?= url('register/update') ?>" method="POST" enctype="multipart/form-data">
    <div class="form_row">
      <?php if(empty($image)){ ?>
      <div class="form_coll">
        <label>Фото</label>
        <input type="file" name="fileToUpload" id="fileToUpload">
      </div>
      <?php } else { ?>
        <div style="position:absolute">
        <img style="display:block;" width="200" src="<?= url('uploads/' . $id . '/' . $image) ?>" border="0">
        <input style="display:block;margin:10px 10px 0 0;" type="button"
            onclick="if(confirm('Вы уверены, что хотите удалить картинку?')) {document.location.href = '<?= url('register/deleteimg') ?>'} else return false;"
            value="Удалить картинку">

        </div>
        <?php } ?>
      <div class="form_coll">
        <label>ФИО</label>
        <input name="fio" value="<?= $fio ?>" min="2" placeholder="Введите ФИО" required>
      </div>
      <div class="form_coll">
        <label>Возраст</label>
        <input name="age" value="<?= $age ?>" min="1" placeholder="Введите Возраст" required>
      </div>
      <div class="form_coll">
        <label>Телефон</label>
        <input name="phone" value="<?= $phone ?>" pattern="\+[0-9]*" placeholder="Введите телефон +00000000000"
          required>
      </div>
      <div class="form_coll">
        <label>Индекс</label>
        <input name="plz" value="<?= $plz ?>" pattern="[0-9]*" placeholder="Введите Индекс" required>
      </div>
      <div class="form_coll">
        <label>Город</label>
        <input name="city" value="<?= $city ?>" min="1" placeholder="Введите Город" required>
      </div>
      <div class="form_coll">
        <label>Почтовый адрес</label>
        <input name="addr" value="<?= $addr ?>" min="1" placeholder="Введите Адрес" required>
      </div>
      <div class="form_row">
        <div class="form_coll buttons">
          <input type="submit" value="Обновить">
          <input type="button"
            onclick="if(confirm('Вы уверены, что хотите удалить профиль?')) {document.location.href = '<?= url('register/delete') ?>'} else return false;"
            value="Удалить">
          <input type="button" onclick="document.location.href = '<?= url('register/logout') ?>'" value="Выйти">
        </div>
      </div>
    </div>
  </form>
</div>

<?php include 'layouts/footer.php' ?>