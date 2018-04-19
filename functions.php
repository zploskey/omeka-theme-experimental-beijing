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
