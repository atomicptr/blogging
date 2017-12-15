<?php

namespace Atomicptr\Blogging\ViewHelpers;

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Resource\FileReference;

use Atomicptr\Blogging\Domain\Repository\PostRepository;

class MetaDataViewHelper extends AbstractViewHelper {

    public function initializeArguments() {
        $this->registerArgument("postUid", "int+", "The current post", true);
    }

    public function render() {
        $postUid = $this->arguments["postUid"];

        $objectManager = GeneralUtility::makeInstance("TYPO3\\CMS\\Extbase\\Object\\ObjectManager");
        $postRepository = $objectManager->get(PostRepository::class);

        $post = $postRepository->findByUid($postUid);

        // no post found? Do nothing
        if(!$post) {
            return;
        }

        $content = $post->getContent();

        $this->addTitleMetaTags($post->getTitle());

        $summary = $post->getSummary(150);

        if(!empty($summary)) {
            $this->addDescriptionMetaTags($summary);
        }

        $twitterCard = "summary";

        $media = $post->getMedia();

        $image = null;

        // post has media attached? Use first
        if($media && $media->count() > 0) {
            $image = $media->current()->getOriginalResource();
        } else {
            $IMAGE_TYPE = 2;

            foreach($content as $contentElement) {

                if($contentElement->getImage()->count() > 0) {
                    $image = $contentElement->getImage()->current()->getOriginalResource();
                }

                // try to find an image from assets
                if(!isset($image)) {
                    foreach($contentElement->getAssets() as $asset) {
                        if($asset->getOriginalResource()->getType() === $IMAGE_TYPE) {
                            $image = $asset->getOriginalResource();
                            break;
                        }
                    }
                }
            }
        }

        if($image !== null) {
            $width = $image->getProperty("width");
            $height = $image->getProperty("height");

            if($width >= $height) {
                $twitterCard = "summary_large_image";
            }

            $this->addImageMetaTags($image);
        }

        $this->addMetaTag("twitter:card", $twitterCard);

        $this->addTypeMetaTags("article");

        if($post->getCategories()) {
            $categories = $post->getCategories()->toArray();

            $keywords = join(",", array_map(function($category) {
                return $category->getTitle();
            }, $categories));

            $this->addKeywordsMetaTags($keywords, "article");
        }

        $this->addMetaTag("article:published_time", $post->getCrDate()->format("c"));

        $lastEdited = $post->getTstamp();

        foreach($content as $contentElement) {
            if($contentElement->getTstamp() > $lastEdited) {
                $lastEdited = $contentElement->getTstamp();
            }
        }

        $this->addMetaTag("article:modified_time", $lastEdited->format("c"));
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

    protected function addImageMetaTags(FileReference $image) {
        $baseUrl = $this->renderingContext->getControllerContext()->getRequest()->getBaseUri();

        $publicUrl = $baseUrl.$image->getPublicUrl();

        $this->addMetaTag("og:image", $publicUrl, true);
        $this->addMetaTag("og:image:width", $image->getProperty("width"), true);
        $this->addMetaTag("og:image:height", $image->getProperty("height"), true);

        $this->addMetaTag("twitter:image", $publicUrl, true);
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

        $htmlValue = htmlspecialchars($value, ENT_QUOTES);

        $GLOBALS["TSFE"]->additionalHeaderData[] = "<meta $keyTag='$key' content='$htmlValue' />";
    }
}