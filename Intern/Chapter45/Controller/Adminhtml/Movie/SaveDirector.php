<?php

namespace Intern\Chapter45\Controller\Adminhtml\Movie;

use Intern\Chapter45\Model\MagenestDirectorFactory;
use Magento\Backend\App\Action;

/**
 * Class Save
 * @package Intern\Chapter45\Controller\Adminhtml\Movie
 */
class SaveDirector extends Action
{
    /**
     * @var MagenestDirectorFactory
     */
    private $movieFactory;

    /**
     * Save constructor.
     * @param Action\Context $context
     * @param MagenestDirectorFactory $directorFactory
     */
    public function __construct(
        Action\Context $context,
        MagenestDirectorFactory $directorFactory
    ) {
        parent::__construct($context);
        $this->directorFactory = $directorFactory;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $id = !empty($data['datamovie_addnewdirector']['director_id']) ? $data['datamovie_addnewdirector']['director_id'] : null;

        if ($movieDataPost = $data['datamovie_addnewdirector']) {
            $newData = [
                'director_name' => $movieDataPost['director_name'],
            ];

            $post = $this->directorFactory->create();

            if ($id) {
                $post->load($id);
            }
            try {
                $post->addData($newData);
                $post->save();
                $this->messageManager->addSuccessMessage(__('You saved the director.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__($e->getMessage()));
            }
        }

        return $this->resultRedirectFactory->create()->setPath('datamovie/movie/director');
    }
}

