<?php

namespace Atomicptr\Blogging\UserFunc;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;

use Atomicptr\Blogging\Domain\Repository\PostRepository;

class RssUserFunc {

    /**
     * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
     */
    public $cObj;

    public function render($content, $conf) {
        $objectManager = GeneralUtility::makeInstance("TYPO3\\CMS\\Extbase\\Object\\ObjectManager");
        $postRepository = $objectManager->get(PostRepository::class);

        $fullSettings = $objectManager->get(ConfigurationManagerInterface::class)
            ->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
        $settings = $fullSettings["plugin."]["tx_blogging."]["rss."];

        $posts = null;

        $categoryId = $this->cObj->stdWrapValue("category", $conf, null);

        if($categoryId) {
            $categories = GeneralUtility::trimExplode(",", $categoryId, true);
            $posts = $postRepository->findByCategories($categories);
        } else {
            $posts = $postRepository->findAll();
        }

        $items = "";

        foreach($posts as $post) {
            $items .= $this->makeItem($post, $settings["descriptionMaxLength"]);
        }

        $channelTitle = $settings["channelTitle"];
        $channelDescription = $settings["channelDescription"];

        $channelLink = $fullSettings["config."]["baseURL"];

        $rssUrl = $GLOBALS["TSFE"]->cObj->typoLink_URL([
            "parameter" => "t3://page?type=1337",
            "forceAbsoluteUrl" => true,
        ]);

        $rssUrl = str_replace("&", "&amp;", $rssUrl);

        $rss = "<?xml version='1.0' encoding='utf-8' ?>
            <rss version='2.0' xmlns:atom='http://www.w3.org/2005/Atom'>
                <channel>
                    <title>$channelTitle</title>
                    <description>$channelDescription</description>
                    <link>$channelLink</link>
                    <atom:link href=\"$rssUrl\" rel='self' type='application/rss+xml' />

                    $items
                </channel>
            </rss>";

        return $rss;
    }

    protected function makeItem($post, $descriptionMaxLength) {
        $link = $GLOBALS["TSFE"]->cObj->typoLink_URL([
            "parameter" => $post->getUid(),
            "forceAbsoluteUrl" => true,
        ]);

        $title = $post->getTitle();
        $description = $post->getSummary($descriptionMaxLength);

        if(!empty($description)) {
            $description = "<description>$description</description>";
        }

        $pubDate = $post->getCrdate()->format("D, d M Y H:i:s O");

        return "
            <item>
                <title>$title</title>
                $description

                <link>$link</link>
                <guid>$link</guid>
                <pubDate>$pubDate</pubDate>
            </item>";
    }
}