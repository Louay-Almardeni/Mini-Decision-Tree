<?php

use function knowledgeValues\test\Core\F\val;

$app->get('/builder', function () use ($app) {
    echo $app->blade->render('builder', ['error' => null, 'xml' => null]);
});


$app->post('/builder', function () use ($app) {

    $params = $app->request()->params();

    $xmlString = createXml($params);

    try {
        $file_name = "XML_files/" . val('file_name', $params) . ".XML";
        $file = fopen($file_name, 'w');
        fwrite($file, $xmlString);
        fclose($file);
    } catch (\Exception $e) {
        echo $app->blade->render('builder', ['error' => "Cannot Create File!", 'xml' => $xmlString]);
        return;
    }

    echo $app->blade->render('builder', ['error' => null, 'xml' => $xmlString]);

});

function createXml($params)
{
    $dom = new DomDocument('1.0', 'utf-8');
    $dom->xmlStandalone = true;

    $root = $dom->createElement('node');
    $root->setAttribute('name', val('file_name', $params));

    $mapping = $dom->createElement('mappinglist');
    $children = $dom->createElement('childrennodes');

    $map = $dom->createElement('alternative');
    $map->setAttribute('name', val('map_name', $params));
    $map->setAttribute('mapsTo', val('map_to', $params));
    $mapping->appendChild($map);

    $child = $dom->createElement('node');
    $child->setAttribute('name', val('map_to', $params));

    $alternatives = array_filter(array_keys($params), function ($k) {
        return substr($k, 0, strpos($k, '_')) == 'alternative';
    });

    foreach ($alternatives as $a) {
        $alt = $dom->createElement('alternative');
        $alt->setAttribute('name', val($a, $params));
        $child->appendChild($alt);
    }

    $children->appendChild($child);

    $root->appendChild($mapping);
    $root->appendChild($children);

    $dom->appendChild($root);
    $dom->formatOutput = true;
    $xmlString = $dom->saveXML();

    return $xmlString;
}


