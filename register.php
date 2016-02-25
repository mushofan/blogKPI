<?php
/**
 * Created by IntelliJ IDEA.
 * User: fahziar
 * Date: 23/02/2016
 * Time: 13.22
 */
require_once  'db_config.php';
require_once 'util.php';
require_once 'session.php';
$SUCCESS = 1;
$USERNAME_EXISTS = 2;
$PASSWORD_TOO_LONG = 3;
$WRONG_USERNAME = 4;
$INVALID_PASSWORD = 5;

if (isset($_POST['submit']) && isset($_POST['Username']) && isset($_POST['Password'])){
    if (Util::validateUsername($_POST['Username'])) {
        if (Util::validatePassword($_POST['Password'])){
            //Check username exists
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
            $statement->bind_param('s', $_POST['Username']);
            $statement->execute();
            if ($statement->fetch()) {
                $status = $USERNAME_EXISTS;
            } else {
                $statement = $mysqli->prepare("INSERT INTO `user`(`username`, `password`) VALUES(?, ?)");
                if ($statement->bind_param('ss', $_POST['Username'], password_hash($_POST['Password'], PASSWORD_BCRYPT))){
                    if ($statement->execute()){
                        $status = $SUCCESS;
                    } else {
                        echo 'Failed to add user';
                        exit(0);
                    }
                } else {
                    echo 'Failed to add user';
                    exit(0);
                }
            }
        } else {
            $status = $INVALID_PASSWORD;
        }
    } else {
        $status = $WRONG_USERNAME;
    }
}


?>
<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<meta name="description" content="Deskripsi Blog" />
<meta name="author" content="Judul Blog" />

<!-- Twitter Card -->

<meta property="og:type" content="article" />
<meta property="og:title" content="Simple Blog" />
<meta property="og:description" content="Deskripsi Blog" />
<meta property="og:image" content="{{! TODO: ADD GRAVATAR URL HERE }}" />
<meta property="og:site_name" content="Simple Blog" />

<link rel="stylesheet" type="text/css" href="assets/css/screen.css" />
<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico" />

<!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<title>New User - Simple Blog</title>


</head>

<body class="default">
<div class="wrapper">
    <?php require_once "header.php";?>

 <div style="position:relative;top:180px;left:300px;">
  <h2>New User</h2>

<div id="contact-area">
    <?php if(isset($status) && $status == $USERNAME_EXISTS) { ?>
        <p style="color:#F40034;">Username sudah digunakan</p>
    <?php } ?>
    <?php if(isset($status) && $status == $PASSWORD_TOO_LONG) { ?>
        <p style="color:#F40034;">Password terlalu panjang/p>
    <?php } ?>
    <?php if(isset($status) && $status == $WRONG_USERNAME) { ?>
        <p style="color:#F40034;">Username hanya boleh mengandung huruf kecil,angka dan _</p>
    <?php } ?>
    <?php if(isset($status) && $status == $INVALID_PASSWORD) { ?>
        <p style="color:#F40034;">Panjang password minimal 6 karakter dan maksimal 50 karakter</p>
    <?php } ?>
    <form method="post" action="register.php">
        <label for="Username">Username:</label>
        <input type="text" name="Username" id="username" />

        <label for="Password">Password:</label>
        <input type="password" name="Password" id="password">
        <div id="errorMessage">
        <input type="submit" name="submit" value="Register">
        </div>
    </form>
</div>
</div>

<footer class="footer" style="top:230px;">
    <div class="back-to-top"><a href="">Back to top</a></div>
    <!-- <div class="footer-nav"><p></p></div> -->
    <div class="psi">&#x3A8;</div>
    <aside class="offsite-links">
Asisten IF3110 /
        <a class="rss-link" href="#rss">RSS</a> /
        <br />
        <a class="twitter-link" href="http://twitter.com/YoGiiSinaga">Yogi</a> /
        <a class="twitter-link" href="http://twitter.com/sonnylazuardi">Sonny</a> /
        <a class="twitter-link" href="http://twitter.com/fathanpranaya">Fathan</a> /
        <br />
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