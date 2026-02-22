<?php

declare(strict_types=1);

namespace MageOS\RMA\Controller\Customer\Attachment;

use MageOS\RMA\Service\AttachmentService;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Exception;

class Upload implements HttpPostActionInterface
{
    /**
     * @param JsonFactory $jsonFactory
     * @param CustomerSession $customerSession
     * @param AttachmentService $attachmentService
     */
    public function __construct(
        protected readonly JsonFactory $jsonFactory,
        protected readonly CustomerSession $customerSession,
        protected readonly AttachmentService $attachmentService
    ) {
    }

    /**
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $result = $this->jsonFactory->create();

        if (!$this->customerSession->isLoggedIn()) {
            return $result->setData(['success' => false, 'message' => (string)__('Not authorized.')]);
        }

        try {
            $fileData = $this->attachmentService->uploadToTmp('attachment');
            return $result->setData(['success' => true, 'file' => $fileData]);
        } catch (Exception $e) {
            return $result->setData(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
