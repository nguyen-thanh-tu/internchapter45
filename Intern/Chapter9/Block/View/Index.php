<?php

namespace Intern\Chapter9\Block\View;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;

class Index extends \Magento\Framework\View\Element\Template
{
    /**
     * Request instance
     *
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;

    protected $userFactory;

    public function __construct(
        Template\Context $context,
        \Intern\Chapter9\Model\MagenestBlogFactory $magenestBlogFactory,
        \Intern\Chapter9\Model\MagenestCategoryFactory $magenestCategoryFactory,
        \Intern\Chapter9\Model\ResourceModel\MagenestBlog\CollectionFactory $collectionFactory,
        \Magento\User\Model\UserFactory $userFactory,
        RequestInterface $request,
        array $data = []
    )
    {
        $this->collection = $collectionFactory;
        $this->magenestBlogFactory = $magenestBlogFactory;
        $this->magenestCategoryFactory = $magenestCategoryFactory;
        $this->userFactory = $userFactory;
        $this->request = $request;
        parent::__construct($context, $data);
    }

    public function getInfoBlog()
    {
        $movieId = $this->request->getParam("id");
        $getBlog = $this->magenestBlogFactory->create()->getCollection()->getItemById($movieId);
        if($getBlog != null)
        {
            $data = $getBlog->getData();
            $userData = $this->userFactory->create()->load($data['author_id'])->getData();
            $data['actor_name'] = $userData['firstname'].' '.$userData['lastname'];
            return $data;
        }
        return null;
    }

    public function getUserData($userId)
    {
        return $this->userFactory->create()->load($userId)->getData();
    }
}
