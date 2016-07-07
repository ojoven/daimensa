<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title>Daimensa | Manager</title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

    <!-- Vendor styles -->
    <link rel="stylesheet" href="/admin/vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="/admin/vendor/metisMenu/dist/metisMenu.css" />
    <link rel="stylesheet" href="/admin/vendor/animate.css/animate.css" />
    <link rel="stylesheet" href="/admin/vendor/bootstrap/dist/css/bootstrap.css" />

    <!-- App styles -->
    <link rel="stylesheet" href="/admin/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="/admin/fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="/admin/styles/style.css">

</head>
<body>

<!-- Simple splash screen-->
<div class="splash"> <div class="color-line"></div><div class="splash-title"><h1>Daimensa - Manager</h1><p>Manage the backend for Daimensa. </p><div class="spinner"> <div class="rect1"></div> <div class="rect2"></div> <div class="rect3"></div> <div class="rect4"></div> <div class="rect5"></div> </div> </div> </div>

<!-- Header -->
<div id="header">
    <div class="color-line">
    </div>
    <div id="logo" class="light-version">
        <span>
            DAIMENSA
        </span>
    </div>
    <nav role="navigation">
        <div class="header-link hide-menu"><i class="fa fa-bars"></i></div>
        <div class="small-logo">
            <span class="text-primary">DAIMENSA</span>
        </div>
        <form role="search" class="navbar-form-custom" method="post" action="#">
            <div class="form-group">
                <input type="text" placeholder="Search something special" class="form-control" name="search">
            </div>
        </form>
        <div class="navbar-right">
            <ul class="nav navbar-nav no-borders">
                <li>
                    <a href="/manager/logout">
                        <i class="pe-7s-upload pe-rotate-90"></i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</div>

<!-- Navigation -->
<aside id="menu">
    <div id="navigation">
        <div class="profile-picture">

            <div class="stats-label text-color">
                <span class="font-extra-bold font-uppercase">Hi, Mikel</span>
            </div>
        </div>

        <ul class="nav" id="side-menu">
            <li class="{{ $page == 'dashboard' ? 'active' : '' }}">
                <a href="/manager"> <span class="nav-label">DASHBOARD</span> </a>
            </li>
            <li class="{{ $page == 'users' ? 'active' : '' }}">
                <a href="#"><span class="nav-label">USERS</span><span class="fa arrow"></span> </a>
                <ul class="nav nav-second-level">
                    <li><a href="/manager/users">LIST USERS</a></li>
                </ul>
            </li>
            <li class="{{ $page == 'lessons' ? 'active' : '' }}">
                <a href="/manager/lessons"> <span class="nav-label">LESSONS</span> </a>
            </li>
            <li class="{{ $page == 'words' ? 'active' : '' }}">
                <a href="/manager/words"> <span class="nav-label">WORDS</span> </a>
            </li>
        </ul>
    </div>
</aside>

<!-- Main Wrapper -->
<div id="wrapper">

    <div class="content animate-panel">

        @yield('content')

    </div>

    <!-- Footer-->
    <footer class="footer">
        <span class="pull-right">
            Example text
        </span>
        Company 2016
    </footer>

</div>

<!-- Vendor scripts -->
<script src="/admin/vendor/jquery/dist/jquery.min.js"></script>
<script src="/admin/vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="/admin/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/admin/vendor/metisMenu/dist/metisMenu.min.js"></script>

<!-- App scripts -->
<script src="/admin/scripts/homer.js"></script>

</body>
</html>