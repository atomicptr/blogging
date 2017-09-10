<?php

namespace Atomicptr\Blogging\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Category extends AbstractEntity {

    /** Category title
    * @var string
    */
    protected $title;

    /**
    * @var \TYPO3\CMS\Extbase\Domain\Model\Category|null
    */
    protected $parent;

    public function getTitle() {
        return $this->title;
    }

    public function setTitle(string $title) {
        $this->title = $title;
    }
}