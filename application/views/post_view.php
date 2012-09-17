<div id="content_area">
    <?php
    echo '<article>';

    echo '<h1>' . ucfirst($post['title']) . '</h1>';
    echo '<p>' . nl2br($post['body']) . br(1) . '</p>';
    echo '<p id="posted_date">' . $post['date'] . '</p>';

    echo '</article>';

    echo '<article>';
    echo '<table>';
    echo '<tbody>';
    foreach ($post_comments as $comment){
        echo '<tr>';
            echo '<td>'.$comment['name'].'</td>';
            echo '<td>'.$comment['date'].'</td>';
        echo '</tr>';
        echo '<tr>';
            echo '<td>'.$comment['comment'].'</td>';
        echo '</tr>';        
        
    }

    echo '</tbody>';
    echo '</table>';
    
    //print_r($post_comments);

    echo '</article>';


    echo '<article>';
    echo form_open();

    $data = array(
        'id' => 'post_id',
        'name' => 'post_id',
        'value' => $post['id'],
        'style' => 'width:20%',
        'type' => 'hidden'
    );
    echo form_input($data) . br();



    echo form_label('Name : ') . br();
    $data = array(
        'id' => 'name',
        'name' => 'name',
        'value' => set_value('name'),
        'style' => 'width:100%'
    );
    echo form_input($data) . br();
    echo form_error('name') . br();

    echo form_label('Email : ') . br();
    $data = array(
        'id' => 'email',
        'name' => 'email',
        'value' => set_value('email'),
        'style' => 'width:100%'
    );
    echo form_input($data) . br();
    echo form_error('email') . br();

    echo form_label('Your comment : ') . br();
    $data = array(
        'id' => 'comment',
        'name' => 'comment',
        'value' => set_value('comment'),
        'style' => 'width:100%; height:150px;'
    );
    echo form_textarea($data) . br();
    echo form_error('comment') . br();


    echo '<div id="captcha_div">';
    echo $image . br(2);

    if (form_error('captcha')) {
        echo form_error('captcha') . br();
    } else {
        echo form_label('Enter the text displayed above : ') . br();
    }

    $data = array(
        'id' => 'captcha',
        'name' => 'captcha',
        'value' => '',
        'style' => 'width:100%'
    );
    echo form_input($data) . br(2);

    echo form_label('Submit : ') . br(2);
    $data = array(
        'id' => 'submit',
        'name' => 'submit',
        'value' => 'Submit',
        'style' => 'width:100%'
    );
    echo form_submit($data) . br();

    echo form_close();

    echo '</article>';
    ?>     
</div>
