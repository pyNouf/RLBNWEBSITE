var pwd = document.getElementById('pwd');
var eye = document.getElementById('eye');
var confeye = document.getElementById('confeye');
eye.addEventListener('click',togglePass);
var cpwd = document.getElementById('cpwd');

function togglePass(){

   eye.classList.toggle('active');

   (pwd.type == 'password') ? pwd.type = 'text' : pwd.type = 'password';
}

function togglePass(){

  confeye.classList.toggle('active');

  (cpwd.type == 'password') ? cpwd.type = 'text' : cpwd.type = 'password';
}

// Form Validation

function checkStuff() {
  var email = document.form1.email;
  var password = document.form1.password;
  var cpassword = document.form1.confirm_password;
  var username = document.form1.username;

  var msg = document.getElementById('msg');

  if (username.value == "") {
    msg.style.display = 'block';
    msg.innerHTML = "Please enter a username";
    username.focus();
    return false;
  } else {
    msg.innerHTML = "";
  }
  
  if (email.value == "") {
    msg.style.display = 'block';
    msg.innerHTML = "Please enter your email";
    email.focus();
    return false;
  } else {
    msg.innerHTML = "";
  }
  
   if (password.value == "") {
    msg.innerHTML = "Please enter your password";
    password.focus();
    return false;
  } else {
    msg.innerHTML = "";
  }
  if (cpassword.value == "") {
    msg.innerHTML = "Please enter your password";
    cpassword.focus();
    return false;
  } else {
    msg.innerHTML = "";
  }
   var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  if (!re.test(email.value)) {
    msg.innerHTML = "Please enter a valid email";
    email.focus();
    return false;
  } else {
    msg.innerHTML = "";
  }
  if (password.value != cpassword.value) {
    msg.style.display = 'block';
    msg.innerHTML = "passwords doesn't match";
    cpassword.focus();
    password.focus();
    return false;
  } else {
    msg.innerHTML = "";
  }
}

