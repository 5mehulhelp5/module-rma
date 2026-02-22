<?php

declare(strict_types=1);

namespace MageOS\RMA\Model;

use MageOS\RMA\Api\Data\AttachmentInterface;
use MageOS\RMA\Model\ResourceModel\Attachment as ResourceModel;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Exception\LocalizedException;

class Attachment extends AbstractModel implements AttachmentInterface
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'rma_attachment_model';

    /**
     * @return void
     * @throws LocalizedException
     */
    protected function _construct(): void
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @return int|null
     */
    public function getEntityId(): ?int
    {
        $id = $this->getData(self::ENTITY_ID);
        return $id !== null ? (int)$id : null;
    }

    /**
     * @param $entityId
     * @return self
     */
    public function setEntityId($entityId): self
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    /**
     * @return int
     */
    public function getRmaId(): int
    {
        return (int)$this->getData(self::RMA_ID);
    }

    /**
     * @param int $rmaId
     * @return self
     */
    public function setRmaId(int $rmaId): self
    {
        return $this->setData(self::RMA_ID, $rmaId);
    }

    /**
     * @return int|null
     */
    public function getCommentId(): ?int
    {
        $id = $this->getData(self::COMMENT_ID);
        return $id !== null ? (int)$id : null;
    }

    /**
     * @param int|null $commentId
     * @return self
     */
    public function setCommentId(?int $commentId): self
    {
        return $this->setData(self::COMMENT_ID, $commentId);
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return (string)$this->getData(self::FILE_NAME);
    }

    /**
     * @param string $fileName
     * @return self
     */
    public function setFileName(string $fileName): self
    {
        return $this->setData(self::FILE_NAME, $fileName);
    }

    /**
     * @return string
     */
    public function getFilePath(): string
    {
        return (string)$this->getData(self::FILE_PATH);
    }

    /**
     * @param string $filePath
     * @return self
     */
    public function setFilePath(string $filePath): self
    {
        return $this->setData(self::FILE_PATH, $filePath);
    }

    /**
     * @return int
     */
    public function getFileSize(): int
    {
        return (int)$this->getData(self::FILE_SIZE);
    }

    /**
     * @param int $fileSize
     * @return self
     */
    public function setFileSize(int $fileSize): self
    {
        return $this->setData(self::FILE_SIZE, $fileSize);
    }

    /**
     * @return string
     */
    public function getMimeType(): string
    {
        return (string)$this->getData(self::MIME_TYPE);
    }

    /**
     * @param string $mimeType
     * @return self
     */
    public function setMimeType(string $mimeType): self
    {
        return $this->setData(self::MIME_TYPE, $mimeType);
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @param string $createdAt
     * @return self
     */
    public function setCreatedAt(string $createdAt): self
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }
}
