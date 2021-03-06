<?php
echo head(array(
    'title' => metadata('exhibit_page', 'title') . ' &middot; ' . metadata('exhibit', 'title'),
    'bodyclass' => 'exhibits show'));
?>

<div id="exhibit-titleblock">
    <h3><?php echo __(get_theme_option('exhibits_bookpart')); ?></h3>
    <h1><?php echo metadata('exhibit', 'title'); ?></h1>
</div>

<nav id="exhibit-pages">
    <?php
    $link = exhibit_builder_link_to_exhibit($exhibit);
    $pageTree = exhibit_builder_page_tree($exhibit, $exhibit_page);
    $pageTree = preg_replace('/^<ul><li/', "<ul><li>$link</li><li", $pageTree, 1);
    echo $pageTree;
    ?>
</nav>

<div id="exhibit-blocks">
<?php exhibit_builder_render_exhibit_page(); ?>
</div>

<?php echo foot(); ?>
