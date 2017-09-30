<?php

namespace Atomicptr\Blogging\ViewHelpers;

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

class PostSummaryViewHelper extends AbstractViewHelper {

    public function initializeArguments() {
        $this->registerArgument("post", "Atomicptr\Blogging\Domain\Model\Post", "The current post", true);
        $this->registerArgument("maxLength", "int+", "Summary max length", false, null);
    }

    public function render() {
        $post = $this->arguments["post"];
        $maxLength = $this->arguments["maxLength"];

        return $post->getSummary($maxLength);
    }
}