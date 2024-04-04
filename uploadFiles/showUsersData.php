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
   $result = $mysqli->query("SELECT * FROM Users");
   if ($result->num_rows > 0) {
      ?>
      <table id='userTable'>
         <thead>
            <tr>
               <th>XML_ID</th>
               <th>LAST_NAME</th>
               <th>NAME</th>
               <th>SECOND_NAME</th>
               <th>DEPARTMENT</th>
               <th>WORK_POSITION</th>
               <th>EMAIL</th>
               <th>MOBILE_PHONE</th>
               <th>PHONE</th>
               <th>LOGIN</th>
               <th>PASSWORD</th>
		      </tr>
	      </thead>
         <?php
         while ($row = $result->fetch_assoc()) {
            ?>
            <tbody>
               <tr>
                  <td><?php  echo $row['xml_id']; ?></td>
                  <td><?php  echo $row['last_name']; ?></td>
                  <td><?php  echo $row['name']; ?></td>
                  <td><?php  echo $row['second_name']; ?></td>
                  <td><?php  echo $row['department']; ?></td>
                  <td><?php  echo $row['work_position']; ?></td>
                  <td><?php  echo $row['email']; ?></td>
                  <td><?php  echo $row['mobile_phone']; ?></td>
                  <td><?php  echo $row['phone']; ?></td>
                  <td><?php  echo $row['login']; ?></td>
                  <td><?php  echo $row['password']; ?></td>
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