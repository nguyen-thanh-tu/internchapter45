<?php
namespace Intern\Chapter45\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;

/**
 * Class OrderId
 * Modifies the column Order id
 */
class Rating extends Column
{

    protected $logger;

    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        $this->logger = $logger;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['movie_id'])) {
                    $html = "<div>";
                    for($i=0; $i < $item['rating']; $i++){
                        $html .= '★';

                    }
                    $html .= "</div>";
                    // if($item['rating'] == 0){
                    //     $html = '<div style="color:white">★★★★★</div>';
                    //     $item['rating'] = $html;

                    // }else
                    // $html = 'ok';

                    $item['rating'] = $html;
                }
            }
        }
        return $dataSource;
    }
}
