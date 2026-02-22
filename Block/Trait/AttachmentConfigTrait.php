<?php

declare(strict_types=1);

namespace MageOS\RMA\Block\Trait;

trait AttachmentConfigTrait
{
    /**
     * @return string
     */
    public function getAllowedExtensions(): string
    {
        return implode(',', $this->moduleConfig->getAllowedAttachmentExtensions());
    }

    /**
     * @return int
     */
    public function getMaxFileSize(): int
    {
        return $this->moduleConfig->getMaxAttachmentFileSize();
    }

    /**
     * @return int
     */
    public function getMaxFiles(): int
    {
        return $this->moduleConfig->getMaxAttachmentFiles();
    }
}
