<div id="content_area">
    <article>
        <?php
        echo form_open();

        echo form_label('Course Title') . br();
        $data = array(
            'id' => 'title',
            'name' => 'title',
            'value' => set_value('title'),
            'style' => 'width:100%',
        );
        echo form_input($data) . br(2);
        echo form_error('title');

        echo form_label('Course Code') . br();
        $data = array(
            'id' => 'code',
            'name' => 'code',
            'value' => set_value('code'),
            'style' => 'width:100%',
        );
        echo form_input($data) . br(2);
        echo form_error('code');

        $data = array(
            'id' => 'submit',
            'name' => 'submit',
            'value' => 'Create Course',
            'style' => 'padding:10px; width:200px',
        );
        echo form_submit($data);

        echo form_close();
        ?>
    </article>
</div>