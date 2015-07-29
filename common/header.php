<!DOCTYPE html>
<html lang="<?php echo get_html_lang(); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php if ($description = option('description')): ?>
    <meta name="description" content="<?php echo $description; ?>"/>
    <?php endif;?>

    <title>
    <?php
    echo option('site_title');
    echo isset($title) ? ' | ' . strip_formatting($title) : '';
    ?>
    </title>

    <?php echo auto_discovery_link_tags(); ?>

    <!-- Plugin Stuff -->
    <?php fire_plugin_hook('public_head', array('view' => $this)); ?>

    <!-- Stylesheets -->
    <?php
    queue_css_url('http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic');
    queue_css_file('foundation');
    queue_css_file('app');
    echo head_css();
    ?>

    <!-- JavaScripts -->
    <?php
    queue_js_file('app');
    queue_js_file('foundation/foundation');
    queue_js_file('foundation/foundation.orbit');
    queue_js_file('vendor/jquery');
    queue_js_file('vendor/custom.modernizr');
    queue_js_file('foundation/foundation.forms');
    echo head_js();
    ?>
</head>

<?php echo body_tag(array('id' => @$bodyid, 'class' => @$bodyclass)); ?>
    <a href="#content" id="skipnav"><?php echo __('Skip to main content'); ?></a>
    <?php fire_plugin_hook('public_body', array('view' => $this)); ?>
    <div id="wrap">
        <header role="banner">
            <?php fire_plugin_hook('public_header', array('view' => $this)); ?>
            <div id="site-title">
                <?php echo link_to_home_page(theme_logo()); ?>
            </div>

            <div id="search-container" role="search">
                <?php if (get_theme_option('use_advanced_search') === null
                       || get_theme_option('use_advanced_search')) : ?>
                <?php echo search_form(array('show_advanced' => true)); ?>
                <?php else: ?>
                <?php echo search_form(); ?>
                <?php endif; ?>
            </div>

            <nav id="top-nav" role="navigation">
                <?php echo public_nav_main(); ?>
            </nav>
        </header>

        <article id="content" role="main" tabindex="-1">

            <?php fire_plugin_hook('plugin_content_top', array('view' => $this)); ?>
