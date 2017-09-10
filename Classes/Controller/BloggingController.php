<?php

namespace Atomicptr\Blogging\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class BloggingController extends ActionController {

    /**
    * @var \Atomicptr\Blogging\Domain\Repository\PostRepository
    * @inject
    */
    protected $postRepository;

    /**
    * @var \Atomicptr\Blogging\Domain\Repository\CategoryRepository
    * @inject
    */
    protected $categoryRepository;

    public function listAction() {
        $posts = [];

        if($this->settings["category"]) {
            $categories = explode(",", $this->settings["category"]);
            $posts = $this->postRepository->findByCategories($categories);

        } else {
            $posts = $this->postRepository->findAll();
        }

        $this->view->assign("posts", $posts);
    }

    public function listPostByCategoryAction() {
        $categoryUid = $this->request->getArgument("categoryUid");

        $posts = $this->postRepository->findByCategoryUid($categoryUid);
        $category = $this->categoryRepository->findByUid($categoryUid);
        $this->view->assign("posts", $posts);
        $this->view->assign("category", $category);
    }
}