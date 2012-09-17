<div id="content_area">
    <article>
        <?php
        echo form_open();

        echo form_label('Post Title') . br();
        $data = array(
            'id' => 'title',
            'name' => 'title',
            'value' => set_value('title'),
            'style' => 'width:600px',
        );
        echo form_input($data) . br(2);
        echo form_error('title');

        echo form_label('Post Body') . br();
        $data = array(
            'id' => 'body',
            'name' => 'body',
            'value' => set_value('body'),
            'style' => 'width:600px; height:300px',
        );
        echo form_textarea($data) . br(2);
        echo form_error('body');

        $data = array(
            'id' => 'submit',
            'name' => 'submit',
            'value' => 'Save Post',
            'style' => 'padding:10px; width:200px',
        );
        echo form_submit($data);

        echo form_close();
        ?>
    </article>
</div>