<?php $isPerson = get_current_record('item')->getItemType()->name === "Person"; ?>

<?php echo head(array('title' => metadata('item', array('Dublin Core', 'Title')), 'bodyclass' => 'items show')); ?>

<div id="item-top">
<?php if ($isPerson): ?>
    <h1><?php
        echo metadata('item', array('Dublin Core', 'Title'), array('no_escape' => true));
    ?></h1>
<?php endif; ?>
    <div id="item-top-media">
        <?php if ((get_theme_option('Item FileGallery') == 0) && metadata('item', 'has files')): ?>
        <?php echo files_for_item(
            array(
                'imageSize' => 'fullsize',
                'linkAttributes' => array(
                    'class' => 'lightbox-link',
                    'href' => '#lightbox',
                )
            )
        ); ?>
        <div id="lightbox">
            <a id="close-out-of-bounds" href="#_">
            <?php echo files_for_item(
                array('imageSize' => 'original')
            ); ?>
            <a id="close" href="#_">Close</a>
            </a>
        </div>
        <?php endif; ?>

        <!-- The following returns all of the files associated with an item. -->
        <?php if ((get_theme_option('Item FileGallery') == 1) && metadata('item', 'has files')): ?>
        <div id="itemfiles" class="element">
            <h3><?php echo __('Files'); ?></h3>
            <div class="element-text"><?php echo files_for_item(); ?></div>
        </div>
        <?php endif; ?>

        <?php
        $embed = metadata('item', array('Item Type Metadata', 'Embed'));
        $embed = preg_replace('|(<iframe .*)(></iframe>)|',
                              '\1 allowfullscreen mozallowfullscreen webkitallowfullscreen\2',
                              $embed, 1);
        echo $embed;
        ?>
    </div>

<?php if (!$isPerson): ?>
    <div class="placard">
        <h1>
            <?php echo metadata('item', array('Dublin Core', 'Title'), array('no_escape' => true)); ?>
        </h1>
    <?php
    $creators = array_unique(metadata('item', array('Dublin Core', 'Creator'), 'all'));
    foreach($creators as $creator):
    ?>
        <h3><?php echo $creator; ?></h3>
    <?php endforeach; ?>
        <h3><?php echo metadata('item', array('Dublin Core', 'Date Created')); ?></h3>
    </div>
<?php endif; ?>
</div>

<?php fire_plugin_hook('public_items_show', array('view' => $this, 'item' => $item)); ?>

<?php
$elementSets = all_element_texts('item', array('return_type' => 'array'));

$elements = array();
foreach ($elementSets as $elementName => $elementInfo) {
    $elements = array_merge($elements, $elementInfo);
}

$aboutElements = array(
    'Title',
    // Person About metadata
    'Last Name',
    'First Name',
    'Gender',
    'Culture',
    'Birth Date',
    'Death Date',
    // Other item metadata
    'Is Part Of',
    'Creator',
    'Contributor',
    'Date Created',
    'Original Format',
    'Original Material',
    'Original Measurements',
    'Description',
);

$roleMap = array(
    'Creator' => 'Role of Creator',
    'Contributor' => 'Role of Contributor',
);

$roles = array_keys($roleMap);

?>

<div id="item-about" class="element-set<?php echo $isPerson ? ' person' : ''; ?>">
    <a href="#about-section" class="section-toggle">
        <h2><?php echo __('About'); ?><span id="expand-symbol">-</span></h2>
    </a>
    <div id="about-section">
        <div class="element-col-name"></div>
        <div class="element-col-text"></div>
<?php
    foreach ($aboutElements as $elementName):
        // Don't display title here on People items
        if ($isPerson AND $elementName === 'Title') {
            continue;
        }
        $canHaveRoles = isset($roleMap[$elementName]);
        if (isset($elements[$elementName])):
            $texts = $elements[$elementName];
?>
        <div id="<?php echo text_to_id(html_escape("$elementName")); ?>" class="element">
