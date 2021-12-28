<?php
namespace Intern\Chapter45\Block;

use Intern\Chapter45\Model\MagenestActorFactory;
use Intern\Chapter45\Model\MagenestDirectorFactory;
use Intern\Chapter45\Model\MagenestMovieFactory;
use Magento\Framework\View\Element\Template;
use Magento\Framework\App\RequestInterface;
use Intern\Chapter45\Model\ResourceModel\MagenestMovie;
use Intern\Chapter45\Model\ResourceModel\MagenestMovie\Collection;


class Infomovie extends \Magento\Framework\View\Element\Template
{
    /**
     * Request instance
     *
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;

    protected $movieResourceModel;
    private $magenestMovieFactory;
    private $magenestDirectorFactory;

    /**
     * @param Template\Context $context
     * @param MagenestActorFactory $magenestActorFactory
     * @param MagenestMovieFactory $magenestMovieFactory
     * @param MagenestDirectorFactory $magenestDirectorFactory
     * @param RequestInterface $request
     * @param MagenestMovie $movieResourceModel
     * @param Collection $collectionMovie
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        MagenestActorFactory $magenestActorFactory,
        MagenestMovieFactory $magenestMovieFactory,
        MagenestDirectorFactory $magenestDirectorFactory,
        RequestInterface $request,
        MagenestMovie $movieResourceModel,
        Collection $collectionMovie,
        array $data = []
    )
    {
        $this->magenestActorFactory = $magenestActorFactory;
        $this->magenestMovieFactory = $magenestMovieFactory;
        $this->magenestDirectorFactory = $magenestDirectorFactory;
        $this->request = $request;
        $this->movieResourceModel = $movieResourceModel;
        $this->collectionMovie = $collectionMovie;
        parent::__construct($context, $data);
    }

    public function getInfoMovie()
    {
        $movieId = $this->request->getParam("movie_id");
        $moveModel = $this->magenestMovieFactory->create();
        $directorModel = $this->magenestDirectorFactory->create();

        $this->movieResourceModel->load($moveModel, $movieId);
        $collectionMovieActor = $this->collectionMovie->getActorByMovieId($movieId)->getData();

        return $collectionMovieActor;
    }
}
