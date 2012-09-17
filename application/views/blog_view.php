<div id="content_area">
<?php
echo '<br/><h2>'.$page_links.'</h2><br/>';

foreach($posts as $post){
    echo '<article>';
    
    echo '<a href="'.  base_url().'posts/'.str_replace(' ', '_', $post['title'].'_id_'.$post['id']).'">'.  ucfirst($post['title']).'</a><br/><br/><span id="posted_date">'.$post['date'].'</span>';
    echo '<p>'.character_limiter($post['body'],255).'<a href="'.base_url().'posts/'.str_replace(' ', '_', $post['title'].'_id_'.$post['id']).'">read more</a>'.br().'</p>';
    
    echo '</article>';
}
echo '<br/><h2>'.$page_links.'</h2><br/>';
?>
</div>
