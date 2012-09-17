<?php
$data = array(
    'id' => 'nav',
    'menus' => array(
        'menu1'=>'Manage_Users',
        'menu2'=>'Manage_Roles',
        'menu3'=>'Manage_Permissions',
        'menu4'=>'Logout'
        ),
    );

echo system_menu($data);
?>

<div id="content_wrapper">