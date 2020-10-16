<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once "header.php";
?>
<div class="container ">
<div class="jumbotron text-center " style="margin:0 15%;">
	<h1>Welcome to your own Custom PHP MVC Framework!!</h1><hr>
	<h4> Custom built with features like authentication,admin panel, hmvc structure and much more.... </h4>
    <hr>
    <?php echo $this->settings->get_setting('site_description');?>
</div>
</div>
</body>
</html>