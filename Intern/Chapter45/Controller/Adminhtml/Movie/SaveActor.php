<?php

namespace Intern\Chapter45\Controller\Adminhtml\Movie;

use Intern\Chapter45\Model\MagenestActorFactory;
use Magento\Backend\App\Action;

/**
 * Class Save
 * @package Intern\Chapter45\Controller\Adminhtml\Movie
 */
class SaveActor extends Action
{
    /**
     * @var MagenestActorFactory
     */
    private $actorFactory;

    /**
     * Save constructor.
     * @param Action\Context $context
     * @param MagenestActorFactory $actorFactory
     */
    public function __construct(
        Action\Context $context,
        MagenestActorFactory $actorFactory
    ) {
        parent::__construct($context);
        $this->actorFactory = $actorFactory;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $id = !empty($data['datamovie_addnewactor']['actor_id']) ? $data['datamovie_addnewactor']['actor_id'] : null;

        if ($movieDataPost = $data['datamovie_addnewactor']) {
            $newData = [
                'name' => $movieDataPost['name'],
            ];

            $post = $this->actorFactory->create();

            if ($id) {
                $post->load($id);
            }
            try {
                $post->addData($newData);
                $post->save();
                $this->messageManager->addSuccessMessage(__('You saved the actor.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__($e->getMessage()));
            }
        }

        return $this->resultRedirectFactory->create()->setPath('datamovie/movie/actor');
    }
}
