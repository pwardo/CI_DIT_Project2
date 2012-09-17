<div id="content_area">
<?php
$tmpl = array(
    'table_open' => '<table class="Table">',
);

$this->table->set_template($tmpl);

$this->table->set_heading('User ID', 'Username', 'Locked Status', 'Logged In');


//echo '<br/><h2>'.$page_links.'</h2><br/>';

foreach ($users as $user) {
    
    $this->table->add_row(
        $user['id'], '<a href="' . base_url() . 'users/' . $user['id'] . '">' . $user['username'] . '</a>', $user['locked_status'], $user['logged_in']
    );
}
echo '</article>';
echo $this->table->generate();


//echo '<br/><h2>'.$page_links.'</h2><br/>';
?>
</div>
<aside>
    <?php
        echo '<a href="'.base_url().'admin/add_course">Locked Users</a><br/>';
        echo '<a href="'.base_url().'admin/add_course">All Users</a>';
    ?>
</aside>    
