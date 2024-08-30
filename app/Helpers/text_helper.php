<?php

function truncate($text, $length = 100, $suffix = '...')
{
    if (strlen($text) > $length) {
        $text = substr($text, 0, $length) . $suffix;
    }
    return $text;
}
