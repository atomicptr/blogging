<?php
defined("TYPO3_MODE") or die();

call_user_func(function($extKey) {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        "Atomicptr.Blogging",
        "PostListPlugin",
        ["Blogging" => "list"],
        []
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        "Atomicptr.Blogging",
        "CategoryPostListPlugin",
        ["Blogging" => "listPostByCategory"],
        []
    );
}, $_EXTKEY);
