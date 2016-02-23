<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors','On');
if (isset($_POST['submit']) && (!isset($_GET['id'])))
{
    $csrf_salt = base64_encode(openssl_random_pseudo_bytes(16));
    require_once "post_utility.php";

    $sql_date = date("Y-m-d", strtotime($_POST['Tanggal']));

    $title_validated = $_POST["Judul"];
    $title_validated = preg_replace("/\&/","&amp;",$title_validated);
    $title_validated = preg_replace("/\</","&lt;",$title_validated);
    $title_validated = preg_replace("/\>/","&gt;",$title_validated);
    $title_validated = preg_replace("/\"/","&quot;",$title_validated);
    $title_validated = preg_replace("/\//","&#x2F;",$title_validated);

    $post_validated = $_POST["Konten"];
    $post_validated = preg_replace("/\&/","&amp;",$post_validated);
    $post_validated = preg_replace("/\</","&lt;",$post_validated);
    $post_validated = preg_replace("/\>/","&gt;",$post_validated);
    $post_validated = preg_replace("/\"/","&quot;",$post_validated);
    $post_validated = preg_replace("/\//","&#x2F;",$post_validated);

    createPost($csrf_salt, $session, $title_validated, $sql_date, $post_validated);

    $success = 1;
} else if (isset($_POST['submit']) && isset($_GET['id']))
{
    require_once "post_utility.php";
    $sql_date = $sql_date = date("Y-m-d", strtotime($_POST['Tanggal']));

    $title_validated = $_POST["Judul"];
    $title_validated = preg_replace("/\&/","&amp;",$title_validated);
    $title_validated = preg_replace("/\</","&lt;",$title_validated);
    $title_validated = preg_replace("/\>/","&gt;",$title_validated);
    $title_validated = preg_replace("/\"/","&quot;",$title_validated);
    $title_validated = preg_replace("/\//","&#x2F;",$title_validated);

    $post_validated = $_POST["Konten"];
    $post_validated = preg_replace("/\&/","&amp;",$post_validated);
    $post_validated = preg_replace("/\</","&lt;",$post_validated);
    $post_validated = preg_replace("/\>/","&gt;",$post_validated);
    $post_validated = preg_replace("/\"/","&quot;",$post_validated);
    $post_validated = preg_replace("/\//","&#x2F;",$post_validated);
    updatePost($_GET['id'], $title_validated, $sql_date, $post_validated);

    $success = 2;
}
else{
    $csrf_salt = base64_encode(openssl_random_pseudo_bytes(16));
    $_SESSION['csrf_salt'] = $csrf_salt;
    $session = $_SESSION['csrf_salt'];
}

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

<nav class="nav">
    <a style="border:none;" id="logo" href="index.php"><h1>Simple<span>-</span>Blog</h1></a>
    <ul class="nav-primary">
        <li><a href="new_post.php">+ Tambah Post</a></li>
    </ul>
</nav>

<article class="art simple post">
    
    
    <h2 class="art-title" style="margin-bottom:40px">-</h2>
    <script src="assets/js/post.js"></script>
    <div class="art-body">
        <div class="art-body-inner">
            <h2><?php if(isset($_GET['id'])) {echo "Edit Post";} else { echo "Tambah Post";}?></h2>

            <div id="contact-area">
                <?php if(isset($success)){if($success == 1){header('Location: index.php');} else if($success == 2){header('Location: index.php');}}?>
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