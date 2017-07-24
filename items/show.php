<?php echo head(array('title' => metadata('item', array('Dublin Core', 'Title')), 'bodyclass' => 'items show')); ?>

<div id="item-top">
    <div id="item-top-media">
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

        <?php echo metadata('item', array('Item Type Metadata', 'Embed')); ?>
    </div>

    <div class="placard">
        <h1>
        <?php echo metadata('item', array('Dublin Core', 'Title'), array('no_escape' => true)); ?>
        </h1>
    <?php foreach(metadata('item', array('Dublin Core', 'Creator'), 'all') as $creator): ?>
        <h2><?php echo $creator; ?></h2>
    <?php endforeach; ?>
        <h2><?php echo metadata('item', array('Dublin Core', 'Date Created')); ?></h2>
    </div>
</div>

<?php
$elementSets = all_element_texts('item', array('return_type' => 'array'));

$elements = array();
foreach ($elementSets as $elementName => $elementInfo) {
    $elements = array_merge($elements, $elementInfo);
}

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
    <h1>
        <?php echo __('Description'); ?>
        <span id="expand-symbol">-</span>
    </h1>
</a>
<div id="description-section">
    <div class="element-col-name"></div>
    <div class="element-col-text"></div>
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
            <div class="element-cell element-cell-name">
                <h3>
                    <?php echo html_escape(__($elementName)); ?>
                    <?php echo $roles ? ' (' . __('role') . '):' : ':'; ?>
                </h3>
            </div>
            <div class="element-cell element-cell-text">
                <?php foreach ($texts as $i => $text): ?>
                    <div class="element-text">
                        <?php
                        if ($elementName == 'Birth Date' OR $elementName == 'Death Date') {
                            $text = preg_replace('/(.*)-0-0$/', '\1', $text, 1);
                        }
                        ?>
                        <?php echo $text; ?>
                        <?php if (isset($roles[$i])): ?>
                            (<?php echo $roles[$i]; ?>)
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div><!-- end element -->
    <?php endif; ?>
<?php endforeach; ?>

</div><!-- end description-section -->
</div><!-- end item-description -->

<?php if (metadata('item', 'has tags')): ?>

<div id="item-keywords">
    <a href="#keywords-section" class="section-toggle">
        <h1>
            <?php echo __('Keywords'); ?>
            <span id="expand-symbol">+</span>
        </h1>
    </a>
    <!-- The following prints a list of all tags associated with the item -->
    <div id="keywords-section">
        <div id="item-tags" class="element">
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
        <h1>
            <?php echo __('More Info'); ?>
            <span id="expand-symbol">+</span>
        </h1>
    </a>
    <div id="more-info-section">
        <div class="element-col-name"></div>
        <div class="element-col-text"></div>
    <?php foreach ($moreInfoElements as $elementName): ?>
        <?php if (isset($elements[$elementName])): ?>
            <?php $texts = $elements[$elementName]; ?>
            <div id="item-<?php echo $elementName; ?>" class="element">
                <?php $elementName = ($elementName == 'Relation') ? 'Link' : $elementName; ?>
                <div class="element-cell element-cell-name">
                    <h3><?php echo __($elementName) . ':'; ?></h3>
                </div>
                <div class="element-cell element-cell-text">
                    <?php foreach ($texts as $text): ?>
                        <div class="element-text">
                            <?php echo $text; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>

    <!-- The following prints a citation for this item. -->
    <div id="item-citation" class="element">
        <div class="element-cell element-cell-name">
            <h3><?php echo __('Citation') . ':'; ?></h3>
        </div>
        <div class="element-cell element-cell-text">
            <div class="element-text">
                <?php echo metadata('item', 'citation', array('no_escape' => true)); ?>
            </div>
        </div>
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
                jQuery('#expand-symbol', toggle_switch).html('+');
            } else {
                jQuery('#expand-symbol', toggle_switch).html('-');
            }
        });
    });
});
</script>

<?php echo foot(); ?>
