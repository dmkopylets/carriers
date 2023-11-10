<?php

namespace App\Service;

use App\Model\Carrier\Entity\Carrier;
use App\Model\Carrier\CarrierWeightCategoryRepository;

class PriceCalculatorService
{
    public function calculatePrice(Carrier $carrier, int $weight, CarrierWeightCategoryRepository $categoriesRepository): float
    {
        $carrierPrice = $this->getCarrierPrice($carrier, $weight, $categoriesRepository);
        $calculatedPrice = $weight * $carrierPrice;
        return $calculatedPrice;
    }

    private function getCarrierPrice(Carrier $carrier, int $weight, CarrierWeightCategoryRepository $categoriesRepository)
    {
        if ($carrier->isWeightCategoring()){
            return $this->getMyWeightPrice($weight, $carrier,  $categoriesRepository);
        }
        return  $carrier->getPriceUncategorzed();
    }

    private function getMyWeightPrice(int $weight, Carrier $carrier, CarrierWeightCategoryRepository $categoriesRepository)
    {
        $myPrice = 0;
        $categories = $categoriesRepository->findBy(["carrier_id" => $carrier->getId()]);

        foreach($categories as $category){
            $range = array('min_range' => $category->getBeginning(), 'max_range' => $category->getEnding(),);
            $options = array('options' => $range);
            if (filter_var($weight, FILTER_VALIDATE_INT, $options) == true){
                $myPrice = $category->getPrice();
                }
        }
        return $myPrice;
    }
}
