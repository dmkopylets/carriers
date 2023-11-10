<?php

declare(strict_types=1);

namespace App\Model\Carrier\Service;

use App\Model\Carrier\CarrierRepository;
use App\Model\Carrier\Entity\Carrier;
use App\Infrastructure\PaginationRequest\PaginationRequestInterface;
use App\Infrastructure\PaginationSerializer\Pagination\PaginationInterface;
use App\Model\EntityNotFoundException;


class CarrierService
{
    public function __construct(public CarrierRepository $carrierRepository) {}

    public function findById(int $carrierId): ?Carrier
    {
        return $this->carrierRepository->loadById($carrierId);
    }

    public function getById(int $carrierId): ?Carrier
    {
        if(!$carrier = $this->findById($carrierId)){
            throw new EntityNotFoundException('this carrierId does`t exist');
        }
        return $carrier;
    }


    public function getItems(PaginationRequestInterface $paginationRequest): PaginationInterface
    {
        return $this->carrierRepository->paginate($paginationRequest);
    }

    public function getTableColumns(): array
    {
        return [
            'id',
            'title',
            'weight_categoring',
            'price_uncategorized'
        ];
    }
}
