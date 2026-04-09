<?php

declare(strict_types=1);

namespace MageOS\RMA\Model;

use MageOS\RMA\Api\RMARepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\Exception\NoSuchEntityException;

abstract class AbstractRmaManagement
{
    /**
     * @param RMARepositoryInterface $rmaRepository
     * @param SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory
     * @param SortOrderBuilder $sortOrderBuilder
     */
    public function __construct(
        protected readonly RMARepositoryInterface $rmaRepository,
        protected readonly SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory,
        protected readonly SortOrderBuilder $sortOrderBuilder
    ) {
    }

    /**
     * @param int $rmaId
     * @throws NoSuchEntityException
     */
    protected function validateRmaExists(int $rmaId): void
    {
        $this->rmaRepository->get($rmaId);
    }

    /**
     * @param int $rmaId
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchCriteriaInterface
     */
    protected function buildScopedSearchCriteria(
        int $rmaId,
        SearchCriteriaInterface $searchCriteria
    ): SearchCriteriaInterface {
        $builder = $this->searchCriteriaBuilderFactory->create();
        $builder->addFilter('rma_id', $rmaId);

        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            $filters = array_filter(
                $filterGroup->getFilters() ?? [],
                fn($filter) => $filter->getField() !== 'rma_id'
            );

            if (!empty($filters)) {
                $builder->addFilters($filters);
            }
        }

        if ($searchCriteria->getSortOrders()) {
            foreach ($searchCriteria->getSortOrders() as $sortOrder) {
                $built = $this->sortOrderBuilder
                    ->setField($sortOrder->getField())
                    ->setDirection($sortOrder->getDirection())
                    ->create();
                $builder->addSortOrder($built);
            }
        }

        if ($searchCriteria->getPageSize()) {
            $builder->setPageSize($searchCriteria->getPageSize());
        }

        if ($searchCriteria->getCurrentPage()) {
            $builder->setCurrentPage($searchCriteria->getCurrentPage());
        }

        return $builder->create();
    }
}
