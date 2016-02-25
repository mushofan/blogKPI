<?php
/**
 * Created by PhpStorm.
 * User: Aldyaka Mushofan
 * Date: 2/25/2016
 * Time: 4:12 PM
 */
echo "<nav class=\"nav\">
    <a style=\"border:none;\" id=\"logo\" href=\"index.php\"><h1>Simple<span>-</span>Blog</h1></a>
    <ul class=\"nav-primary\">";
if (SessionManager::isLoggedIn())
{
    echo "<li><a href=\"images.php\">Lihat Gambar</a> </li>
        <li>|</li>
        <li><a href=\"new_post.php\">+ Tambah Post</a></li>
        <li>|</li>
        <li><a href=\"new_image_post.php\">+ Tambah Gambar</a></li>
        <li>|</li>
        <li><a href='logout.php'>Logout</a> </li>
    </ul>
</nav>";
}
else{
    echo "<li><a href=\"images.php\">Lihat Gambar</a> </li> <li>|</li>
        <li> <a href='login.php'> Login </a> </li>
    </ul>
    </nav>";
}
?>