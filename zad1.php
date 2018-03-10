<?php
$niza = array(
    array(5, 1.15 , 15),
    array('unknown', 0.75 , 5, array(2, 'bla', 1.15) ),
    array(array('text'), 1.15 , 7)
);

function return_duplicates ($arr){
    $content = array();
    foreach($arr as $n){
        if (is_array($n)){
            foreach($n as $nn){
                if (is_array($nn)){
                    foreach($nn as $nnn){
                        array_push($content, $nnn);
                    }
                } else{
                    array_push($content, $nn);
                }
            }
        } else{
            array_push($content, $n);
        }

    }


    print_r($content);
    $no_duplicate = array_unique($content);
    echo "<br/>" ; print_r($no_duplicate);

    $duplicates = array_diff_assoc($content, $no_duplicate);
    echo "<br/>" ; print_r($duplicates);

    $duplicates = array_unique($duplicates);
    echo "<br/>" ; print_r($duplicates);

    return $duplicates;
}

