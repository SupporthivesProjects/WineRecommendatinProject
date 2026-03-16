<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <title>419 - Session Expired</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/wine_store_favicon.ico') }}" type="image/x-icon">

    <style>
        *{
        margin:0;
        padding:0;
        box-sizing:border-box;
        font-family: "Segoe UI", Arial, sans-serif;
        }
        
        body{
        height:100vh;
        display:flex;
        align-items:center;
        justify-content:center;
        background:linear-gradient(135deg,#ff6a6a,#ff9472);
        color:white;
        text-align:center;
        }
        
        .container{
        max-width:500px;
        padding:40px;
        }
        
        .icon{
        font-size:60px;
        margin-bottom:10px;
        animation:float 3s ease-in-out infinite;
        }
        
        .code{
        font-size:120px;
        font-weight:800;
        letter-spacing:4px;
        animation:float 3s ease-in-out infinite;
        }
        
        .title{
        font-size:28px;
        margin-top:-10px;
        margin-bottom:10px;
        }
        
        .description{
        font-size:16px;
        opacity:0.9;
        margin-bottom:35px;
        line-height:1.6;
        }
        
        .btn{
        display:inline-block;
        padding:12px 30px;
        background:white;
        color:#333;
        border-radius:30px;
        text-decoration:none;
        font-weight:600;
        transition:0.3s;
        }
        
        .btn:hover{
        transform:translateY(-3px);
        box-shadow:0 10px 25px rgba(0,0,0,0.2);
        }
        
        @keyframes float{
        0%{transform:translateY(0)}
        50%{transform:translateY(-12px)}
        100%{transform:translateY(0)}
        }
    </style>

</head>

<body>

    <div class="container">

        <div class="icon">
            ⏳
        </div>

        <div class="code">
            419
        </div>

        <div class="title">
            Session Expired
        </div>

        <div class="description">
            Your session has expired due to inactivity. Please login again to continue using the application.
        </div>

        <a href="{{ url('/') }}" class="btn">
            🏠 Go to Home
        </a>

    </div>

</body>

</html>