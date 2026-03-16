<!DOCTYPE html>
<html>
<head>

<title>Session Expired</title>

<style>

body{
    font-family: Arial;
    background:#f4f6f9;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.card{
    text-align:center;
    background:white;
    padding:40px;
    border-radius:10px;
    box-shadow:0 5px 20px rgba(0,0,0,0.1);
}

h1{
    font-size:80px;
    margin:0;
    color:#e74c3c;
}

p{
    font-size:18px;
    margin:20px 0;
}

.btn{
    padding:12px 25px;
    background:#007bff;
    color:white;
    text-decoration:none;
    border-radius:6px;
}

</style>

</head>

<body>

<div class="card">

<h1>419</h1>

<p>Your session has expired.</p>

<p>Please login again.</p>

<a href="{{ url('/') }}" class="btn">Go To Home</a>

</div>

</body>

</html>