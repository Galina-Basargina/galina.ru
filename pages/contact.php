<?php include '../includes/header.php'; ?>
<link rel="stylesheet" href="/assets/css/style.css">

<main>
    <h1>Контакты</h1>
    <form method="post" action="contact_form.php">
        <input type="text" name="name" placeholder="Имя" required minlenght="2">
        <input type="email" name="email" placeholder="Email" required>
        <textarea name="message" minlength="10"></textarea>
        <button type="submit">Отправить</button>
    </form>
</main>
<?php include '../includes/footer.php'; ?>
