<?php
echo '<div style="width:70%;text-align:center;background-color: #66DD88;margin: 10 auto;padding:10px;">';
echo "あなたの情報";
echo "<p>". $_SESSION['name'] ."(". $_SESSION['screen_name'] . ")</p>";
echo "<p><img src=".$_SESSION['profile_image_url_https']."></p>";
echo "</div>";
?>