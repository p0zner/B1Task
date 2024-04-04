<!DOCTYPE html>
<html>
<head>
  <title>Сохранение текста в CSV</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <form id="dataForm" action="saveData.php" method="post">
    <textarea id="textarea" name="text"></textarea>
    <br>
    <button type="submit" class="btn-submit">Сохранить в файл</button>
  </form>

  <script src="script.js"></script>
</body>
</html>

<?php
//Проверка на отправку POST запроса
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $text = $_POST['text'];

  if (!empty($text)) {
    $filename = 'data.csv';

    // Разбиваем текст на строки
    $lines = explode("\n", $text);

    // Удаляем пустые строки
    $lines = array_filter($lines, function($line) {
      return trim($line) !== '';
    });

    // Открываем файл в режиме дозаписи
    $file = fopen($filename, 'a');

    // Записываем текст в файл
    fwrite($file, implode("\n", $lines) . "\n");

    // Закрываем файл
    fclose($file);

    http_response_code(200);
  }
}
?>