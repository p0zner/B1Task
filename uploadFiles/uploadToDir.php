<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="styles/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<!--Форма для загрузки файла-->
<div class="form-container">
  <form action="uploadToDir.php" method="post" enctype="multipart/form-data" name="form" id="form">
    <div class="input-row">
      <label class="label">Choose your file.</label>
      <input type="file" name="fileToUpload" id="fileToUpload" class="file">
    </div>
    <div class="import">
      <button type="submit" id="submit" name="import" class="btn-submit">Import</button>
    </div>
  </form>
</div>

<div id='fileListContainer'></div>

<?php
function uploadToDir() {
  #Проверка на отправку формы
  if (isset($_POST['import'])) {

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  
    if (file_exists($target_file)) {
      #Проверка на существование файла в папке
      echo '<div class="error">Sorry, file already exists.</div>';
      $uploadOk = 0;
    } else if($fileType != "csv") {
      #Проверка формата файла
      echo '<div class="error">Sorry, only CSV files are allowed.</div>';
      $uploadOk = 0;
    } else {
      #Если прошло предыдущие проверки, то пробуем загрузить файл в папку
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo '<div class="success">';
        echo htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
        echo '</div>';
      } else {
        echo '<div class="error">Sorry, there was an error uploading your file.</div>';
      }
    }
  }
}

uploadToDir();
?>

</body>
</html>