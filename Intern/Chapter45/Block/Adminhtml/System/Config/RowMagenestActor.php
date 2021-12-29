<?php

namespace Intern\Chapter45\Block\Adminhtml\System\Config;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

use Intern\Chapter45\Block\Index as Movie;
use Intern\Chapter45\Model\ResourceModel\MagenestActor\Collection as CollectionMagenestActor;

class RowMagenestActor extends Field
{
    /**
     * Template path
     *
     * @var string
     */
    protected $_template = 'Intern_Chapter45::system/config/row_magenest_actor.phtml';

    /**
     * @param  Context     $context
     * @param  Movie     $movie
     * @param  CollectionMagenestActor $collectionActor
     * @param  array       $data
     */
    public function __construct(
        Context $context,
        Movie $movie,
        CollectionMagenestActor $collectionActor,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->movie = $movie;
        $this->collectionActor = $collectionActor;
    }

    /**
     * Remove scope label
     *
     * @param  AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }

    /**
     * Return element html
     *
     * @param  AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        return $this->_toHtml();
    }

    /**
     * Generate collect button html
     *
     * @return string
     */
    public function getRow()
    {
        $actor = $this->collectionActor->getData();
        return __(count($actor));
    }
}
