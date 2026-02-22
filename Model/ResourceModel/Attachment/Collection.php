<?php

declare(strict_types=1);

namespace MageOS\RMA\Model\ResourceModel\Attachment;

use MageOS\RMA\Model\Attachment as Model;
use MageOS\RMA\Model\ResourceModel\Attachment as ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    /**
     * @var string
     */
    protected $_eventPrefix = 'rma_attachment_collection';

    /**
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
