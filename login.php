<?php
/**
 * Created by IntelliJ IDEA.
 * User: fahziar
 * Date: 23/02/2016
 * Time: 11.35
 */
    $SUCCESS = 1;
    $FAIL = 2;
    require_once('db_config.php');
    require_once('session.php');
    require_once('util.php');

    SessionManager::sessionStart();

    if (SessionManager::isLoggedIn()){
        header("Location: /");
        die();
    }

    if (isset($_POST['submit']) && isset($_POST['Username']) && isset($_POST['Password'])){
        if (!Util::validatePassword($_POST['Password'])){
            $status = $FAIL;
        } else {
            global $dbHost;
            global $dbUsername;
            global $dbPassword;
            global $dbName;
            $mysqli = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
            if ($mysqli->connect_errno) {
                echo "Failed to connect to database " . $mysqli->connect_errno;
                exit(0);
            }

            $statement = $mysqli->prepare("SELECT `id`, `username`, `password` FROM `user` WHERE `username` = ?");
            if ($statement) {
                $statement->bind_param('s', $_POST['Username']);
                $statement->execute();
                $statement->bind_result($id, $user, $hash);
                if ($statement->fetch()) {
                    if (password_verify($_POST['Password'], $hash)) {
                        SessionManager::login($id);
                        $status = $SUCCESS;
                        header("Location: /");
                        die();
                    } else {
                        $status = $FAIL;
                    }
                } else {
                    $status = $FAIL;
                }
            } else {
                echo "Failed to connect to database";
                die();
            }
        }

    }
?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="Deskripsi Blog">
    <meta name="author" content="Judul Blog">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="omfgitsasalmon">
    <meta name="twitter:title" content="Simple Blog">
    <meta name="twitter:description" content="Deskripsi Blog">
    <meta name="twitter:creator" content="Simple Blog">
    <meta name="twitter:image:src" content="{{! TODO: ADD GRAVATAR URL HERE }}">

    <meta property="og:type" content="article">
    <meta property="og:title" content="Simple Blog">
    <meta property="og:description" content="Deskripsi Blog">
    <meta property="og:image" content="{{! TODO: ADD GRAVATAR URL HERE }}">
    <meta property="og:site_name" content="Simple Blog">

    <link rel="stylesheet" type="text/css" href="assets/css/screen.css" />
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">

    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <title>Simple Blog | Tambah Post</title>


</head>

<body class="default">
<div class="wrapper">

    <nav class="nav">
        <a style="border:none;" id="logo" href="index.php"><h1>Simple<span>-</span>Blog</h1></a>
        <ul class="nav-primary">
            <li><a href="new_post.php">Log In</a></li>
        </ul>
    </nav>

    <article class="art simple post">


        <h2 class="art-title" style="margin-bottom:40px">-</h2>
        <script src="assets/js/post.js"></script>
        <div class="art-body">
            <div class="art-body-inner">
                <h2>Login</h2>

                <div id="contact-area">
                    <?php if(isset($status) && $status == $FAIL) { ?>
                        <p style="color:#F40034;">Username atau password salah.</p>
                    <?php } ?>
                    <form method="post" action="login.php">
                        <label for="Username">Username:</label>
                        <input type="text" name="Username" id="username" />

                        <label for="Password">Password:</label>
                        <input type="password" name="Password" id="password">
                        <div id="errorMessage">
                        </div>

                        <input type="submit" name="submit" value="Log In" class="submit-button"/>
                    </form>
                </div>
            </div>
        </div>

    </article>

    <footer class="footer">
        <div class="back-to-top"><a href="">Back to top</a></div>
        <!-- <div class="footer-nav"><p></p></div> -->
        <div class="psi">&Psi;</div>
        <aside class="offsite-links">
            Asisten IF3110 /
            <a class="rss-link" href="#rss">RSS</a> /
            <br>
            <a class="twitter-link" href="http://twitter.com/YoGiiSinaga">Yogi</a> /
            <a class="twitter-link" href="http://twitter.com/sonnylazuardi">Sonny</a> /
            <a class="twitter-link" href="http://twitter.com/fathanpranaya">Fathan</a> /
            <br>
            <a class="twitter-link" href="#">Renusa</a> /
            <a class="twitter-link" href="#">Kelvin</a> /
            <a class="twitter-link" href="#">Yanuar</a> /

        </aside>
    </footer>

</div>

<script type="text/javascript" src="assets/js/fittext.js"></script>
<script type="text/javascript" src="assets/js/app.js"></script>
<script type="text/javascript" src="assets/js/respond.min.js"></script>
<script type="text/javascript">
    var ga_ua = '{{! TODO: ADD GOOGLE ANALYTICS UA HERE }}';

    (function(g,h,o,s,t,z){g.GoogleAnalyticsObject=s;g[s]||(g[s]=
        function(){(g[s].q=g[s].q||[]).push(arguments)});g[s].s=+new Date;
        t=h.createElement(o);z=h.getElementsByTagName(o)[0];
        t.src='//www.google-analytics.com/analytics.js';
        z.parentNode.insertBefore(t,z)}(window,document,'script','ga'));
    ga('create',ga_ua);ga('send','pageview');
</script>

</body>
</html>