<?php
/**
 * Example Application
 *
 * @package Example-application
 */
require './libs/Smarty.class.php';
$smarty = new Smarty;
//$smarty->force_compile = true;
$smarty->debugging = false;
$smarty->caching = false;
$smarty->cache_lifetime = 0;
$smarty->left_delimiter = "<{{";
$smarty->right_delimiter= "}}>";
$smarty->display("suanpage.htm");