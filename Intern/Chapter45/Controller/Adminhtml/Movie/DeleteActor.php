<?php

namespace Intern\Chapter45\Controller\Adminhtml\Movie;

use Magento\Backend\App\Action;
use Intern\Chapter45\Model\ResourceModel\MagenestActor\CollectionFactory;
use Intern\Chapter45\Model\MagenestActorFactory;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Backend\Model\View\Result\RedirectFactory;

class DeleteActor extends Action
{
    private $actorFactory;
    private $filter;
    private $collectionFactory;
    private $resultRedirect;

    public function __construct(
        Action\Context $context,
        MagenestActorFactory $actorFactory,
        Filter $filter,
        CollectionFactory $collectionFactory,
        RedirectFactory $redirectFactory
    )
    {
        parent::__construct($context);
        $this->actorFactory = $actorFactory;
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->resultRedirect = $redirectFactory;
    }

    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $total = 0;
        $err = 0;
        foreach ($collection->getItems() as $item) {
            $deletePost = $this->actorFactory->create()->load($item->getData('actor_id'));
            try {
                $deletePost->delete();
                $total++;
            } catch (LocalizedException $exception) {
                $err++;
            }
        }

        if ($total) {
            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) have been deleted.', $total)
            );
        }

        if ($err) {
            $this->messageManager->addErrorMessage(
                __(
                    'A total of %1 record(s) haven\'t been deleted. Please see server logs for more details.',
                    $err
                )
            );
        }
        return $this->resultRedirect->create()->setPath('datamovie/movie/actor');
    }
}

