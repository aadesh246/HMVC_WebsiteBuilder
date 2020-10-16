<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Router class */
require APPPATH."third_party/MX/Router.php";

class MY_Router extends MX_Router {
	public function settings()
	{
    include(APPPATH.'config/database.php');

    $conn = mysqli_connect($db['default']['hostname'], $db['default']['username'], $db['default']['password']);
    $conn -> select_db("codeigproject");

    $sql = sprintf("SELECT option_value  FROM settings WHERE option_name = 'base_controller'");
    $query = $conn->query($sql);
    mysqli_close($conn);
    if ($row = $query->fetch_assoc()) {
    return $row['option_value'];
}

	}
}