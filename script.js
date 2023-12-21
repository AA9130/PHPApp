function submitForm() {
  var form = document.getElementById("registrationForm");
  if (!form.checkValidity()) {
    form.reportValidity();
    return;
  }

  var formData = new FormData(form);

  fetch("register.php", {
    method: "post",
    body: formData,
  })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert("Data has been sent successfully!");
        window.location.href = "http://localhost/studentregisteration/registered_students.html";
      } else {
        alert("Error: " + data.message);
      }
    })
    .catch(error => {
      console.error("Error:", error);
    });
}
