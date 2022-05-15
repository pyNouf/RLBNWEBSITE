
var pwd = document.getElementById('pwd');
var eye = document.getElementById('eye');

eye.addEventListener('click',togglePass);

function togglePass(){

   eye.classList.toggle('active');

   (pwd.type == 'password') ? pwd.type = 'text' : pwd.type = 'password';
}

// Form Validation

function checkStuff() {
  var id = document.form1.id;
  var password = document.form1.password;
  var msg = document.getElementById('msg');
  
  if (id.value == "") {
    msg.style.display = 'block';
    msg.innerHTML = "Please enter your adminID";
    id.focus();
    return false;
  } else if (password.value == "") {
    msg.style.display = 'block';
    msg.innerHTML = "Please enter your password";
    password.focus();
    return false; 
  } else {
    msg.innerHTML = "";
  }
   
}
