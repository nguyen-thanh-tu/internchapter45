<?php
namespace Intern\Chapter45\Block;

use Intern\Chapter45\Model\MagenestActorFactory;
use Intern\Chapter45\Model\MagenestDirectorFactory;
use Intern\Chapter45\Model\MagenestMovieFactory;
use Magento\Framework\View\Element\Template;
use Magento\Framework\App\RequestInterface;
use Intern\Chapter45\Model\ResourceModel\MagenestMovie;
use Intern\Chapter45\Model\ResourceModel\MagenestDirector;
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
     * @param MagenestDirector $directorResourceModel
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
        MagenestDirector $directorResourceModel,
        Collection $collectionMovie,
        array $data = []
    )
    {
        $this->magenestActorFactory = $magenestActorFactory;
        $this->magenestMovieFactory = $magenestMovieFactory;
        $this->magenestDirectorFactory = $magenestDirectorFactory;
        $this->request = $request;
        $this->movieResourceModel = $movieResourceModel;
        $this->directorResourceModel = $directorResourceModel;
        $this->collectionMovie = $collectionMovie;
        parent::__construct($context, $data);
    }

    public function getInfoMovie()
    {
        $movieId = $this->request->getParam("movie_id");
        $collectionMovieActor = $this->collectionMovie->getActorByMovieId($movieId)->getData();
        return $collectionMovieActor;
    }

    public function getDirectorName()
    {
        $movieId = $this->request->getParam("movie_id");
        $directorid = $this->magenestMovieFactory->create()->load($movieId)->getData('director_id');
        return $this->magenestDirectorFactory->create()->load(1)->getData('director_name');
    }
}
