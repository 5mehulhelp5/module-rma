<?php

declare(strict_types=1);

namespace MageOS\RMA\Controller\Adminhtml\Comment;

use MageOS\RMA\Controller\Adminhtml\Rma as BaseController;
use MageOS\RMA\Service\CommentFormatter;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;

class LoadList extends BaseController implements HttpGetActionInterface
{
    /**
     * @param Context $context
     * @param JsonFactory $jsonFactory
     * @param CommentFormatter $commentFormatter
     */
    public function __construct(
        Context $context,
        protected readonly JsonFactory $jsonFactory,
        protected readonly CommentFormatter $commentFormatter
    ) {
        parent::__construct($context);
    }

    /**
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $result = $this->jsonFactory->create();
        $rmaId = (int)$this->getRequest()->getParam('rma_id');
        $afterId = (int)$this->getRequest()->getParam('after_id', 0);

        if (!$rmaId) {
            return $result->setData(['success' => false, 'comments' => []]);
        }

        $comments = $this->commentFormatter->buildList($rmaId, includeVisibility: true, afterId: $afterId);

        return $result->setData(['success' => true, 'comments' => $comments]);
    }
}
