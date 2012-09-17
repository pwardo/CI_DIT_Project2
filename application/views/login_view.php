<div id="content_wrapper">

    <div id="login_form" style="width:400px; margin:100px auto; border-radius: 5px; border:1px solid #909090; padding: 20px">
        <?php
        if (!empty($error_message)) {
            echo '<span style="color:red">' . $error_message . '</span>';
        }

        //echo '<p>'.$error_message.'</p>';
        //echo validation_errors();
        echo form_open();

        echo form_label('Username : ') . br(2);
        $data = array(
            'name' => 'user_name',
            'id' => 'user_name',
            'value' => set_value('user_name'),
            'style' => 'width:100%'
        );
        echo form_input($data);
        echo form_error('user_name');
        echo br(2);


        echo form_label('Password : ') . br(2);
        if (empty($disabled)) {
            $data = array(
                'name' => 'password',
                'id' => 'password',
                'value' => '',
                'style' => 'width:100%'
            );
        } else {
            $data = array(
                'name' => 'password',
                'id' => 'password',
                'value' => '',
                'style' => 'width:100%',
                'disabled' => 'disabled' // disabled if account is locked
            );
        }

        echo form_password($data);
        echo form_error('password');
        echo br(2);

        echo form_label('Login : ') . br(2);

        if (empty($disabled)) {
            $data = array(
                'name' => 'login',
                'id' => 'login',
                'value' => 'Login',
                'style' => 'width:40%'
            );
        } else {
            $data = array(
                'name' => 'login',
                'id' => 'login',
                'value' => 'Login',
                'style' => 'width:40%',
                'disabled' => 'disabled' // disabled if account is locked
            );
        }

        echo form_submit($data) . br();

        echo form_close();
        ?>

    </div>
