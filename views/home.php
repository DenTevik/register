<?php include 'layouts/header.php' ?>
<div class="main">
    <div class="form_row StatusRow">
        <div class="form_coll">
            <?php echo getStatus(); ?>
        </div>
    </div>
    <div class="form_row">
            <div class="form_coll">
                <h1>Авторизация</h1>
            </div>
        </div>
    <form action="<?= url('register/login') ?>" method="POST">
        
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
        <div class="form_row">
            <div class="form_coll buttons">
                <input type="submit" value="Войти">
                <input type="button" onclick="document.location.href = '<?= url('register') ?>'" value="Регистрация">
            </div>
        </div>
    </form>
    <?php include 'layouts/footer.php' ?>