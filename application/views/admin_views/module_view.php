<div id="content_area">
    <?php
    echo '<article>';

    echo '<h1> Module Title: ' . ucfirst($module['title']) . '</h1>';
    echo '<p> Module Code: '. nl2br($module['code']) . br(1) . '</p>';

    echo '</article>';
   
    echo '<article>';
    echo '<h1>Edit module : '.$module['code'] .'</h1>';
    
    
    
    echo form_open();

    $data = array(
        'id' => 'module_id',
        'name' => 'module_id',
        'value' => $module['id'],
        'style' => 'width:20%',
        'type' => 'hidden'
    );
    echo form_input($data) . br();

    echo form_label('Module Code : ') . br();
    $data = array(
        'id' => 'code',
        'name' => 'code',
        'value' => ucfirst($module['code']),
        'style' => 'width:100%'
    );
    echo form_input($data) . br();
    echo form_error('code') . br();
    
    echo form_label('Module Title : ') . br();
    $data = array(
        'id' => 'title',
        'name' => 'title',
        'value' => ucfirst($module['title']),
        'style' => 'width:100%'
    );
    echo form_input($data) . br();
    echo form_error('title') . br();

    echo form_label('Stage : ') . br();
    $data = array(
        'id' => 'stage',
        'name' => 'stage',
        'value' => $module['stage'],
        'style' => 'width:100%'
    );
    echo form_input($data) . br();
    echo form_error('stage') . br();  
    
    $data = array(
        'id' => 'submit',
        'name' => 'submit',
        'value' => 'Edit Module',
        'style' => 'width:100%'
    );
    echo form_submit($data) . br();

    echo form_close();

    echo '</article>';
    ?>     
</div>
