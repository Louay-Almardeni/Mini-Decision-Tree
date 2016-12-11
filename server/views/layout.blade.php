<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>KnowledgeValues.com</title>

    <link rel="stylesheet" href="../resources/bower/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../resources/bower/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../resources/css/test.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    @yield('custom-css')
</head>

<body>

<script src="../resources/bower/jquery/dist/jquery.min.js"></script>
<script src="../resources/bower/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../resources/js/test.js"></script>

@include('components/navbar')

@yield('content')
@yield('custom-js')

</body>
</html>