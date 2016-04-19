
<?php foreach($posts as $post): ?>
    <div class="post">
        <p>Autor: <?php echo $post->base_product_id; ?></p>
        <p>colour:<?php echo $post->color; ?></p>
    </div>
<?php endforeach; ?>
<?php foreach($posts as $post): ?>
    <div id="posts" class="post">
        <p>Autor: <?php echo $post->base_product_id; ?></p>
        <p>colour:<?php echo $post->color; ?></p>
    </div>
<?php endforeach;
?>
    <?php $this->widget('ext.yiinfinite-scroll.YiinfiniteScroller', array(
    'itemSelector' => 'div.post',
    'pages' => $pages,
));?>
<?php $this->widget('ext.yiinfinite-scroll.YiinfiniteScroller', array(
    'contentSelector' => '#posts',
    'itemSelector' => 'div.post',
    'loadingText' => 'Loading...',
    'donetext' => 'This is the end... my only friend, the end',
    'pages' => $pages,
)); ?>