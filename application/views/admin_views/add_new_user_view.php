<div id="content_area">
    <article>
        <h1>Choose user type</h1><br/>
        
        <?php
        //print_r($options);
        echo form_open();

        echo form_label('User Type') . br();

        echo form_dropdown('roles', $options, '4') . br(2);
        
        $data = array(
            'id' => 'submit',
            'name' => 'submit',
            'value' => 'Submit',
            'style' => 'padding:10px; width:200px',
        );
        
        echo form_submit($data);

        echo form_close();
        ?>
    </article>
</div>