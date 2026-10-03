<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Product Information</title>

    <style>
        @page {
            size: A4 landscape;
            margin: 15px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
        }

        h2 {
            text-align: center;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto;
        }

        th, td {
            border: 1px solid #999;
            padding: 5px;
            text-align: left;
            vertical-align: top;
            word-wrap: break-word;
        }

        th {
            background-color: #eeeeee;
            font-weight: bold;
        }

        tr {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>

<h2>Product Information</h2>

<table>
    <thead>
        <tr>
            @foreach ($selectedFields as $field)
                <th>{{ $fieldLabels[$field] }}</th>
            @endforeach
        </tr>
    </thead>

    <tbody>
        @foreach ($products as $product)
            <tr>
                @foreach ($selectedFields as $field)
                    <td>{{ $product->{$field} ?? '' }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>