<?php
            if ($canHaveRoles && isset($elements[$roleMap[$elementName]])) {
                $roles = $elements[$roleMap[$elementName]];
            } else {
                $roles = array();
            }
?>
            <div class="element-cell element-cell-name"><?php
                echo html_escape(__($elementName));
                echo $roles ? ' (' . __('role') . '):' : ':';
            ?></div>
            <div class="element-cell">
<?php       foreach ($texts as $i => $text): ?>
                <div class="element-text">
                    <?php
                    if ($elementName == 'Birth Date' OR $elementName == 'Death Date') {
                        $text = preg_replace('/(.*)-0-0$/', '\1', $text, 1);
                    }
                    echo $text;
                    if (isset($roles[$i])) {
                        echo ' (' . $roles[$i] . ')';
                    }
                    ?>

                </div>
<?php       endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
<?php endforeach; ?>
    <?php if (isset($elements['Chapter'])): ?>
        <div id="book-reference" class="element">
            <div class="element-cell element-cell-name">
                <?php echo __("Book Reference") . ':'; ?>
            </div>
            <div class="element-cell">
                <?php
                $bookRef = array();
                $bookRefElements = array('Chapter', 'Plate', 'Figure', 'Page');
                foreach ($bookRefElements as $elementName) {
                    if (isset($elements[$elementName])) {
                        $elementText = $elements[$elementName][0];
                        if ($elementName === 'Chapter') {
                            $bookRef[] = $elementText;
                        } else {
                            $bookRef[] = __($elementName) . " $elementText";
                        }
                    }
                    $bookRefText = implode(', ', $bookRef);
                }
                ?>
                <div class="element-text">
                    <?php echo $bookRefText; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    </div>
</div>

<?php if (metadata('item', 'has tags')): ?>

<div id="item-keywords" class="element-set">
    <a href="#keywords-section" class="section-toggle">
        <h2>
            <?php echo __('Keywords'); ?>
            <span id="expand-symbol">+</span>
        </h2>
    </a>
    <div id="keywords-section">
        <div id="item-tags" class="element">
            <div class="element-text">
                <?php
                if (function_exists('locale_filtered_tag_string')) {
                    echo locale_filtered_tag_string('item');
                } else {
                    echo tag_string('item');
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php endif;?>

<?php if (isset($this->works)): ?>

<div id="item-works" class="element-set">
<a href="#works-section" class="section-toggle">
    <h2>
        <?php echo __('Works'); ?>
        <span id="expand-symbol">-</span>
    </h2>
</a>
</div>
<div id="works-section" class="items-list">
<?php foreach (loop('works') as $work): ?>
    <div class="item hentry">
        <div class="item-meta">
            <?php if (metadata($work, 'has files')): ?>
            <div class="item-img">
                <?php echo link_to_item(item_image('square_thumbnail', array(), 0, $work),
                                        array('class'=>'permalink'), 'show', $work); ?>
            </div>
            <?php endif; ?>

            <h3><?php echo link_to_item(
                metadata($work, array('Dublin Core', 'Title')),
                array('class'=>'permalink'), 'show', $work); ?></h3>

            <?php if ($date_created = metadata($work, array('Dublin Core', 'Date Created'))): ?>
            <div class="item-date-created">
                <?php echo $date_created; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>
</div>

<?php endif; ?>

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

<div id="item-more-info" class="element-set">
    <a href="#more-info-section" class="section-toggle">
        <h2>
            <?php echo __('More Info'); ?>
            <span id="expand-symbol">+</span>
        </h2>
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
                <?php echo __($elementName) . ':'; ?>
            </div>
            <div class="element-cell">
                <?php foreach ($texts as $text): ?>
                    <div class="element-text">
                        <?php echo $text; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
<?php endforeach; ?>

        <div id="item-citation" class="element">
            <div class="element-cell element-cell-name">
                <?php echo __('Citation') . ':'; ?>
            </div>
            <div class="element-cell">
                <div class="element-text">
                    <?php echo metadata('item', 'citation', array('no_escape' => true)); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo foot(); ?>
