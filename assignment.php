
<?php

$json = '{"0":
            [{"id": 10,
                "title": "House",
                "level": 0,
                "children": [],
                "parent_id": null
                }
            ],
        "1":
            [{"id": 12,
                "title": "Red Roof",
                "level": 1,
                "children": [],
                "parent_id": 10},
            {"id": 18,
                "title": "Blue Roof",
                "level": 1,
                "children": [],
                "parent_id": 10},
            {"id": 13,
                "title": "Wall",
                "level": 1,
                "children": [],
                "parent_id": 10}
            ],
        "2":
            [{"id": 17,
                "title": "Blue Window",
                "level": 2,
                "children": [],
                "parent_id": 12},
            {"id": 16,
                "title": "Door",
                "level": 2,
                "children": [],
                "parent_id": 13},
            {"id": 15,
                "title": "Red Window",
                "level": 2,
                "children": [],
                "parent_id": 12
                }
            ]
        }';


    function getSortedArray($arryList, &$arrySingleLevel) 
    {
        foreach($arryList as $array) 
        {
            $array = (array)$array;
            if(array_key_exists('id', $array)) 
            {
                if($array['parent_id'] == null) 
                {
                    $arrySingleLevel[$array['id']] = $array;
                } 
                else 
                {
                    //$arrySingleLevel[$array['parent_id']]['children'][$array['id']] = $array;
                    addToNode($arrySingleLevel, $array);
                }
            } else 
            {
                getSortedArray($array, $arrySingleLevel);
            }
        }
    }

    /**
     * Add array into structure with some child id.
     */
    function addToNode(& $arrySingleLevel, $add) 
    {
        foreach( $arrySingleLevel as & $data ) 
        {
            if( isset($data['id']) ) 
            {
                if( $data['id'] == $add['parent_id'] ) 
                {
                    $data['children'][ $add['id'] ] = $add;
                    break;
                }
            }

            if(isset($data['children']) ) 
            {
                addToNode($data['children'], $add);
            }
        }
    }

    //Here convert json to array
    $arr = json_decode($json);

    $arrySingleLevel = array();
    $arryList = (array)$arr;
    getSortedArray($arryList, $arrySingleLevel);   

    $result =  json_encode($arrySingleLevel, JSON_PRETTY_PRINT);

    echo '<pre>';
    print_r($result);
    echo '<pre>';exit;

?> 