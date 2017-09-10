<?php

call_user_func(function() {
    $GLOBALS["TCA"]["tt_content"]["types"]["list"]["subtypes_addlist"]["blogging_postlistplugin"] = "pi_flexform";
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue("blogging_postlistplugin", "FILE:EXT:blogging/Configuration/FlexForms/blogging_postlistplugin.xml");

    $GLOBALS["TCA"]["tt_content"]["types"]["list"]["subtypes_excludelist"]["blogging_postlistplugin"] = "recursive,select_key,pages,categories";
    $GLOBALS["TCA"]["tt_content"]["types"]["list"]["subtypes_excludelist"]["blogging_categorypostlistplugin"] = "recursive,select_key,pages,categories";
});