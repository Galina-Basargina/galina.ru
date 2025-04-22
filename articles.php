<?php include 'includes/header.php'; ?>
<?php
include 'includes/db.php';
$result = pg_query($db_conn, "SELECT * FROM articles ORDER BY created_at DESC");
while ($row = pg_fetch_assoc($result)) {
   echo "<div class='article'>
           <h2>{$row['title']}</h2>
           <p>{$row['content']}</p>
           <small>{$row['created_at']}</small>
         </div>";
}
?>

<link rel="stylesheet" href="/assets/css/style.css">
<main>

<div class="form-container animate-pop-in">
    <h2 class="form-title">Создать статью</h2>
    <form>
        <div class="form-group">
            <label for="title">Заголовок</label>
            <input type="text" id="title" name="title">
        </div>
        <div class="form-group">
            <label for="content">Содержание</label>
            <textarea id="content" name="content" rows="6"></textarea>
        </div>
        <button type="submit">Опубликовать</button>
    </form>
</div>
</main>
<?php include 'includes/footer.php'; ?>
