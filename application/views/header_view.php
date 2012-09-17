<?= doctype('html5')  ?>
<html>
    <head>
        <title><?= $title ?></title>
        <?php
        $link = array(
            'href' => base_url().'css/style.css',
            'type' => 'text/css',
            'rel'  => 'stylesheet'
        );
        echo link_tag($link);
        ?>
    </head>
    <body>
        <div id="main_wrapper">
        <div id="header_wrapper">
            <div id="header_login">
            <h1><?= $title ?></h1>
            <br/>

            </div>
            </div>