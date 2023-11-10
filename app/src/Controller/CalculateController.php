<?php

namespace App\Controller;

use App\Service\PriceCalculatorService;
use App\Model\Carrier\CarrierRepository;
use App\Model\Carrier\CarrierWeightCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalculateController extends AbstractController
{
    #[Route('/calc', name: 'app_calc')]
    public function index(Request $request, CarrierRepository $carrierRepository): Response
    {
        $carriersArray = [];
        foreach ($carrierRepository->findAll() as $carrier){
            $carriersArray[$carrier->getId()] = array('id' => $carrier->getId(), 'title' => $carrier->getTitle());
        }

        $form = $this->createFormBuilder($carriersArray)
            ->setAction($this->generateUrl('app_calculate'))
            ->setMethod('POST')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('app_calculate', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('price/request.html.twig', [
            'carriers' => $carriersArray,
            'form' => $form,
        ]);
    }


    #[Route('/calculate', name: 'app_calculate', methods: ['POST'])]
    public function calculate(Request $request, PriceCalculatorService $priceCalculator, CarrierRepository $carrierRepository, CarrierWeightCategoryRepository $categoriesRepository): Response
    {
        $carrierId = $request->request->get('carrierId');
        $weight = $request->request->get('weight');
        $carrier = $carrierRepository->find($carrierId);

        $price = $priceCalculator->calculatePrice($carrier, $weight, $categoriesRepository);

        return $this->json([
            'carrierId' => $carrierId,
            'weight' => $weight,
            'carrier' => $carrier,
            'price' => $price,

        ]);
    }
}
