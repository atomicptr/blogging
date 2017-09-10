<?php

namespace Atomicptr\Blogging\Domain\Repository;

use TYPO3\CMS\Form\Mvc\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class PostRepository extends Repository {

    protected $constraints = [];

    protected $fullSettings;
    protected $settings;

    public function initializeObject() {
        $this->fullSettings = $this->objectManager->get(ConfigurationManagerInterface::class)
            ->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $this->settings = $this->fullSettings["plugin."]["tx_blogging."]["settings."];

        $querySettings = $this->objectManager->get(Typo3QuerySettings::class);

        $querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($querySettings);

        $query = $this->createQuery();

        $this->constraints[] = $query->equals("pid", $this->settings["blogPostStorageUid"]);

        $this->defaultOrderings = [
            "crdate" => QueryInterface::ORDER_DESCENDING,
        ];
    }

    public function findAll() {
        $query = $this->createQuery();
        $query->matching($query->logicalAnd($this->constraints));
        return $query->execute();
    }

    public function findByUid($uid) {
        $query = $this->createQuery();
        $query->matching($query->logicalAnd($this->constraints, $query->equals("uid", $uid)));
        return $query->execute();
    }
}