<?php

declare(strict_types=1);

namespace MageOS\RMA\Controller\Customer\Comment;

use MageOS\RMA\Api\RMARepositoryInterface;
use MageOS\RMA\Service\CommentFormatter;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class LoadList implements HttpGetActionInterface
{
    /**
     * @param RequestInterface $request
     * @param JsonFactory $jsonFactory
     * @param RMARepositoryInterface $rmaRepository
     * @param CustomerSession $customerSession
     * @param CommentFormatter $commentFormatter
     */
    public function __construct(
        protected readonly RequestInterface $request,
        protected readonly JsonFactory $jsonFactory,
        protected readonly RMARepositoryInterface $rmaRepository,
        protected readonly CustomerSession $customerSession,
        protected readonly CommentFormatter $commentFormatter
    ) {
    }

    /**
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $result = $this->jsonFactory->create();

        if (!$this->customerSession->isLoggedIn()) {
            return $result->setData(['success' => false, 'comments' => []]);
        }

        $rmaId = (int)$this->request->getParam('rma_id');
        $afterId = (int)$this->request->getParam('after_id', 0);

        if (!$rmaId) {
            return $result->setData(['success' => false, 'comments' => []]);
        }

        if (!$this->isOwner($rmaId)) {
            return $result->setData(['success' => false, 'comments' => []]);
        }

        $comments = $this->commentFormatter->buildList($rmaId, visibleOnly: true, afterId: $afterId);

        return $result->setData(['success' => true, 'comments' => $comments]);
    }

    /**
     * @param int $rmaId
     * @return bool
     */
    protected function isOwner(int $rmaId): bool
    {
        try {
            $rma = $this->rmaRepository->get($rmaId);
        } catch (NoSuchEntityException) {
            return false;
        }

        return (int)$rma->getCustomerId() === (int)$this->customerSession->getCustomerId();
    }
}
