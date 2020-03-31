<!DOCTYPE html>
<html>
<style>
body {font-family: Arial, Helvetica, sans-serif;}
 
form {
  border: 3px solid #f1f1f1;
  font-family: Arial;
}
 
.container {
  padding: 20px;
  background-color: #f1f1f1;
}
 
input[type=text], input[type=submit] {
  width: 100%;
  padding: 12px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}
 
input[type=checkbox] {
  margin-top: 16px;
}
 
input[type=submit] {
  background-color: #4CAF50;
  color: white;
  border: none;
}
 
input[type=submit]:hover {
  opacity: 0.8;
}
</style>
<body>
 
<h2>Eastline Construction</h2>
 

  <div class="container">
    <h2>Username and Email Credentials</h2>
    <p>Use This Credentials To Login To Your Account.</p>
  </div>
 
  <div class="container" style="background-color:white">
   Username/Email:        <strong>{{$data1['email']}}</strong>
   <br>
   Password:     <strong>{{$data1['password']}}</strong>
  </div>
 
  <div class="container">
 
  </div>

 
</body>
</html>