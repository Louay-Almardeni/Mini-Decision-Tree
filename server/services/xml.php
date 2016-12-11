<?php namespace knowledgeValues\services\xml;

use function knowledgeValues\test\Core\F\val;
use function knowledgeValues\test\Core\F\nav;
use function knowledgeValues\test\Core\F\is_assoc;

function getFileNames()
{
    return array_map(function ($fn) {
        return substr($fn, strpos($fn, '/') + 1);
    }, glob(XML_FILES_FOLDER_NAME . '/*.XML'));
}

function aggregation($array)
{
    $res = [];

    foreach (val('alternatives', $array) as $alt) {
        if ($mapsTo = val('mapsTo', $alt)) {
            $sub = nav('children_nodes -> ' . $mapsTo, $array);
            $alt['sub'] = is_assoc($sub)
                ? val('alternatives', $sub)
                : $sub;
        }
        $res[] = $alt;
    }

    return $res;
}

function getTree($file_name)
{
    $xml = simplexml_load_file('XML_files/' . $file_name);
    $data = json_decode(json_encode($xml), TRUE);

    return [
        'alternatives' => getAlternatives(val('mappinglist', $data)),
        'children_nodes' => getChildrenNodes($data)
    ];
}

function getAlternatives($array)
{
    return array_map(function ($a) {
        return mapAlternative(val('@attributes', $a));
    }, val('alternative', $array));
}

function mapAlternative($data)
{
    return [
        'name' => val('name', $data),
        'mapsTo' => val('mapsTo', $data)
    ];
}

function getChildrenNodes($array)
{
    if (!$node = nav('childrennodes -> node', $array)) {
        return null;
    }

    $keys = array_map(function ($n) {
        return nav('@attributes -> name', $n);
    }, $node);

    $values = array_map(function ($n) {
        return val('alternative', $n)
            ? getAlternatives($n)
            : getTree(nav('xmlFile -> @attributes -> name', $n));
    }, $node);

    return array_combine($keys, $values);
}

