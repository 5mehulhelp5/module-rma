<?php

declare(strict_types=1);

namespace MageOS\RMA\Block\Customer\Rma\View;

use MageOS\RMA\Api\Data\RMAInterface;
use MageOS\RMA\Block\Trait\AttachmentConfigTrait;
use MageOS\RMA\Helper\ModuleConfig;
use MageOS\RMA\Service\CommentFormatter;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Comments extends Template
{
    use AttachmentConfigTrait;

    /**
     * @var string
     */
    protected $_template = 'MageOS_RMA::customer/rma/view/comments.phtml';

    /**
     * @param Context $context
     * @param CommentFormatter $commentFormatter
     * @param ModuleConfig $moduleConfig
     * @param array $data
     */
    public function __construct(
        Context $context,
        protected readonly CommentFormatter $commentFormatter,
        protected readonly ModuleConfig $moduleConfig,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * @return RMAInterface|null
     */
    protected function getRma(): ?RMAInterface
    {
        return $this->getRequest()->getParam('rma_entity');
    }

    /**
     * @return int
     */
    public function getRmaId(): int
    {
        $rma = $this->getRma();
        return (int)$rma?->getEntityId();
    }

    /**
     * @return array
     */
    public function getComments(): array
    {
        $rmaId = $this->getRmaId();
        if (!$rmaId) {
            return [];
        }

        return $this->commentFormatter->buildList($rmaId, visibleOnly: true);
    }

    /**
     * @return string
     */
    public function getSaveUrl(): string
    {
        return $this->getUrl('rma/customer_comment/save');
    }

    /**
     * @return string
     */
    public function getLoadListUrl(): string
    {
        return $this->getUrl('rma/customer_comment/loadList');
    }

    /**
     * @return string
     */
    public function getUploadUrl(): string
    {
        return $this->getUrl('rma/customer_attachment/upload');
    }

    /**
     * @return string
     */
    public function getDownloadUrl(): string
    {
        return $this->getUrl('rma/customer_attachment/download');
    }
}
