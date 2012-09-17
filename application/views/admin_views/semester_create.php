<div id="content_area">
    <article>
     
        <?php
        echo form_open();

        echo form_label('Start Date') . br();
        $data = array(
            'id' => 'from',
            'name' => 'from',
            'value' => set_value('from'),
            'style' => 'width:30%',
        );
        
        echo form_input ($data) . br(2);
        echo form_error('start_date');

        echo form_label('End Date') . br();
        $data = array(
            'id' => 'to',
            'name' => 'to',
            'value' => set_value('to'),
            'style' => 'width:30%',
        );
        echo form_input($data) . br(2);
        echo form_error('end');

        $data = array(
            'id' => 'submit',
            'name' => 'submit',
            'value' => 'Shedule Semester',
            'style' => 'padding:10px; width:200px',
        );
        echo form_submit($data);

        echo form_close();
        ?>
    </article>
</div>