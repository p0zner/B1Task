<?php
   #Подключение MySQL, задание параметров, где
      #host - 'localhost'     user - 'root'     password - ''     #database - 'B1Task'
   function connectToDatabase() {
      $mysqli = new mysqli('localhost', 'root', '', 'B1Task');
      if ($mysqli->connect_errno) {
          echo "Не удалось подключиться к MySQL: " . $mysqli->connect_error;
          exit();
      }
      return $mysqli;
   }

   #Создание таблицы Users
   function createUsersTable($mysqli) {
      $mysqli->query("CREATE TABLE IF NOT EXISTS Users (
          xml_id VARCHAR(255) PRIMARY KEY,
          last_name VARCHAR(255),
          name VARCHAR(255),
          second_name VARCHAR(255),
          department VARCHAR(255),
          work_position VARCHAR(255),
          email VARCHAR(255),
          mobile_phone VARCHAR(255),
          phone VARCHAR(255),
          login VARCHAR(255),
          password VARCHAR(255)
      )");
   }
   
   #Создание таблицы Department
   function createDepartmentsTable($mysqli) {
      $mysqli->query("CREATE TABLE IF NOT EXISTS Departments (
         xml_id VARCHAR(255) PRIMARY KEY,
         parent_xml_id VARCHAR(255),
         name_department VARCHAR(255)
      )");
   }

   #Создание таблицы Files
   function createFilesTable($mysqli) {
      $mysqli->query("CREATE TABLE  IF NOT EXISTS Files (
         filename VARCHAR(255) PRIMARY KEY,
         uploaded_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
      )");
   }

   #Добавление данных в MySQL для таблицы Users
   function importUsersData($mysqli, $filename) {
      #открытие файла только для чтения
      $file = fopen($filename, 'r');
      $tableStarted = false;
      #считываем таблицу по строкам, разделитель между данными - ';'
      while (($arr = fgetcsv($file, 2048, ';')) !== false) {
         #Пропускаем добавление первой строки в MySQL
         if (!$tableStarted) {
            createUsersTable($mysqli); 
            continue;
         }
         #Добавление данных в MySQL
         $mysqli->query("INSERT INTO Users (xml_id, last_name, name, second_name, department, work_position, email, mobile_phone, phone, login, password)
         VALUES ('" . $arr[0] . "', '" . $arr[1] . "', '" . $arr[2] . "', '" . $arr[3] . "', '" . $arr[4] . "', '" . $arr[5] . "', '" . $arr[6] . "', '" . $arr[7] . "', '" . $arr[8] . "', '" . $arr[9] . "', '" . $arr[10] . "')");
      }
      #Получение информации о времени загрузки файла
      $uploaded_at = date("Y-m-d H:i:s");
      #Добавление данных в таблицу Files 
      $mysqli->query("INSERT INTO Files (filename, uploaded_at) VALUES('$filename', '$uploaded_at')");
      fclose($file);
   }

   #Добавление данных в MySQL для таблицы Department
   function importDepartmentsData($mysqli, $filename) {
      $file = fopen($filename, 'r');
      $tableStarted = false;
      while (($arrDepartment = fgetcsv($file, 2048, ';')) !== false) {
         if (!$tableStarted) {
            createDepartmentsTable($mysqli);
            continue;
         }
         #Добавление данных в MySQL
         $mysqli->query("INSERT INTO Departments (xml_id, parent_xml_id, name_department)
         VALUES ('" . $arrDepartment[0] . "', '" . $arrDepartment[1] . "', '" . $arrDepartment[2] . "')");
      }
      $uploaded_at = date("Y-m-d H:i:s");
      $mysqli->query("INSERT INTO Files (filename, uploaded_at) VALUES ('$filename', '$uploaded_at')");
      fclose($file);
   }

   #Список загруженных в SQL файлов
   function listOfUploadedFiles($mysqli) {
      $result = $mysqli->query("SELECT * FROM Files");
         // Проверка наличия данных
         if ($result->num_rows > 0) {
            // Вывод данных
            echo '<h2>Список загруженных файлов</h2>';
            while ($row = $result->fetch_assoc()) {
               echo " Файл: " . $row["filename"] . " Время добавления: " . $row["uploaded_at"] . "<br>";
            }
         } else {
            echo "Нет данных";
         }
      }

   function main() {
      $mysqli = connectToDatabase();
      createFilesTable($mysqli);
      importUsersData($mysqli, 'uploads/import_users.csv');
      importDepartmentsData($mysqli, 'uploads/import_department.csv');
      listOfUploadedFiles($mysqli);
      $mysqli->close();
   }

   main();
?>