<?php
/**
 * 打印函数
 * @param array $data
 */
function p($data) {
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

/**
 * 将xml转换成数组
 * @param $xmlstring
 * @return array|bool|mix|mixed|stdClass|string
 */
function simplest_xml_to_array($xmlstring) {
    return json_decode(json_encode((array) simplexml_load_string($xmlstring)), true);
}

