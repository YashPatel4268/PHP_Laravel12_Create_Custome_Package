<!DOCTYPE html>
<html>
<head>
    <title>Demo Package</title>

    <style>
        body {
            font-family: Arial;
            text-align: center;
            padding: 50px;
            font-size: {{ config('demopackage.font_size') }};
        }

        .light {
            background: #ffffff;
            color: #000;
        }

        .dark {
            background: #111;
            color: #fff;
        }

        .box {
            padding: 20px;
            border-radius: 10px;
            display: inline-block;
            margin-top: 20px;
            border: 1px solid #ccc;
        }
    </style>
</head>

<body class="{{ config('demopackage.theme') }}">

    <div class="box">
        <h1>{{ config('demopackage.message') }}</h1>
        <p>Dynamic Theme System from Package</p>
        <p>Font Size: {{ config('demopackage.font_size') }}</p>
    </div>

</body>
</html>