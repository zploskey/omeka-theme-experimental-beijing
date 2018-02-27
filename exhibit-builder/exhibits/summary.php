<?php echo head(array('title' => metadata('exhibit', 'title'), 'bodyclass'=>'exhibits summary')); ?>

<div id="exhibit-titleblock">
    <h3><?php echo __(get_theme_option('exhibits_bookpart')); ?></h3>
    <h1><?php echo metadata('exhibit', 'title'); ?></h1>
</div>

<?php echo exhibit_builder_page_nav(); ?>

<?php
$pageTree = exhibit_builder_page_tree();

if ($pageTree):
?>

<nav id="exhibit-pages">
    <?php
    $link = exhibit_builder_link_to_exhibit($exhibit, null,
                                            array('class' => 'active')
    );
    $pageTree = preg_replace('/^<ul><li/', "<ul><li class=\"current\">$link</li><li", $pageTree, 1);
    echo $pageTree;
    ?>
</nav>
<?php endif; ?>

<div id="primary">

<?php if ($exhibitDescription = metadata('exhibit', 'description', array('no_escape' => true))): ?>
<div class="exhibit-description">
    <?php echo $exhibitDescription; ?>
</div>
<?php endif; ?>

<?php if (($exhibitCredits = metadata('exhibit', 'credits'))): ?>
<div class="exhibit-credits">
    <h3><?php echo __('Credits'); ?></h3>
    <p><?php echo $exhibitCredits; ?></p>
</div>
<?php endif; ?>
</div>

<?php echo foot(); ?>
