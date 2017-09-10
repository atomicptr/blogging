<?php

namespace Atomicptr\Blogging\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class BloggingController extends ActionController {

    /**
    * @var \Atomicptr\Blogging\Domain\Repository\PostRepository
    * @inject
    */
    protected $postRepository;

    public function listAction() {
        $posts = $this->postRepository->findAll();
        $this->view->assign("posts", $posts);
    }

    public function listPostsWithCategories() {
    }
}