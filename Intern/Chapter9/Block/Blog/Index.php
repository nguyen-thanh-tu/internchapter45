<?php

namespace Intern\Chapter9\Block\Blog;

use Magento\Framework\View\Element\Template;
use Magento\Framework\UrlInterface;

class Index extends \Magento\Framework\View\Element\Template
{
    /**
     * @var UrlInterface
     *
     */
    protected $urlBuilder;

    /** @var \Intern\Chapter9\Model\ResourceModel\MagenestBlog\CollectionFactory  */
    protected $collection;

    public function __construct(
        Template\Context $context,
        \Intern\Chapter9\Model\MagenestBlogFactory $magenestBlogFactory,
        \Intern\Chapter9\Model\MagenestCategoryFactory $magenestCategoryFactory,
        \Intern\Chapter9\Model\ResourceModel\MagenestBlog\CollectionFactory $collectionFactory,
        UrlInterface $urlBuilder,
        array $data = []
    )
    {
        $this->collection = $collectionFactory;
        $this->magenestBlogFactory = $magenestBlogFactory;
        $this->magenestCategoryFactory = $magenestCategoryFactory;
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $data);
    }

    public function getDataBlog()
    {
        $data2 = $this->collection->create()->getData();
        $blog = $this->magenestBlogFactory->create()->getCollection()->getData();
        foreach($blog as $key => $value)
        {
//            $value['url'] = $this->urlBuilder->getUrl(
//                'blog/view/index',
//                ['id' => $value['id']]
//            );
            $value['url'] = $this->urlBuilder->getUrl($value['url_rewrite']);
            $blog[$key] = $value;
        }
        $data = [
            'category' => $this->magenestCategoryFactory->create()->getCollection()->getData(),
            'blog' => $blog,
            ];
        return $data;
    }
}
