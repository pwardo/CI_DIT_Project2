<div id="content_area">
<?php
$tmpl = array(
    'table_open' => '<table class="Table">',
);

$this->table->set_template($tmpl);

$this->table->set_heading('Start Date', 'End Date ');

$data = array();

$i = (int)0;
foreach($semesters as $semester){
    $data[$i] = array(
        '<a href="'.  base_url().'semesters/'.str_replace('/', '_', $semester['start_date'].'_id_'.$semester['id']).'">'.  $semester['start_date'].'</a>', $semester['end_date']
    );
    $i = (int)$i + (int)1;
}
echo $this->table->generate($data);

echo '<br/><h2>'.$page_links.'</h2><br/>';
?>
</div>
<aside>
    <?php
        echo '<b><a href="'.base_url().'admin/add_semester">Add New semester</a></b>';
    ?>
</aside>    
