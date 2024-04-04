<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Data Saving</title>
</head>
<body>
<ul class="form-container">
  <form id="dataForm">
    <li class="input-row">
      <label for="name">Name:</label>
      <input type="text" id="name" name="name">
    </li>
    <li class="input-row">
      <label for="email">Email:</label>
      <input type="email" id="email" name="email">
    </li>
    <li class="input-row">
      <button type="submit" class="btn-submit" onclick="alert('Данные успешно добавлены')">Save Data</button>
    </li>
  </form>
</ul>
  <script src="script.js"></script>
</body>
</html>

<?php
//Декодинг JSON в массив
$data = json_decode(file_get_contents('php://input'), true);
if (!empty($data['name']) || !empty($data['email'])) {
  $name = $data['name'];
  $email = $data['email'];

  $filename = 'data.csv';
  $file = fopen($filename, 'a');

  // Если файл пустой, добавляем заголовки столбцов
  if (filesize($filename) === 0) {
    $headers = array('Name', 'Email');
    fputcsv($file, $headers, ';');
  }

  // Заменяем символы ", " на ";"
  $name = str_replace(', ', ';', $name);
  $email = str_replace(', ', ';', $email);

  $row = array($name, $email);
  fputcsv($file, $row, ';');

  fclose($file);

  http_response_code(200);
}
?>