<!DOCTYPE html>
<html lang="<?php echo get_html_lang(); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php if ($description = option('description')): ?>
    <meta name="description" content="<?php echo $description; ?>"/>
    <?php endif;?>

    <?php
    if (isset($title)) {
        $titleParts[] = __(strip_formatting($title));
    }
    $titleParts[] = __(option('site_title'));
    ?>
    <title><?php echo implode(' &middot; ', $titleParts); ?></title>

    <?php echo auto_discovery_link_tags(); ?>

    <!-- Plugin Stuff -->
    <?php fire_plugin_hook('public_head', array('view' => $this)); ?>

    <!-- Stylesheets -->
    <?php
    queue_css_file(array('iconfonts', 'style'));
    echo head_css();
    ?>

    <!-- JavaScripts -->
    <?php
    queue_js_file(array('globals', 'toggle'));
    echo head_js();
    ?>
</head>

<?php echo body_tag(array('id' => @$bodyid, 'class' => @$bodyclass)); ?>
    <a href="#content" id="skipnav"><?php echo __('Skip to main content'); ?></a>
    <input type="checkbox" id="nav-trigger" class="nav-trigger" />
    <nav id="top-nav" role="navigation">
        <?php echo public_nav_main(); ?>
    </nav>

    <div id="wrap">
        <?php fire_plugin_hook('public_body', array('view' => $this)); ?>
        <header role="banner">
            <?php fire_plugin_hook('public_header', array('view' => $this)); ?>
            <?php echo theme_header_image(); ?>
            <div id="site-title">
                <?php
                if ($logo = theme_logo()) {
                    echo link_to_home_page($logo);
                } else {
                    echo link_to_home_page(__(option('site_title')));
                }
                ?>
                <br>
                <div id="site-subtitle">
                    <?php echo __(get_theme_option('site_subtitle')); ?>
                </div>
            </div>

            <div id="top-buttons">
                <div id="search-container" role="search">
                    <?php if (get_theme_option('use_advanced_search') === null
                        || get_theme_option('use_advanced_search')) : ?>
                    <?php echo search_form(array('show_advanced' => true)); ?>
                    <?php else: ?>
                    <?php echo search_form(array('submit_value' => '')); ?>
                    <?php endif; ?>
                </div>

                <div class="lang-select">
                    <a href="<?php echo current_url(array('lang' => str_replace('-', '_', __('zh-CN')))); ?>">
                    <?php echo __('中文'); ?>
                    </a>
                </div>

                <label for="nav-trigger"><span id="menu-label"><?php echo __('Menu');?></span> &#9776;</label>
            </div>
        </header>

        <article id="content" role="main" tabindex="-1">

            <?php fire_plugin_hook('plugin_content_top', array('view' => $this)); ?>
