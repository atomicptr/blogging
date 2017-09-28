<?php

namespace Atomicptr\Blogging\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

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

    /** Post categories
    * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Atomicptr\Blogging\Domain\Model\Category>
    */
    protected $categories;

    public function __construct() {
        $this->categories = new ObjectStorage();
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

    public function setCrdate(string $crdate) {
        $this->crdate = $crdate;
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

    public function getSummary() {
        // TODO: generate a summary of the post
        if(isset($this->abstract)) {
            return $this->abstract;
        }

        return $this->description;
    }
}