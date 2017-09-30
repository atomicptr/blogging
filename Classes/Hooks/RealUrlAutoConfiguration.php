<?php

namespace Atomicptr\Blogging\Hooks;

class RealUrlAutoConfiguration {

    public function addAutoConf($params) {
        return array_merge_recursive($params["config"], [
            "init" => [
                "enableCHashCache" => true,
                "enableUrlDecodeCache" => true,
                "enableUrlEncodeHash" => true
            ],
            "fileName" => [
                "index" => [
                    "rss.xml" => [
                        "keyValues" => [
                            "type" => 1337,
                        ]
                    ]
                ]
            ],
            "postVarSets" => [
                "_DEFAULT" => [
                    "cat" => [
                        [
                            "GETvar" => "tx_blogging_categorypostlistplugin[action]",
                            "noMatch" => "bypass"
                        ],
                        [
                            "GETvar" => "tx_blogging_categorypostlistplugin[controller]",
                            "noMatch" => "bypass"
                        ],
                        [
                            "GETvar" => "tx_blogging_categorypostlistplugin[categoryUid]",
                            "lookUpTable" => [
                                "table" => "sys_category",
                                "addWhereClause" => " AND NOT deleted",
                                "enable404forInvalidAlias" => true,
                                "id_field" => "uid",
                                "alias_field" => "title",
                                "useUniqueCache" => true,
                                "useUniqueCache_conf" => [
                                    "strtolower" => true,
                                    "spaceCharacter" => "-",
                                ],
                            ],
                        ],
                    ],
                ]
            ]
        ]);
    }
}
