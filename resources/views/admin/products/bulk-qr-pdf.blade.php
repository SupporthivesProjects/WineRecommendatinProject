<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <title>Bulk Product QR Codes</title>

    <style>
        @page {
            margin: 20px;
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
            width: 48%;
            display: inline-block;
            vertical-align: top;
            text-align: center;
            margin-bottom: 30px;
            padding: 15px;
            box-sizing: border-box;
            border: 1px solid #ddd;
        }

        .qr-item h3 {
            font-size: 16px;
            margin: 0 0 8px;
        }

        .qr-item p {
            font-size: 11px;
            margin: 5px 0;
        }

        .qr-code {
            margin: 10px 0;
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
                    width="180"
                    height="180"
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