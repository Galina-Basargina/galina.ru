<?php
include '../includes/db.php';
// Обработка отправки формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $title = pg_escape_string($_POST['title']);
   $content = pg_escape_string($_POST['content']);
  
   $result = pg_query_params(
       $db_conn,
       "INSERT INTO articles (title, content) VALUES ($1, $2)",
       [$title, $content]
   );
  
   if ($result) {
       header("Location: /articles.php");
       exit;
   } else {
       echo "Ошибка: " . pg_last_error($db_conn);
   }
}
?>
<link rel="stylesheet" href="/assets/css/style.css">
<main>
    <h1>Статьи</h1>

    <div class="form-container">
        <h2>Создать новую статью</h2>
        <form method="POST" action="">
            <!-- Поле "Заголовок" -->
            <div class="form-group">
                <label for="title">Заголовок:</label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    required
                    placeholder="Введите заголовок статьи"
                >
            </div>

            <!-- Поле "Содержимое" -->
            <div class="form-group">
                <label for="content">Содержимое:</label>
                <textarea 
                    id="content" 
                    name="content" 
                    rows="10" 
                    required
                    placeholder="Напишите текст статьи"
                ></textarea>
            </div>

            <!-- Кнопка отправки -->
            <button type="submit">Опубликовать</button>
        </form>
    </div>
    
</main>
<?php include '../includes/footer.php'; ?>
