<div id="content_area">
<?php
$tmpl = array(
    'table_open' => '<table class="Table">',
);

$this->table->set_template($tmpl);

$this->table->set_heading('Course Code', 'Course Title');

$data = array();

$i = (int)0;
foreach($courses as $course){
    $data[$i] = array(
        $course['code'], '<a href="'.  base_url().'courses/'.str_replace(' ', '_', $course['title'].'_id_'.$course['id']).'">'.  ucfirst($course['title']).'</a>'
    );
    $i = (int)$i + (int)1;
}
echo $this->table->generate($data);

echo '<br/><h2>'.$page_links.'</h2><br/>';
?>
</div>
<aside>
    <?php
        echo '<b><a href="'.base_url().'admin/add_course">Add New Course</a></b>';
    ?>
</aside>    
