<?php echo head(array('title' => metadata('item', array('Dublin Core', 'Title')), 'bodyclass' => 'items show')); ?>

<h1><?php echo metadata('item', array('Dublin Core', 'Title')); ?></h1>

<?php if ((get_theme_option('Item FileGallery') == 0) && metadata('item', 'has files')): ?>
<?php echo files_for_item(array('imageSize' => 'fullsize')); ?>
<?php endif;

try {
    echo metadata('item', array('Item Type Metadata', 'Embed'));
} catch (Omeka_Record_Exception $e) {
    // simply don't display it
}

$placard_entries = array(
    array('Dublin Core', 'Title'),
    array('Dublin Core', 'Creator'),
    array('Dublin Core', 'Date Created'),
    array('Item Type Metadata', 'Original Format'),
    array('Item Type Metadata', 'Original Material'),
    array('Item Type Metadata', 'Original Measurements'),
);

$placard = '';
foreach($placard_entries as $e) {
    $text = '';
    try {
        $text = metadata('item', $e, array('all' => true, 'delimiter' => ', '));
    } catch (Omeka_Record_Exception $e) {
        continue;
    }
    if (! ($text === '')) {
        if ($e[1] === 'Original Material') {
            $text = '(' . $text . ')';
        }

        if ($e[1] === 'Original Format') {
            $placard .= $text . ' ';
        } elseif ($e[1] === 'Original Measurements') {
            $placard .= $text;
        } else {
            $placard .= $text . ', ';
        }
    }
}

if (substr($placard, -1) == ',') {
    $placard = substr($placard, 0, -1);
}

?>
<div id="placard">
<?php echo $placard; ?>
</div>
<?php echo all_element_texts('item'); ?>

<!-- The following returns all of the files associated with an item. -->
<?php if ((get_theme_option('Item FileGallery') == 1) && metadata('item', 'has files')): ?>
<div id="itemfiles" class="element">
    <h3><?php echo __('Files'); ?></h3>
    <div class="element-text"><?php echo files_for_item(); ?></div>
</div>
<?php endif; ?>

<!-- If the item belongs to a collection, the following creates a link to that collection. -->
<?php if (metadata('item', 'Collection Name')): ?>
<div id="collection" class="element">
    <h3><?php echo __('Collection'); ?></h3>
    <div class="element-text"><p><?php echo link_to_collection_for_item(); ?></p></div>
</div>
<?php endif; ?>

<!-- The following prints a list of all tags associated with the item -->
<?php if (metadata('item', 'has tags')): ?>
<div id="item-tags" class="element">
    <h3><?php echo __('Tags'); ?></h3>
    <div class="element-text"><?php echo tag_string('item'); ?></div>
</div>
<?php endif;?>

<!-- The following prints a citation for this item. -->
<div id="item-citation" class="element">
    <h3><?php echo __('Citation'); ?></h3>
    <div class="element-text"><?php echo metadata('item', 'citation', array('no_escape' => true)); ?></div>
</div>

<div id="item-output-formats" class="element">
    <h3><?php echo __('Output Formats'); ?></h3>
    <div class="element-text"><?php echo output_format_list(); ?></div>
</div>

<?php fire_plugin_hook('public_items_show', array('view' => $this, 'item' => $item)); ?>

<nav>
<ul class="item-pagination navigation">
    <li id="previous-item" class="previous"><?php echo link_to_previous_item_show(); ?></li>
    <li id="next-item" class="next"><?php echo link_to_next_item_show(); ?></li>
</ul>
</nav>

<?php echo foot(); ?>
