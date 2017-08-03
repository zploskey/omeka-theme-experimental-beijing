<?php $collectionTitle = __(metadata('collection', 'display_title')); ?>

<?php echo head(array('title'=> $collectionTitle, 'bodyclass' => 'collections show')); ?>

<h1><?php echo $collectionTitle; ?></h1>

<?php fire_plugin_hook('public_collections_show', array('view' => $this, 'collection' => $collection)); ?>

<?php $counts = @$this->counts; ?>

<div class="element-text">
    <?php echo metadata('collection', array('Dublin Core', 'Description')); ?>
</div>

<div id="collection-items">
    <h2></h2>
    <?php if (metadata('collection', 'total_items') > 0): ?>
        <?php foreach (loop('items') as $item): ?>
        <?php $itemTitle = metadata('item', array('Dublin Core', 'Title')); ?>
        <div class="item hentry">
            <?php if (metadata('item', 'has thumbnail')): ?>
            <div class="item-img">
                <?php echo link_to_item(item_image(null, array('alt' => $itemTitle))); ?>
            </div>
            <?php endif; ?>

            <h3><?php echo link_to_item($itemTitle, array('class'=>'permalink')); ?></h3>
            <p><?php echo isset($counts) ? $counts[$item->id].' '.__('ITEMS') : ''; ?></p>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p><?php echo __("There are currently no items within this collection."); ?></p>
    <?php endif; ?>
</div><!-- end collection-items -->


<?php echo foot(); ?>
