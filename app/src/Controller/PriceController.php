<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Model\Carrier\CarrierRepository;

class PriceController extends AbstractController
{
    #[Route('/price', name: 'app_price')]
    public function index(CarrierRepository $carrierRepository): Response
    {
        $carriersArray = [];
        foreach ($carrierRepository->findAll() as $carrier){
            $carriersArray[$carrier->getId()] = array('id' => $carrier->getId(), 'title' => $carrier->getTitle());
        }
        return $this->render('price/index.html.twig', [
            'carriers' => $carriersArray,
        ]);
    }
}
