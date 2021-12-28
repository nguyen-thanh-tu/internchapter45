<?php
namespace Intern\Chapter45\Block;

use Magento\Framework\View\Element\Template;

class Index extends \Magento\Framework\View\Element\Template
{
    protected $collection;
    public function __construct(
        Template\Context $context,
        \Intern\Chapter45\Model\MagenestActorFactory $magenestActorFactory,
        \Intern\Chapter45\Model\MagenestMovieFactory $magenestMovieFactory,
        \Intern\Chapter45\Model\MagenestDirectorFactory $magenestDirectorFactory,
        \Intern\Chapter45\Model\ResourceModel\MagenestMovie\CollectionFactory $collectionFactory,

        array $data = []
    )
    {
        $this->collection = $collectionFactory;
        $this->magenestActorFactory = $magenestActorFactory;
        $this->magenestMovieFactory = $magenestMovieFactory;
        $this->magenestDirectorFactory = $magenestDirectorFactory;
        parent::__construct($context, $data);
    }

    public function getDataMovie()
    {
        $data2 = $this->collection->create()->getData();
        $data = $this->magenestMovieFactory->create()->getCollection()->getData();
        return $data;
    }
}
