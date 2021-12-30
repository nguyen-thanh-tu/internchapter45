<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Intern\Chapter45\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Intern\Chapter45\Model\ResourceModel\MagenestDirector\Collection as CollectionMagenestDirector;

/**
 * Provide option values for UI
 */
class Director implements OptionSourceInterface
{


    /**
     * @param  CollectionMagenestDirector $collectionActor
     */

    public function __construct(
        CollectionMagenestDirector $collectionActor
    )
    {
        $this->collectionActor = $collectionActor;
    }
    /**
     * @inheritdoc
     */
    public function toOptionArray()
    {
        $arrdir = [];
        $dataDirector = $this->collectionActor->getData();
        foreach( $dataDirector as $value)
        {
            $arrdir[] = [
                'value' => $value['director_id'],
                'label' => $value['director_name'],
            ];
        }
        return $arrdir;
    }
}
