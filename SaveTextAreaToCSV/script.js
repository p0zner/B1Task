//Добавляем обработчик события submit. Вызов функции-обработчика при отправке формы
document.getElementById("dataForm").addEventListener("submit", function(event) {
   //Предотвращение отправки формы по умолчанию
   event.preventDefault();

   const textareaValue = document.getElementById("textarea").value;
 
   if (textareaValue.trim() !== '') {

      const data = new FormData();
      data.append('text', textareaValue);
 
      const xhr = new XMLHttpRequest();
      xhr.open("POST", "saveData.php", true);
      //Срабатывает, когда изменяется состояние запроса
      xhr.onreadystatechange = function() {
         if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
            console.log("Файл успешно создан и данные сохранены.");
            document.getElementById("textarea").value = "";
            } else {
               console.log("Ошибка при сохранении данных.");
            }
         }
      };
      xhr.send(data);
   }
});