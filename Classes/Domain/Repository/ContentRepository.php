<?php

namespace Atomicptr\Blogging\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;

class ContentRepository extends Repository {

    public function initializeObject() {
        $querySettings = $this->objectManager->get(Typo3QuerySettings::class);

        $querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($querySettings);
    }


    public function findByPid($pid) {
        $query = $this->createQuery();
        $query->matching($query->equals("pid", $pid));
        return $query->execute();
    }
}