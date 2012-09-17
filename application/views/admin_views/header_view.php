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
        
        $link2 = array(
            'href' => base_url().'css/ui-darkness/jquery-ui-1.8.21.custom.css',
            'type' => 'text/css',
            'rel'  => 'stylesheet'
        );
        echo link_tag($link);
        echo link_tag($link2);
        echo $library_src;
        echo $script_foot;
        
        
        
        ?>
<!--		<script type="text/javascript">
			$(function(){

				// Datepicker
				$('#datepicker').datepicker({
					inline: true
				});

				// Progressbar
				$("#progressbar").progressbar({
					value: 20
				});

				//hover states on the static widgets
				$('#dialog_link, ul#icons li').hover(
					function() { $(this).addClass('ui-state-hover'); },
					function() { $(this).removeClass('ui-state-hover'); }
				);

			});
		</script>-->
    </head>
    <body>
        <div id="main_wrapper">
            <div id="header-wrapper">
                <div id="header">
                    <h1><?= $title ?></h1>
                    <br/>
                </div>
                <?php
                    $data = array(
                        'id' => 'nav',
                        'menus' => array(
                            'menu1' => 'Logout',
                            'menu2' => 'Semesters',
                            'menu3' => 'Courses',
                            'menu4' => 'Manage_Users'
                        ),
                    );

                    echo admin_menu($data);
                    ?>
            </div>


            <div id="content_wrapper">
