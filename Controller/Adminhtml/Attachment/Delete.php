<?php

declare(strict_types=1);

namespace MageOS\RMA\Controller\Adminhtml\Attachment;

use MageOS\RMA\Api\AttachmentRepositoryInterface;
use MageOS\RMA\Controller\Adminhtml\Rma as BaseController;
use MageOS\RMA\Service\AttachmentService;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Exception;

class Delete extends BaseController implements HttpPostActionInterface
{
    /**
     * @param Context $context
     * @param JsonFactory $jsonFactory
     * @param AttachmentRepositoryInterface $attachmentRepository
     * @param AttachmentService $attachmentService
     */
    public function __construct(
        Context $context,
        protected readonly JsonFactory $jsonFactory,
        protected readonly AttachmentRepositoryInterface $attachmentRepository,
        protected readonly AttachmentService $attachmentService
    ) {
        parent::__construct($context);
    }

    /**
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $result = $this->jsonFactory->create();
        $attachmentId = (int)$this->getRequest()->getParam('id');

        try {
            $attachment = $this->attachmentRepository->get($attachmentId);
            $this->attachmentService->deleteAttachment($attachment);
            return $result->setData(['success' => true]);
        } catch (NoSuchEntityException) {
            return $result->setData(['success' => false, 'message' => (string)__('Attachment not found.')]);
        } catch (Exception $e) {
            return $result->setData(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
