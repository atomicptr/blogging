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

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        "<INCLUDE_TYPOSCRIPT: source=\"FILE:EXT:blogging/Configuration/TSconfig/pagets.typoscript\">"
    );

    if(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded("realurl")) {
        $GLOBALS["TYPO3_CONF_VARS"]["SC_OPTIONS"]["ext/realurl/class.tx_realurl_autoconfgen.php"]["extensionConfiguration"]["blogging"] =
            "Atomicptr\\Blogging\\Hooks\\RealUrlAutoConfiguration->addAutoConf";
    }
}, $_EXTKEY);
