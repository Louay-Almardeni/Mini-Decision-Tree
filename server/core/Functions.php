<?php namespace knowledgeValues\test\Core\F;

function is_assoc($arr)
{
    if (!is_array($arr)) {
        return null;
    };
    return array_keys($arr) !== range(0, count($arr) - 1);
}

function val($field, $objarray)
{
    return is_null($field) ? null : @(is_array($objarray) ? $objarray[$field] : $objarray->$field);
}

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

function array2xml(array $array)
{
    $doc = create_doc();
    parse($array, $doc, 'root');
    return docxml($doc);
}

function parse(array $array, $parent, $parent_key)
{
    if (!is_assoc($array)) {
        foreach ($array as $key => $value) {
            $child = create_child($parent, $parent_key);
            parse($value, $child, $key);
        }
    } else {
        foreach ($array as $key => $value) {
            if (!is_assoc($value)) {
                parse($value, $parent, $key);
            } else {
                $child = create_child($parent, $key);
                if (is_array($value)) {
                    parse($value, $child, $key);
                } elseif ($value) {
                    create_text($child, $value);
                } else {
                    //do nothing
                }
            }
        }
    }
}

//function is_non_assoc($arr)
//{
//    return is_array($arr) && !(array_keys($arr) !== range(0, count($arr) - 1));
//}

function create_doc()
{
    $doc = new \DOMDocument('1.0', 'utf-8');
    $doc->xmlStandalone = true;
    $doc->formatOutput = true;
    return $doc;
}

function docxml($doc)
{
    $doc->normalizeDocument();
    $xml = $doc->saveXML();
    return $xml;
}

function create_child($parent, $name)
{
    $elm = doc($parent)->createElement($name);
    $parent->appendChild($elm);
    return $elm;
}

function create_text($parent, $value)
{
    $elm = doc($parent)->createTextNode($value);
    $parent->appendChild($elm);
    return $elm;
}

function doc($elm)
{
    return $elm->ownerDocument ? $elm->ownerDocument : $elm;
}
