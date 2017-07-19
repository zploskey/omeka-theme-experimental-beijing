<?php echo head(array('title' => metadata('item', array('Dublin Core', 'Title')), 'bodyclass' => 'items show')); ?>

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
echo metadata('item', array('Item Type Metadata', 'Embed'));

$elementSets = all_element_texts('item', array('return_type' => 'array'));

$elements = array();
foreach ($elementSets as $elementName => $elementInfo) {
    $elements = array_merge($elements, $elementInfo);
}
?>

<div class="placard">
    <h1>
    <?php
    echo metadata('item', array('Dublin Core', 'Title'),
                  array('no_escape' => true));
    ?>
    </h1>
    <h2><?php echo metadata('item', array('Dublin Core', 'Creator')); ?></h2>
    <h2><?php echo metadata('item', array('Dublin Core', 'Date Created')); ?></h2>
</div>

<?php
$descriptionElements = array(
    'Title',
    'Last Name',
    'First Name',
    'Gender',
    'Culture',
    'Birth Date',
    'Death Date',
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

?>

<div class="element-set">

<div id="item-description">
<a href="#description-section" class="section-toggle">
    <h1><?php echo __('Description'); ?></h1>
</a>
<div id="description-section">
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
                <?php echo $roles ? ' (' . __('role') . ')' : ''; ?>
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

</div><!-- end description-section -->
</div><!-- end item-description-tab -->

<?php if (metadata('item', 'has tags')): ?>

<div id="item-keywords">
    <a href="#keywords-section" class="section-toggle">
        <h1><?php echo __('Keywords'); ?></h1>
    </a>
    <!-- The following prints a list of all tags associated with the item -->
    <div id="keywords-section">
        <div id="item-tags" class="element">
            <h3><?php echo __('Tags'); ?></h3>
            <div class="element-text"><?php echo tag_string('item'); ?></div>
        </div>
    </div>
</div>

<?php endif;?>

<?php
$moreInfoElements = array(
    'Cultural Context',
    'Is Format Of',
    'Language',
    'Current Location',
    'Creation Location',
    'Publisher',
    'Relation',
    'Style/Period',
    'Genre',
    'URI LOC',
    'URI ULAN',
    'Rights',
);
?>

<div id="item-more-info">
    <a href="#more-info-section" class="section-toggle">
        <h1><?php echo __('More Info'); ?></h1>
    </a>
    <div id="more-info-section">
    <?php foreach ($moreInfoElements as $elementName): ?>
        <?php if (isset($elements[$elementName])): ?>
            <?php $texts = $elements[$elementName]; ?>
            <div id="item-<?php echo $elementName; ?>" class="element">
                <?php $elementName = ($elementName == 'Relation') ? 'Link' : $elementName; ?>
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

    </div><!-- end more-info-section -->
</div>

<?php fire_plugin_hook('public_items_show', array('view' => $this, 'item' => $item)); ?>

</div><!-- end element-set -->

<script>
jQuery(document).ready(function() {
    jQuery('.section-toggle').click(function() {
        var collapse_selector = jQuery(this).attr('href');
        var toggle_switch = jQuery(this);

        jQuery(collapse_selector).toggle(function() {
            if (jQuery(this).css('display') == 'none') {
                // TODO: change to minus sign
            } else {
                // TODO: change to plus sign
            }
        });
    });
});
</script>

<?php echo foot(); ?>
