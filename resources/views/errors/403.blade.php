<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <title>403 - Access Denied</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/wine_store_favicon.ico') }}" type="image/x-icon">

    <style>
        *{
        margin:0;
        padding:0;
        box-sizing:border-box;
        font-family: "Segoe UI", sans-serif;
        }
        
        body{
        height:100vh;
        display:flex;
        align-items:center;
        justify-content:center;
        background: linear-gradient(135deg,#ff9966,#ff5e62);
        color:white;
        text-align:center;
        }
        
        .container{
        max-width:600px;
        padding:40px;
        }
        
        .error{
        font-size:140px;
        font-weight:800;
        letter-spacing:5px;
        animation:float 3s ease-in-out infinite;
        }
        
        @keyframes float{
        0%{transform:translateY(0)}
        50%{transform:translateY(-12px)}
        100%{transform:translateY(0)}
        }
        
        .title{
        font-size:30px;
        margin-top:-10px;
        margin-bottom:10px;
        }
        
        .description{
        opacity:0.9;
        margin-bottom:35px;
        line-height:1.6;
        }
        
        .buttons{
        display:flex;
        justify-content:center;
        gap:15px;
        flex-wrap:wrap;
        }
        
        .btn{
        padding:12px 28px;
        border-radius:30px;
        text-decoration:none;
        font-weight:600;
        transition:0.25s;
        }
        
        .home{
        background:white;
        color:#333;
        }
        
        .home:hover{
        transform:translateY(-3px);
        }
        
        .back{
        border:2px solid white;
        color:white;
        }
        
        .back:hover{
        background:white;
        color:#333;
        }
        
        .icon{
        font-size:55px;
        margin-bottom:10px;
        }
    </style>

</head>

<body>

    <div class="container">
        <div class="icon">🔒</div>
        <div class="error">403</div>
        <div class="title">Access Denied</div>
        <div class="description">
            You do not have permission to access this page.
        </div>
        <div class="buttons">
            <a href="{{ url('/') }}" class="btn home">
                🏠 Go Home
            </a>
        </div>
    </div>

</body>

</html>