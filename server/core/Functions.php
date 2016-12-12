<?php namespace knowledgeValues\test\Core\F;

/**
 * @param array
 *
 * @return true if associative / false if not
 */
function is_assoc($arr)
{
    if (!is_array($arr)) {
        return null;
    };
    return array_keys($arr) !== range(0, count($arr) - 1);
}

/**
 * @param string $field
 * @param \stdClass|array|object $objarray
 *
 * @return true if exist / null if not
 */
function val($field, $objarray)
{
    return is_null($field) ? null : @(is_array($objarray) ? $objarray[$field] : $objarray->$field);
}

/**
 * @param $path
 * @param \stdClass|array|object $value
 *
 * @return true if / or null if not
 */
function nav($path, $value)
{
    if (empty($value)) {
        return $value;
    }

    $segments = array_map(function ($segment) {
        return trim($segment);
    }, explode('->', $path));

    foreach ($segments as $segment) {
        if (is_array($value)) {
            $value = array_key_exists($segment, $value) ? $value[$segment] : null;
        } else if (is_object($value)) {
            $value = isset($value->$segment) ? $value->$segment : null;
        } else {
            return null;
        }
    }
    return $value;
}