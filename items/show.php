<?php echo head(array('title' => metadata('item', array('Dublin Core', 'Title')), 'bodyclass' => 'items show')); ?>

<h1><?php echo metadata('item', array('Dublin Core', 'Title')); ?></h1>

<?php if ((get_theme_option('Item FileGallery') == 0) && metadata('item', 'has files')): ?>
<?php echo files_for_item(array('imageSize' => 'fullsize')); ?>
<?php endif; ?>

<!-- The following returns all of the files associated with an item. -->
<?php if ((get_theme_option('Item FileGallery') == 1) && metadata('item', 'has files')): ?>
<div id="itemfiles" class="element">
    <h3><?php echo __('Files'); ?></h3>
    <div class="element-text"><?php echo files_for_item(); ?></div>
</div>
<?php endif; ?>

<?php
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
        switch ($e[1]) {
            case 'Original Format':
                $placard .= " $text ";
                break;
            case 'Original Measurements':
                $placard .= $text;
                break;
            case 'Original Material':
                $text = '(' . $text . ') ';
                // Intentionally fall through.
            default:
                $placard .= " $text, ";
                break;
        }
    }
}

$placard = trim($placard);
if (substr($placard, -1) == ',') {
    $placard = substr($placard, 0, -1);
}

?>
<div class="placard">
    <?php echo $placard; ?>
</div>
<?php

$descriptionElements = array(
    'Title',
    'Is Part Of',
    'Creator',
    'Contributor',
    'Date Created',
    'Original Format',
    'Original Materials',
    'Original Measurements',
    'Description',
);

$roleMap = array(
    'Creator' => 'Role of Creator',
    'Contributor' => 'Role of Contributor',
);

$roles = array_keys($roleMap);

$elementSets = all_element_texts('item', array('return_type' => 'array'));

$elements = array();
foreach ($elementSets as $elementName => $elementInfo) {
    $elements = array_merge($elements, $elementInfo);
}
?>

<div id="item-description-tab" class="element-set">
<?php foreach ($descriptionElements as $elementName): ?>
    <?php $canHaveRoles = isset($roleMap[$elementName]); ?>
    <?php if(isset($elements[$elementName])): ?>
        <?php $texts = $elements[$elementName]; ?>
        <div id="<?php echo text_to_id(html_escape("$elementName")); ?>" class="element">
            <?php
            if ($canHaveRoles && isset($elements[$roleMap[$elementName]])) {
                $roles = $elements[$roleMap[$elementName]];
            } else {
                $roles = array();
            }
            ?>
            <h3>
                <?php echo html_escape(__($elementName)) ?>
                <?php echo $roles ? ' ' . __('(role)') : ''; ?>
            </h3>
            <?php foreach ($texts as $i => $text): ?>
                <div class="element-text">
                    <?php echo $text; ?>
                    <?php if (isset($roles[$i])): ?>
                        (<?php echo $roles[$i]; ?>)
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div><!-- end element -->
    <?php endif; ?>
<?php endforeach; ?>

<!-- If the item belongs to a collection, the following creates a link to that collection. -->
<?php if (metadata('item', 'Collection Name')): ?>
<div id="collection" class="element">
    <h3><?php echo __('Collection'); ?></h3>
    <div class="element-text"><p><?php echo link_to_collection_for_item(); ?></p></div>
</div>
<?php endif; ?>

</div><!-- end element-set -->

<div id="item-keywords-tab">
    <!-- The following prints a list of all tags associated with the item -->
    <?php if (metadata('item', 'has tags')): ?>
    <div id="item-tags" class="element">
        <h3><?php echo __('Tags'); ?></h3>
        <div class="element-text"><?php echo tag_string('item'); ?></div>
    </div>
    <?php endif;?>
</div>

<?php
$moreInfoElements = array(
    'Cultural Context',
    'Is Format Of',
    'Language',
    'Current Location',
    'Creation Location',
    'Publisher',
    'Relation', // Request: Can we rename this here to “Link”?
    'Rights',
);
?>

<div id="item-more-info">
    <?php foreach ($moreInfoElements as $elementName): ?>
        <?php if (isset($elements[$elementName])): ?>
            <?php $texts = $elements[$elementName]; ?>
            <div id="item-<?php echo $elementName; ?>" class="element">
                <?php $elementName = ($elementName == 'Relation') ? 'Link' : 'Relation';
                <h3><?php echo __($elementName); ?></h3>
                <?php foreach ($texts as $text): ?>
                    <div class="element-text">
                        <?php echo $text; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>

    <!-- The following prints a citation for this item. -->
    <div id="item-citation" class="element">
        <h3><?php echo __('Citation'); ?></h3>
        <div class="element-text"><?php echo metadata('item', 'citation', array('no_escape' => true)); ?></div>
    </div>

    <div id="item-output-formats" class="element">
        <h3><?php echo __('Output Formats'); ?></h3>
        <div class="element-text"><?php echo output_format_list(); ?></div>
    </div>
</div>

<?php fire_plugin_hook('public_items_show', array('view' => $this, 'item' => $item)); ?>

<nav>
<ul class="item-pagination navigation">
    <li id="previous-item" class="previous"><?php echo link_to_previous_item_show(); ?></li>
    <li id="next-item" class="next"><?php echo link_to_next_item_show(); ?></li>
</ul>
</nav>

<?php echo foot(); ?>
