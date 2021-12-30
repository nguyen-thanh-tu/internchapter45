<?php
namespace Intern\Chapter45\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;

/**
 * Class OrderId
 * Modifies the column Order id
 */
class OddEven extends Column
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
                $surplus = (int)$item['increment_id']%2;
                if($surplus == 0)
                {
                    $item['oddeven'] = '<span class="grid-severity-notice"><span>Even</span></span>';
                }else{
                    $item['oddeven'] = '<span class="grid-severity-critical"><span>Odd</span></span>';
                }
            }
        }
        return $dataSource;
    }
}

