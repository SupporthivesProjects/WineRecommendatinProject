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
            height: 125px;
            padding: 5px 3px;
        }

        .qr-item h3 {
            font-size: 8px;
            line-height: 10px;
            height: 20px;
            margin: 0 0 4px 0;
            padding: 0;
            overflow: hidden;
        }

        .qr-code {
            width: 72pt;
            height: 72pt;
            margin: 0 auto;
        }

        .qr-code img {
            width: 72pt;
            height: 72pt;
            display: block;
            margin: 0 auto;
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

            <h3>
                {{ $product->wine_name }}
            </h3>

            <p>
                Product ID: {{ $product->id }}
            </p>

            <div class="qr-code">
                <img
                    src="data:image/png;base64,{{ $qrCodes[$product->id] }}"
                    alt="QR Code"
                    width="72"
                    height="72"
                >
            </div>

            <p>
                {{ $url }}
            </p>

        </div>

    @endforeach

</div>

</body>
</html>