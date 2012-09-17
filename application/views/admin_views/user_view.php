<?php
echo '<h1> Locked Status: ' . ucfirst($user['locked_status']) . '</h1>';
if($user['locked_status'] === 'yes'){
    echo '<a href=' . base_url() . 'admin/unlock/' . $user['id'] . '>Unlock User</a>';
}
$tmpl = array(
    'table_open' => '<table class="Table">',
    'style' => 'width:100px;',
);

$this->table->set_template($tmpl);

$this->table->set_heading('Session Start', 'Login Attempts', 'Session end', 'Time On Site');

$data = array();
$format = 'DATE_COOKIE';


$i = (int)0;

    foreach ($user_sessions as $user_session) {
        $start  = standard_date($format, (int)$user_session['session_start']).'<br/>'; 
        $end  = standard_date($format, (int)$user_session['session_end']).'<br/>';
        if((int)$user_session['session_start'] != 0){
            $time_on_site = timespan((int)$user_session['session_start'], (int)$user_session['session_end']);
        }
        
        
        $data[$i] = array(
//            $user_session['user_id'],
            $start,
            $user_session['login_attempt'],
            $end,
            $time_on_site,
        );
            $i = (int)$i + (int)1;
    }
    
echo $this->table->generate($data);

?>