<?php
echo '<div style="width:100%;position: fixed;text-align:center;top:0px;left:0px;background-color: #66DD88;height:50px;padding:5px;border: dotted #008080;">';
echo "<img src=".$_SESSION['profile_image_url_https'].">". $_SESSION['name'] ."(". $_SESSION['screen_name'] . ")</p>";
echo "</div>";
?>