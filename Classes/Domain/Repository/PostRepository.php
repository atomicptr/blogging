<?php

namespace Atomicptr\Blogging\Domain\Repository;

use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class PostRepository extends Repository {

    protected $fullSettings;
    protected $settings;

    public function initializeObject() {
        $this->fullSettings = $this->objectManager->get(ConfigurationManagerInterface::class)
            ->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $this->settings = $this->fullSettings["plugin."]["tx_blogging."]["settings."];

        $querySettings = $this->objectManager->get(Typo3QuerySettings::class);

        $querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($querySettings);

        $this->defaultOrderings = [
            "crdate" => QueryInterface::ORDER_DESCENDING,
        ];
    }

    protected function defaultConstraints($query) {
        return $query->logicalAnd(
            $query->equals("pid", $this->settings["blogPostStorageUid"]),
            $query->equals("nav_hide", 0) // don't show posts hidden from navigation
        );
    }

    public function findAll() {
        $query = $this->createQuery();
        $query->matching($this->defaultConstraints($query));
        return $query->execute();
    }

    public function findByUid($uid) {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                $query->equals("pid", $this->settings["blogPostStorageUid"]),
                $query->equals("uid", $uid)));
        return $query->execute()[0];
    }

    public function findByCategories($categories) {
        $query = $this->createQuery();

        $categoryConstraints = [];

        foreach($categories as $category) {
            $categoryConstraints[] = $query->contains("categories", $category);
        }

        $query->matching(
            $query->logicalAnd(
                $this->defaultConstraints($query),
                $query->logicalOr($categoryConstraints)));

        return $query->execute();
    }

    public function findByCategoryUid($categoryUid) {
        return $this->findByCategories([$categoryUid]);
    }
}