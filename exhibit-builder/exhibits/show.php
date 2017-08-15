<?php
$title = metadata('exhibits', 'title');
echo head(array(
    'title' => metadata('exhibit_page', 'title') . ' &middot; ' . $title,
    'bodyclass' => 'exhibits show'));
    $exhibitNavOption = get_theme_option('exhibits_nav');
?>

<h1><?php echo $title; ?></h1>

<?php if ($exhibitNavOption == 'full'): ?>
<nav id="exhibit-pages" class="full">
    <?php echo exhibit_builder_link_to_exhibit($exhibit); ?>
    <?php echo exhibit_builder_page_nav(); ?>
</nav>
<?php endif; ?>

<?php if ($exhibitNavOption == 'side'): ?>
<nav id="exhibit-pages" class="side">
    <?php
    $link = exhibit_builder_link_to_exhibit($exhibit);
    $pageTree = exhibit_builder_page_tree($exhibit, $exhibit_page); 
    $pageTree = preg_replace('/^<ul><li/', "<ul><li>$link</li><li", $pageTree, 1);
    echo $pageTree;
    ?>
</nav>
<?php endif; ?>

<?php if (count(exhibit_builder_child_pages()) > 0 && $exhibitNavOption == 'full'): ?>
<nav id="exhibit-child-pages" class="secondary-nav">
    <?php echo exhibit_builder_child_page_nav(); ?>
</nav>
<?php endif; ?>

<div id="exhibit-blocks">
    <?php exhibit_builder_render_exhibit_page(); ?>
</div>

<?php echo foot(); ?>
