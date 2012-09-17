<?php

if (isset($user_sessions)) {
    echo heading("User's Session Log");
    echo '<table border="1" cellpadding="5" cellspacing="2" style="border-collapse: collapse;">
                <thead>
                    <tr>
                    <th>User ID</th><th>user name</th><th>Session Start</th><th>Login Attempts</th><th>Session end</th><th>Time On Site</th></tr>
                    </thead>
                    <tbody>
                    <tr>
                <tbody>';

    foreach ($user_sessions as $user_session) {

        echo '<tr>';
        echo '<td>' . $user_session['user_id'] . '</td>';
        echo '<td>' . $user_session['username'] . '</td>';
        echo '<td>' . date('F j, Y, H:i:s a', $user_session['session_start']) . '</td>';
        echo '<td>' . $user_session['login_attempt'] . '</td>';
        echo '<td>';
        if (($user_session['session_end']) != 0) {
            echo (date('F j, Y, H:i:s a', $user_session['session_end']));
        }
        echo '</td>';
        echo '<td>';
        if (($user_session['session_end']) != 0) {
            $time_on_site = $user_session['session_end'] - $user_session['session_start'];
            echo (date('i\m\n : s\s', $time_on_site));
        }
        echo '</td></tr>';
    }
    
    echo'</tbody></table>';
    
} else if (isset($locked_users)) {
    echo heading("locked Users");
    echo '
            <table border="1" cellpadding="5" cellspacing="2" style="border-collapse: collapse;">
                <thead>
                    <tr>
                    <th>user_id</th><th>User_name</th><th>Account Locked</th><th>Unlock User</th></tr>
                    </thead>
                    <tbody>
                    <tr>
                <tbody>';
    
    foreach ($locked_users as $locked_user) {

        echo '<tr>
                <td>' . $locked_user['id'] . '</td>
                <td>' . $locked_user['username'] . '</td>
                <td>' . $locked_user['locked_status'] . '</td>
                <td><a href=' . base_url() . 'admin/unlock/' . $locked_user['id'] . '>Unlock User</a></td>
             </tr>';
    }

    echo '</tbody></table>';
} else if (isset($users)) {
    echo heading("List of Users");
    $tmpl = array('table_open' => '<table border="1" cellpadding="5" cellspacing="2" ;>');
    $this->table->set_template($tmpl);
    $this->table->set_heading('User Id', 'Username', 'Account Locked', 'logged in');
    echo br();
    echo $this->table->generate($users);
}
?>