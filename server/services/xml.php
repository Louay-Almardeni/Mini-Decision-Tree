<?php namespace knowledgeValues\services\xml;

use function knowledgeValues\test\Core\F\val;
use function knowledgeValues\test\Core\F\nav;
use function knowledgeValues\test\Core\F\is_assoc;

//Make a list of all XML files in the XML_files folder
function getFileNames()
{
    return array_map(function ($fn) {
        return substr($fn, strpos($fn, '/') + 1);
    }, glob(XML_FILES_FOLDER_NAME . '/*.XML'));
}

//Read XML file and return a structured array
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
    $alternatives = val('alternative', $array);
    if (is_assoc($alternatives)) {
        $alternatives = [$alternatives];
    }

    return array_map(function ($a) {
        return mapAlternative(val('@attributes', $a));
    }, $alternatives);
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

    if (is_assoc($node)) {
        $node = [$node];
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


//Map array for rout to ease creating sections
function mapping($array)
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
