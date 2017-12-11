<?php
defined("TYPO3_MODE") || die("Access denied.");

call_user_func(
    function($extKey) {
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            "Atomicptr.Blogging",
            "PostListPlugin",
            "List posts - Blogging",
            "EXT:blogging/ext_icon.png"
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            "Atomicptr.Blogging",
            "CategoryPostListPlugin",
            "List Posts by Category - Blogging",
            "EXT:blogging/ext_icon.png"
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($extKey, "Configuration/TypoScript", "Blogging");

        $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Core\Imaging\IconRegistry');
        $iconRegistry->registerIcon(
            "tx_blogging_icon",
            "TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider",
            ["source" => "EXT:blogging/ext_icon.png"]
        );
    },
    $_EXTKEY
);
