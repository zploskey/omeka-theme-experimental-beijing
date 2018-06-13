<?php

function ebj_tags()
{
    if (function_exists('locale_filtered_tags')) {
        $tag_string = implode(locale_filtered_tags('item'));
    } else {
        $tag_string = tag_string('item');
    }
    return $tag_string;
}

/**
 * Get a link to the item immediately following the current one.
 * If we're in an Exhibit gallery, make it an exhibit link.
 *
 * @param string $text
 * @param array $props
 * @return string
 */
function ebj_link_to_next_item_show($text = null, $props = array())
{
    if (!$text) {
        $text = __('Next Item');
    }
    $item = get_current_record('item');
    if ($next = $item->next()) {
        $view = get_view();
        if (isset($view->exhibit) && $view->exhibit->hasItem($next)) {
            return exhibit_builder_link_to_exhibit_item($text, $props, $next);
        }
    }
}

/**
 * Get a link to the item immediately before the current one.
 * If we're in an Exhibit gallery, make it an exhibit link.
 *
 * @param string $text
 * @param array $props
 * @return string
 */
function ebj_link_to_previous_item_show($text = null, $props = array())
{
    if (!$text) {
        $text = __('Previous Item');
    }
    $item = get_current_record('item');
    if ($previous = $item->previous()) {
        $view = get_view();
        if (isset($view->exhibit) && $view->exhibit->hasItem($previous)) {
            return exhibit_builder_link_to_exhibit_item($text, $props, $previous);
        }
    }
}

/**
 * Get the Chinese language logo image tag (theme option 'logo_cn').
 *
 * @uses get_theme_option()
 * @return string|null
 */
function ebj_theme_logo_cn()
{
    $logo = get_theme_option('logo_cn');
    if ($logo) {
        $storage = Zend_Registry::get('storage');
        $uri = $storage->getUri($storage->getPathByType($logo, 'theme_uploads'));
        return '<img src="' . $uri . '" alt="' . __(option('site_title')) . '" />';
    }
}
