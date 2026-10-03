<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <title>Bulk Product QR Codes</title>

    <style>
        @page {
            size: A4;
            margin: 18px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 0;
        }

        .qr-grid {
            width: 100%;
        }

        .qr-item {
            width: 20%;
            display: inline-block;
            vertical-align: top;
            text-align: center;
            box-sizing: border-box;
            height: 160px;
            padding: 5px 3px;
        }

        .logo {
            width: 100%;
            height: 35px;
            margin-bottom: 5px;
            text-align: center;
        }

        .logo img {
            width: 55px;
            height: 35px;
            object-fit: contain;
        }

        .qr-item h3 {
            font-size: 8px;
            line-height: 10px;
            height: 20px;
            margin: 5px 0 0;
            padding: 0;
            overflow: hidden;
        }

        .qr-item p {
            display: none;
        }
    </style>
</head>

<body>

<div class="qr-grid">

    @foreach($products as $product)

        @php
            $url = url('/products/' . $product->id);
        @endphp

        <div class="qr-item">

            <div class="logo">
                <img src="{{ public_path('images/logoredwhite.jpg') }}" alt="Logo">
            </div>

            <div class="qr-code">
                <img src="data:image/png;base64,{{ $qrCodes[$product->id] }}" alt="QR Code" width="72" height="72">
            </div>

            <h3 style="height:200px">
                {{ $product->wine_name }}
            </h3>

            

        </div>

    @endforeach

</div>

</body>
</html>