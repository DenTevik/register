<?php
include 'layouts/header.php' ?>

<div class="main">
  <div class="form_row StatusRow">
    <div class="form_coll">
      <?php echo getStatus(); ?>
    </div>
  </div>

  <div class="form_row">
    <div class="form_coll">
      <h1>Регистрация</h1>
    </div>
  </div>
  <form action="<?= url('register/add') ?>" method="POST">

    <div class="form_row">
      <div class="form_coll">
        <label>Email</label>
        <input name="email" value="" type="email" placeholder="Введите Email" required>
      </div>
      <div class="form_coll">
        <label>Пароль</label>
        <input name="password" value="" type="password" placeholder="Введите Пароль" required>
      </div>
    </div>
    <hr>
    <div class="form_row">
      <div class="form_coll">
        <label>ФИО</label>
        <input name="fio" value="" min="2" placeholder="Введите ФИО" required>
      </div>
      <div class="form_coll">
        <label>Возраст</label>
        <input name="age" value="" min="1" placeholder="Введите Возраст" required>
      </div>
      <div class="form_coll">
        <label>Телефон</label>
        <input name="phone" value="" pattern="\+[0-9]*" placeholder="Введите телефон +00000000000" required>
      </div>
      <div class="form_coll">
        <label>Индекс</label>
        <input name="plz" value="" pattern="[0-9]*" placeholder="Введите Индекс" required>
      </div>
      <div class="form_coll">
        <label>Город</label>
        <input name="city" value="" min="1" placeholder="Введите Город" required>
      </div>
      <div class="form_coll">
        <label>Почтовый адрес</label>
        <input name="addr" value="" min="1" placeholder="Введите Адрес" required>
      </div>
      <div class="form_row">
        <div class="form_coll buttons">
          <input type="submit" value="Зарегистрироваться">
          <input type="button" onclick="document.location.href = '<?= url('home') ?>'" value="Войти">
        </div>
      </div>
    </div>
  </form>

  <?php include 'layouts/footer.php' ?>