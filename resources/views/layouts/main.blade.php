<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daimensa</title>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

    <link href='http://fonts.googleapis.com/css?family=Ubuntu:400,500,700' rel='stylesheet' type='text/css'>
    <link href="/css/style.css" rel="stylesheet">

    @include('partials/scripts/facebook')

</head>


<body class="@yield('class')">

<header>
    <h1>Daimensa</h1>
</header>

<main id="main-container">

    @yield('content')

</main>

<script>
    var urlBase = "<?php echo url('/'); ?>";
</script>

<script type="text/javascript" src="/js/app.min.js"></script>

</body>
</html>