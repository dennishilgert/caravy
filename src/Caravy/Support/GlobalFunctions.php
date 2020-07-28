<?php

/**
 * Converts critial symbols for XSS-injections 
 * into html entities.
 * 
 * @var string
 */
function escape(string $input)
{
    return htmlentities($input, ENT_QUOTES, "UTF-8");
}