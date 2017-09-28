<?php

namespace Atomicptr\Blogging\ViewHelpers;

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

class MetaDataViewHelper extends AbstractViewHelper {

    public function initializeArguments() {
        $this->registerArgument("post", "Atomicptr\Blogging\Domain\Model\Post", "The current post", true);
    }

    public function render() {
        $post = $this->arguments["post"];

        debug($post);

        $this->addTitleMetaTags($post->getTitle());
        $this->addDescriptionMetaTags($post->getSummary());
        //$this->addImageMetaTags(...); TODO: determine first image in post
        $this->addTypeMetaTags("article");

        if($post->getCategories()) {
            $categories = $post->getCategories()->toArray();

            $keywords = join(",", array_map(function($category) {
                return $category->getTitle();
            }, $categories));

            $this->addKeywordsMetaTags($keywords, "article");
        }
    }

    protected function addTitleMetaTags($title) {
        $this->addMetaTag("og:title", $title, true);
        $this->addMetaTag("twitter:title", $title);
    }

    protected function addDescriptionMetaTags($desc) {
        $this->addMetaTag("description", $desc);
        $this->addMetaTag("og:description", $desc, true);
        $this->addMetaTag("twitter:description", $desc);
    }

    protected function addImageMetaTags($imageUrl) {
        $this->addMetaTag("og:image", $imageUrl);
    }

    protected function addTypeMetaTags($type) {
        $this->addMetaTag("og:type", $type, true);
    }

    protected function addKeywordsMetaTags($keywords, $type=null) {
        $this->addMetaTag("keywords", $keywords);

        if($type) {
            $this->addMetaTag("$type:tag", $keywords, true);
        }
    }

    protected function addMetaTag($key, $value, $isProperty=false) {
        $keyTag = $isProperty ? "property" : "name";

        $htmlValue = htmlspecialchars($value);

        $GLOBALS["TSFE"]->additionalHeaderData[] = "<meta $keyTag='$key' content='$htmlValue' />";
    }
}