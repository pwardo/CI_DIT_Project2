    <?php    
   
    $tmpl = array(
        'table_open' => '<table class="Table">',
        );
    
    $this->table->set_template($tmpl);
    $this->table->set_heading('User Id', 'Username', 'Account Locked', 'logged in');
    
    foreach($users as $user){
        $this->table->add_row(
                $user['id'],
                '<a href="'.base_url().'user_admin/'.$user['id'].'">'.$user['username'].'</a>',
                $user['locked_status'],
                $user['logged_in']);    
    }
    
    
    
    echo $this->table->generate();
    ?>
    