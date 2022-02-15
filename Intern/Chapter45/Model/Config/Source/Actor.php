<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Intern\Chapter45\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Intern\Chapter45\Model\ResourceModel\MagenestActor\Collection as CollectionMagenestActor;

/**
 * Provide option values for UI
 */
class Actor implements OptionSourceInterface
{


    /**
     * @param  CollectionMagenestActor $collectionActor
     */

    public function __construct(
        CollectionMagenestActor $collectionActor
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
                'value' => $value['actor_id'],
                'label' => $value['name'],
            ];
        }
        return $arrdir;
    }
}
