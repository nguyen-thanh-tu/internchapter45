<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Intern\Chapter45\Model\Config;
/**
 * Class DataProvider
 */
use Intern\Chapter45\Model\ResourceModel\MagenestMovie\CollectionFactory;
use Intern\Chapter45\Model\ResourceModel\MagenestMovieActor\Collection as MovieActorCollection;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $loadedData;
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $contactCollectionFactory,
        MovieActorCollection $movieActorCollection,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $contactCollectionFactory->create();
        $this->movieActorCollection = $movieActorCollection;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        $movieid = 0;

        foreach ($items as $contact) {
            // notre fieldset s'apelle "contact" d'ou ce tableau pour que magento puisse retrouver ses datas :
            $this->loadedData[$contact->getId()]['datamovie_addnewmovie'] = $contact->getData();
            $movieid = $contact->getId();
        }

        $actor = $this->movieActorCollection->getDataByMovieId($movieid);
        $actor_id = [];
        foreach ($actor as $valueActor)
        {
            $actor_id[] = $valueActor['actor_id'];
        }
        $this->loadedData[$movieid]['datamovie_addnewmovie']['actor_id'] = $actor_id;
        return $this->loadedData;
    }
}
