<?

session_start();
session_unset();
$redirect = "";
$root = $HTTP_GET_VARS['root'];
$rooturl = $root . "_menu.php";
header("Location:$rooturl");
?>
