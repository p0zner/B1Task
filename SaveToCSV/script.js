document.getElementById("dataForm").addEventListener("submit", function(event) {
  event.preventDefault(); // Предотвращаем отправку формы

  const name = document.getElementById("name").value;
  const email = document.getElementById("email").value;

  if (name.trim() !== '' || email.trim() !== '') {
    const data = {
      name: name,
      email: email
    };

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "saveData.php", true);
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          console.log("Data saved successfully");
          document.getElementById("name").value = "";
          document.getElementById("email").value = "";
        } else {
          console.log("Failed to save data");
        }
      }
    };
    xhr.send(JSON.stringify(data));
  }
});