<?php

namespace Intern\Chapter45\Controller\Adminhtml\Movie;

use Intern\Chapter45\Model\MagenestMovieFactory;
use Magento\Backend\App\Action;

/**
 * Class Save
 * @package ViMagento\HelloWorld\Controller\Adminhtml\Post
 */
class Save extends Action
{
    /**
     * @var MagenestMovieFactory
     */
    private $movieFactory;

    /**
     * Save constructor.
     * @param Action\Context $context
     * @param MagenestMovieFactory $movieFactory
     */
    public function __construct(
        Action\Context $context,
        MagenestMovieFactory $movieFactory
    ) {
        parent::__construct($context);
        $this->movieFactory = $movieFactory;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $id = !empty($data['post_id']) ? $data['post_id'] : null;

        if ($movieDataPost = $data['magenest_movie']) {
            $newData = [
                'name' => $movieDataPost['name'],
                'description' => $movieDataPost['description'],
                'rating' => $movieDataPost['rating'],
                'director_id' => $movieDataPost['director_id'],
            ];

            $post = $this->movieFactory->create();

            if ($id) {
                $post->load($id);
            }
            try {
                $post->addData($newData);
                $this->_eventManager->dispatch("intern_chapter45_save_movie", ['movieData' => $post]);
                $post->save();
                $this->messageManager->addSuccessMessage(__('You saved the movie.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__($e->getMessage()));
            }
        }

        return $this->resultRedirectFactory->create()->setPath('datamovie/movie/index');
    }
}
