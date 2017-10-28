<?php

// This file adds a field for crdate to the "Metadata" tab on pages.
// For blogging it's kinda interesting to be able to edit this ;)

if(!defined("TYPO3_MODE")) {
    die("Access denied.");
}

$newColumns = [
    "crdate" => [
        "exclude" => true,
        "label" => "Created on",
        "config" => [
            "type" => "input",
            "eval" => "datetime",
            "renderType" => "inputDateTime",
            "default" => 0
        ],
    ],
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns("pages", $newColumns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes("pages", "crdate", "", "before:abstract");