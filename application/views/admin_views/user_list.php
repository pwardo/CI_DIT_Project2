<div id="content_area">
<?php
$tmpl = array(
    'table_open' => '<table class="Table">',
);

$this->table->set_template($tmpl);

$this->table->set_heading('User ID', 'Username', 'Locked Status', 'Logged In');

$data = array();

$i = (int)0;
foreach ($users as $user) {
    if($user['locked_status'] === 'yes'){
        $locked_status = 'YES, <a href=' . base_url() . 'admin/unlock/' . $user['id'] . '>Unlock User</a>';
    } else {
        $locked_status = 'no';
    }
    
    
    $data[$i] = array(
        $user['id'], 
        '<a href="' . base_url() . 'users/'. $user['id'] .'">' . $user['username'] . '</a>', 
        $locked_status, 
        $user['logged_in']
        );
    $i = (int)$i + (int)1;
}
echo $this->table->generate($data);

echo '<br/><h2>'.$page_links.'</h2><br/>';
?>
</div>
<aside>
    <?php
        echo '<b><a href="'.base_url().'admin/manage_locked_users">Locked Users</a></b><br/><br/>';
        echo '<b><a href="'.base_url().'admin/manage_users">All Users</a></b></b><br/><br/>';
        echo '<b><a href="'.base_url().'admin/_add_user">Add New User</a></b></b><br/><br/>';
    ?>
</aside>    
