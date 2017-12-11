<?php
defined("TYPO3_MODE") || die("Access denied.");

call_user_func(
    function($extKey) {
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            "Atomicptr.Blogging",
            "PostListPlugin",
            "LLL:EXT:blogging/Resources/Private/Language/locallang_be.xlf:tx_blogging_plugin_postlist",
            "EXT:blogging/ext_icon.png"
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            "Atomicptr.Blogging",
            "CategoryPostListPlugin",
            "LLL:EXT:blogging/Resources/Private/Language/locallang_be.xlf:tx_blogging_plugin_categorypostlist",
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
