<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
   <link rel="stylesheet" href="styles/styleTable.css">
</head>
<body>

<?php
   function connectToDatabase() {
      $mysqli = new mysqli('localhost', 'root', '', 'B1Task');
      if ($mysqli->connect_errno) {
          echo "Не удалось подключиться к MySQL: " . $mysqli->connect_error;
          exit();
      }
      return $mysqli;
   }

   $mysqli = connectToDatabase();
   $result = $mysqli->query("SELECT * FROM Departments");
   if ($result->num_rows > 0) {
      ?>
      <table id='userTable'>
         <thead>
            <tr>
               <th>XML_ID</th>
               <th>PARENT_XML_ID</th>
               <th>NAME_DEPARTMENT</th>
		      </tr>
	      </thead>
         <?php
         while ($row = $result->fetch_assoc()) {
            ?>
            <tbody>
               <tr>
                  <td><?php  echo $row['xml_id']; ?></td>
                  <td><?php  echo $row['parent_xml_id']; ?></td>
                  <td><?php  echo $row['name_department']; ?></td>
               </tr>
               </tbody>
               <?php
         }
      ?>
      </table>
      <?php
   }
   $mysqli->close();
?>

</body>
</html>