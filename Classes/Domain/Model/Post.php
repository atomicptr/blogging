<?php

namespace Atomicptr\Blogging\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

use TYPO3\CMS\Extbase\Annotation\Inject as inject;

class Post extends AbstractEntity {

    /** The posts subtitle
    * @var string
    */
    protected $title;

    /** Post abstract, used for list view
    * @var string
    */
    protected $abstract;

    /** Post description (SEO mostly)
    * @var string
    */
    protected $description;

    /** Post creation date
    * @var \DateTime
    */
    protected $crdate;

    /** Post last changed date
    * @var \DateTime
    */
    protected $tstamp;

    /** Post categories
    * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Atomicptr\Blogging\Domain\Model\Category>
    */
    protected $categories;

    /**
    * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
    */
    protected $media;

    /**
    * @var \Atomicptr\Blogging\Domain\Repository\ContentRepository
    * @extensionScannerIgnoreLine
    * @inject
    */
    protected $contentRepository;

    public function __construct() {
        $this->categories = new ObjectStorage();
        $this->media = new ObjectStorage();
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle(string $title) {
        $this->title = $title;
    }

    public function getAbstract() {
        return $this->abstract;
    }

    public function setAbstract(string $abstract) {
        $this->abstract = $abstract;
    }

    public function getDescription() {
        return $this->descrition;
    }

    public function setDescription(string $description) {
        $this->descrition = $description;
    }

    public function getCrdate() {
        return $this->crdate;
    }

    public function setCrdate(\DateTime $crdate) {
        $this->crdate = $crdate;
    }

    public function getTstamp() {
        return $this->tstamp;
    }

    public function setTstamp(\DateTime $tstamp) {
        $this->tstamp = $tstamp;
    }

    public function getCategories() {
        return $this->categories;
    }

    public function setCategories(ObjectStorage $categories) {
        $this->categories = $categories;
    }

    public function addCategory(Category $category) {
        $this->categories->attach($category);
        return $this;
    }

    public function getMedia() {
        return $this->media;
    }

    public function getContent() {
        return $this->contentRepository->findByPid($this->uid);
    }

    public function getSummary($maxLength=null) {
        $cObjRenderer = GeneralUtility::makeInstance(ContentObjectRenderer::class);

        $str = "";

        if(isset($this->abstract)) {
            $str = $this->abstract;
        }

        if(empty($str) && isset($this->description)) {
            $str = $this->description;
        }

        // abstract nor description is set? Determine content from content elements
        if(empty($str)) {
            $contentElements = $this->getContent();

            $str = join("", array_map(function($e) {
                return $e->getBodytext();
            }, $contentElements->toArray()));
        }

        if(isset($maxLength)) {
            $append = "...";
            $respectWordBoundaries = true;

            $str = $cObjRenderer->cropHTML($str, "$maxLength|$append|$respectWordBoundaries");
        }

        return trim(strip_tags($str));
    }
}