<?php echo head(array('bodyid' => 'home')); ?>

<?php if ($homepageText = get_theme_option('Homepage Text')) : ?>
<p class="intro"><?php echo $homepageText; ?></p>
<?php endif; ?>

<div id="featured">
    <?php if (get_theme_option('Display Featured Item') == 1) : ?>
    <!-- Featured Item -->
    <div id="featured-items">
        <h2><?php echo __('Featured Item'); ?></h2>
        <?php echo random_featured_items(1); ?>
    </div>
     <!--end featured-item-->
    <?php endif; ?>

    <?php if (get_theme_option('Display Featured Collection')) : ?>
    <!-- Featured Collection -->
    <div id="featured-collection">
        <h2><?php echo __('Featured Collection'); ?></h2>
        <?php echo random_featured_collection(); ?>
    </div>
     <!-- End Featured Collection -->
    <?php endif; ?>

<?php
if ((get_theme_option('Display Featured Exhibit'))
    && plugin_is_active('ExhibitBuilder')
    && function_exists('exhibit_builder_random_featured_exhibit')
) : ?>
    <!-- Featured Exhibit -->
    <div class="featured-exhibit">
        <?php echo exhibit_builder_display_random_featured_exhibit(); ?>
    </div>
    <?php endif; ?>
</div><!-- End Featured/Primary Column -->

<?php
if (get_theme_option('Display Recent Items')) {
    $recentItems = get_theme_option('Homepage Recent Items');
    if ($recentItems === null || $recentItems === '') {
        $recentItems = 3;
    } else {
        $recentItems = (int) $recentItems;
    }
}
if (isset($recentItems)) : ?>
<!-- Recent Items -->
<div id="recent-items">
    <h2><?php echo __('Recently Added Items'); ?></h2>
    <?php echo recent_items($recentItems); ?>
    <p class="view-items-link">
        <?php echo link_to_items_browse(__('View All Items')); ?>
    </p>
</div><!--end recent-items -->
<?php endif; ?>

<?php fire_plugin_hook('public_home', array('view' => $this)); ?>

<?php echo foot(); ?>
