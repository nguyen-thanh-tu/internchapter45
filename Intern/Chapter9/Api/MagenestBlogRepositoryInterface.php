<?php

namespace Intern\Chapter9\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Intern\Chapter9\Api\Data\MagenestBlogInterface;

interface MagenestBlogRepositoryInterface
{
    /**
     * @param int $id
     * @return \Intern\Chapter9\Api\Data\MagenestBlogInterface
     */
    public function getById($id);

    /**
     * @param \Intern\Chapter9\Api\Data\MagenestBlogInterface $magenestBlog
     * @return \Intern\Chapter9\Api\Data\MagenestBlogInterface
     */
    public function save(MagenestBlogInterface $magenestBlog);

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById($id);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Intern\Chapter9\Api\Data\MagenestBlogSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}
