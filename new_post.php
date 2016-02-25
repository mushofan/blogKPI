<?php
require_once 'session.php';
SessionManager::sessionStart();

if (!SessionManager::isLoggedIn()){
    header("Location: login.php");
    die();
}

error_reporting(E_ALL);
ini_set('display_errors','On');

//Proses post baru
if (isset($_POST['submit']) && (!isset($_GET['id'])) && (isset($_SESSION['csrf_salt'])) && (isset($_POST['csrf_salt'])))
{
    if (!preg_match_all("/^(\d{1,2})-(\d{1,2})-(\d{4})$/", $_POST['Tanggal'])){
        header('Location: new_post.php');
        die();
    }
    require_once "post_utility.php";
    require "util.php";
    $sql_date = date("Y-m-d", strtotime($_POST['Tanggal']));

    $title_sanitized = Util::sanitize($_POST["Judul"]);

    $post_sanitized = Util::sanitize($_POST["Konten"]);

    if ($_POST['csrf_salt'] === $_SESSION['csrf_salt']) {
        createPost($title_sanitized, $sql_date, $post_sanitized);
    } else {

    }

    header("Location: index.php");
    die();
} else if (isset($_POST['submit']) && isset($_GET['id']) && (isset($_SESSION['csrf_salt'])))
{
    require_once "post_utility.php";
    require "util.php";
    $sql_date = $sql_date = date("Y-m-d", strtotime($_POST['Tanggal']));

    $title_sanitized = Util::sanitize($_POST["Judul"]);

    $post_sanitized = Util::sanitize($_POST["Konten"]);
    if ($_POST['csrf_salt'] === $_SESSION['csrf_salt']) {
        updatePost($_GET['id'], $title_sanitized, $sql_date, $post_sanitized);
    }
    header("Location: index.php");
    die();
}
else{
    $csrf_salt = base64_encode(openssl_random_pseudo_bytes(16));
    $_SESSION['csrf_salt'] = $csrf_salt;
    $session = $_SESSION['csrf_salt'];
    SessionManager::regenerateSession();
}

//Ambil post lama
if (isset($_GET['id']))
{
    require_once "post_utility.php";
    $post = loadPost($_GET['id']);
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
    <?php require_once "header.php";?>
<article class="art simple post">
    
    
    <h2 class="art-title" style="margin-bottom:40px">-</h2>
    <script src="assets/js/post.js"></script>
    <div class="art-body">
        <div class="art-body-inner">
            <h2><?php if(isset($_GET['id'])) {echo "Edit Post";} else { echo "Tambah Post";}?></h2>

            <div id="contact-area">
                <form method="post" action="#">
                    <input type="hidden" name="csrf_salt" id="csrf_salt" value="<?php echo $csrf_salt ?>"/>
                    <label for="Judul">Judul:</label>
                    <input type="text" name="Judul" id="Judul" <?php if(isset($post)) echo 'value="'.$post['judul'].'"';?>>

                    <label for="Tanggal">Tanggal:</label>
                    <input type="text" name="Tanggal" id="Tanggal" <?php if(isset($post)) echo 'value="'.date("d-m-Y", strtotime($post['tanggal'])).'"';?>>
                    <div id="errorMessage">
                    </div>
                    <label for="Konten">Konten:</label><br>
                    <textarea name="Konten" rows="20" cols="20" id="Konten" ><?php if(isset($post)) echo $post['konten'];?></textarea>

                    <input type="submit" name="submit" value="Simpan" class="submit-button" onclick="return validate();">
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