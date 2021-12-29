<?php

namespace Intern\Chapter45\Controller\Adminhtml\Movie;

use Intern\Chapter45\Model\MagenestMovieFactory;
use Magento\Backend\App\Action;
use Intern\Chapter45\Model\ResourceModel\MagenestMovieActor\Collection as MovieActorCollection;

/**
 * Class Save
 * @package Intern\Chapter45\Controller\Adminhtml\Movie
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
     * @param MovieActorCollection $movieActorCollection
     */
    public function __construct(
        Action\Context $context,
        MagenestMovieFactory $movieFactory,
        MovieActorCollection $movieActorCollection
    ) {
        parent::__construct($context);
        $this->movieFactory = $movieFactory;
        $this->movieActorCollection = $movieActorCollection;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $id = !empty($data['datamovie_addnewmovie']['movie_id']) ? $data['datamovie_addnewmovie']['movie_id'] : null;

        if ($movieDataPost = $data['datamovie_addnewmovie']) {
            $newData = [
                'name' => $movieDataPost['name'],
                'description' => $movieDataPost['description'],
                'rating' => $movieDataPost['rating'],
                'director_id' => $movieDataPost['director_id'],
            ];
            $actorid = $movieDataPost['actor_id'];

            foreach ($actorid as $idactor)
            {
                $acid[] = '('.$id.','.$idactor.')';
            }

            $insertActor = implode( ', ' , $acid);
            $this->movieActorCollection->insertToTable($insertActor);

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
