<?php

namespace Atomicptr\Blogging\ViewHelpers;

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

use Atomicptr\Blogging\Domain\Repository\PostRepository;

class CategoryViewHelper extends AbstractViewHelper {

    public function initializeArguments() {
        $this->registerArgument("pageUid", "int", "Page Uid", true);
        $this->registerArgument("asList", "bool", "Category title list", false);
    }

    public function render() {
        $categories = $this->getCategoriesByPageUid($this->arguments["pageUid"]);

        if($this->arguments["asList"]) {
            return implode(",", array_map(function($cat) {return $cat->getTitle();}, $categories));
        }

        return $categories;
    }

    protected function getCategoriesByPageUid($uid) {
        $objectManager = GeneralUtility::makeInstance("TYPO3\\CMS\\Extbase\\Object\\ObjectManager");

        $postRepository = $objectManager->get(PostRepository::class);

        $post = $postRepository->findByUid($uid);

        return $post->getCategories()->toArray();
    }
}