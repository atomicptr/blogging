<?php

namespace Atomicptr\Blogging\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

use \TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Content extends AbstractEntity {

    /**
    * @var string
    */
    protected $header;

    /**
    * @var string
    */
    protected $subheader;

    /**
    * @var string
    */
    protected $bodytext;

    /**
    * @var string
    */
    protected $ctype;

    /**
    * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
    */
    protected $assets;

    /**
    * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
    */
    protected $image;

    /**
    * @var \DateTime
    */
    protected $tstamp;

    public function __construct() {
        $this->assets = new ObjectStorage();
        $this->image = new ObjectStorage();
    }

    public function getBodytext() {
        return $this->bodytext;
    }

    public function getAssets() {
        return $this->assets;
    }

    public function getImage() {
        return $this->image;
    }

    public function getTstamp() {
        return $this->tstamp;
    }
}