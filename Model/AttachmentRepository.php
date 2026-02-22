<?php

declare(strict_types=1);

namespace MageOS\RMA\Model;

use MageOS\RMA\Api\AttachmentRepositoryInterface;
use MageOS\RMA\Api\Data\AttachmentInterface;
use MageOS\RMA\Api\Data\AttachmentSearchResultsInterface;
use MageOS\RMA\Api\Data\AttachmentSearchResultsInterfaceFactory;
use MageOS\RMA\Model\ResourceModel\Attachment as ResourceModel;
use MageOS\RMA\Model\ResourceModel\Attachment\CollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class AttachmentRepository extends AbstractRepository implements AttachmentRepositoryInterface
{
    /**
     * @param ResourceModel $resourceModel
     * @param AttachmentFactory $attachmentFactory
     * @param CollectionFactory $collectionFactory
     * @param AttachmentSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceModel $resourceModel,
        protected readonly AttachmentFactory $attachmentFactory,
        protected readonly CollectionFactory $collectionFactory,
        protected readonly AttachmentSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        parent::__construct($resourceModel, $collectionProcessor);
    }

    /**
     * @return string
     */
    protected function getEntityLabel(): string
    {
        return 'RMA Attachment';
    }

    /**
     * @return AbstractModel
     */
    protected function createEntity(): AbstractModel
    {
        return $this->attachmentFactory->create();
    }

    /**
     * @return AbstractCollection
     */
    protected function createCollection(): AbstractCollection
    {
        return $this->collectionFactory->create();
    }

    /**
     * @return SearchResultsInterface
     */
    protected function createSearchResults(): SearchResultsInterface
    {
        return $this->searchResultsFactory->create();
    }

    /**
     * @param int $entityId
     * @return AttachmentInterface
     * @throws NoSuchEntityException
     */
    public function get(int $entityId): AttachmentInterface
    {
        return $this->loadEntity($entityId);
    }

    /**
     * @param AttachmentInterface $attachment
     * @return AttachmentInterface
     * @throws CouldNotSaveException
     */
    public function save(AttachmentInterface $attachment): AttachmentInterface
    {
        return $this->saveEntity($attachment);
    }

    /**
     * @param AttachmentInterface $attachment
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(AttachmentInterface $attachment): bool
    {
        return $this->deleteEntity($attachment);
    }

    /**
     * @param int $entityId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $entityId): bool
    {
        return $this->delete($this->get($entityId));
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return AttachmentSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): AttachmentSearchResultsInterface
    {
        return $this->performGetList($searchCriteria);
    }
}
