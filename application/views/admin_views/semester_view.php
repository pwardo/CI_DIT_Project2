<div id="content_area">
    <?php
    echo '<article>';
    
    echo '<h2> Start Date: ' . $semester['start_date'] . '</h2><br/>';
    echo '<h2> End Date: ' . $semester['end_date'] . br(1) . '</h2>';

    echo '</article>';

    echo '<article>';

    echo '<h1>Course Modules</h1>';
    $tmpl = array(
        'table_open' => '<table class="Table">',
    );

    $this->table->set_template($tmpl);

    $this->table->set_heading('Code', 'Title', 'Stage');

    foreach ($semester_courses as $module) {
        $this->table->add_row(
                $module['code'],
                '<a href="'.base_url().'modules/'.$course['id'].'/'.$module['id'].'">'.$module['title'].'</a>',
                 $module['stage']
        );
    }
    echo $this->table->generate();
    echo '</article>';
    
    
    echo '<article>';
    echo '<h1>Add a new module </h1>';
    echo form_open();

    $data = array(
        'id' => 'course_id',
        'name' => 'course_id',
        'value' => $course['id'],
        'style' => 'width:20%',
        'type' => 'hidden'
    );
    echo form_input($data) . br();

    echo form_label('Module Code : ') . br();
    $data = array(
        'id' => 'code',
        'name' => 'code',
        'value' => set_value('code'),
        'style' => 'width:100%'
    );
    echo form_input($data) . br();
    echo form_error('code') . br();
    
    echo form_label('Module Title : ') . br();
    $data = array(
        'id' => 'title',
        'name' => 'title',
        'value' => set_value('title'),
        'style' => 'width:100%'
    );
    echo form_input($data) . br();
    echo form_error('title') . br();

    echo form_label('Stage : ') . br();
    $data = array(
        'id' => 'stage',
        'name' => 'stage',
        'value' => set_value('stage'),
        'style' => 'width:100%'
    );
    echo form_input($data) . br();
    echo form_error('stage') . br();


    $data = array(
        'id' => 'submit',
        'name' => 'submit',
        'value' => 'Create new module',
        'style' => 'width:100%'
    );
    echo form_submit($data) . br();

    echo form_close();

    echo '</article>';
    ?>     
</div>
