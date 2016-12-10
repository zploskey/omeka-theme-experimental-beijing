<?php

/**
 * Filters out the navigation items that should only by on top or bottom.
 * Use on the result of public_nav_main(). Returns a navigation menu object that
 * can generally be treated like a string. Returns an empty string if there are
 * no items after filtering.
 * @param Zend_View_Helper_Navigation_Menu $menu
 * @param string $top_or_bottom Indicates 'top' or 'bottom' nav.
 * @return Zend_View_Helper_Navigation_Menu|string $newmenu The navigation menu
 **/
function filter_nav($menu, $top_or_bottom)
{
    include 'bottom_urls.php';
    $bottom_urls = array_map('url', $bottom_urls);
    $isTop = ($top_or_bottom === 'top');
    $newmenu = array();
    $hasPages = false;
    $navContainer = $menu->getContainer(); // Omeka_Navigation
    foreach ($navContainer as $page) { // $page = Omeka_Navigation_Page_Uri
        $label = $page->getUri();
        $inArray = in_array($label, $bottom_urls);
        if ( (! $isTop AND $inArray) OR ($isTop AND ! $inArray) ) {
            $newmenu[] = $page;
            $hasPages = true;
        }
    }
    if ($hasPages) {
        $newmenu = nav($newmenu);
    } else {
        $newmenu = '';
    }
    return $newmenu;
}
