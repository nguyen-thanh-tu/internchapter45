<?php

namespace Intern\Chapter9\Api\Data;

interface MagenestBlogSearchResultInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * @return \Intern\Chapter9\Api\Data\MagenestBlogInterface[]
     */
    public function getItems();

    /**
     * @param \Intern\Chapter9\Api\Data\MagenestBlogInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
