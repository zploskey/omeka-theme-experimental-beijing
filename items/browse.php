<?php
if (isset($_GET['query'])) {
    $pageTitle = __('Browse Items');
} else {
    $pageTitle = __('Browse Images');
}
echo head(array('title'=>$pageTitle,'bodyclass' => 'items browse'));
?>

<h1><?php echo $pageTitle;?> <?php echo __('(%s total)', $total_results); ?></h1>

<?php echo item_search_filters(); ?>

<?php echo pagination_links(); ?>

<?php if ($total_results > 0):

$sortLinks[__('Title')] = 'Dublin Core,Title';
$sortLinks[__('Creator')] = 'Dublin Core,Creator';
$sortLinks[__('Date Created')] = 'Dublin Core,Date Created'; ?>

<div class="sort-and-nav">
    <div id="sort-links">
        <span class="sort-label"><?php echo __('Sort by'); ?></span><?php echo browse_sort_links($sortLinks); ?>
    </div>
    <nav class="items-nav navigation secondary-nav">
        <?php echo public_nav_items(); ?>
    </nav>
</div>

<?php endif; ?>

<div class="items-list">
<?php foreach (loop('items') as $item): ?>
<div class="item hentry">
    <div class="item-meta">

    <?php if (metadata($item, 'has files')): ?>
    <div class="item-img">
        <?php echo link_to_item(item_image('square_thumbnail')); ?>
    </div>
    <?php endif; ?>

    <h2><?php echo link_to_item(metadata($item, array('Dublin Core', 'Title')), array('class'=>'permalink')); ?></h2>

    <?php if ($creator = metadata($item, array('Dublin Core', 'Creator'))): ?>
    <div class="item-creator">
        <?php echo $creator; ?>
    </div>
    <?php endif; ?>

    <?php if ($date_created = metadata($item, array('Dublin Core', 'Date Created'))): ?>
    <div class="item-date-created">
        <?php echo $date_created; ?>
    </div>
    <?php endif; ?>

    <?php fire_plugin_hook('public_items_browse_each', array('view' => $this, 'item' => $item)); ?>

    </div><!-- end class="item-meta" -->
</div><!-- end class="item hentry" -->
<?php endforeach; ?>
</div>

<?php echo pagination_links(); ?>

<?php fire_plugin_hook('public_items_browse', array('items'=>$items, 'view' => $this)); ?>

<?php echo foot(); ?>
