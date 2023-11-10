<?php

namespace App\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Application\Http\ApiResponse;
use App\Model\Carrier\Entity\Carrier;
use App\Form\CarrierType;
use App\Model\Carrier\CarrierRepository;
use App\Model\Carrier\Service\CarrierService;
use App\Infrastructure\PaginationRequest\PaginationRequest;
use App\Infrastructure\PaginationSerializer\PaginationSerializer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

#[Route('/frontend/carriers', name: 'frontend_carriers')]
class CarrierController extends AbstractController
{
    public function __construct(public PaginationSerializer $paginationSerializer, public CarrierService $service, CarrierRepository $carrierRepository)
    {}

    #[Route('/', name: '_index', methods: ['GET'])]
    public function index(CarrierRepository $carrierRepository, Request $request): Response
    {
        //$carriers = $this->service->getItems(new PaginationRequest($request->query->all()));
        $carriers = $carrierRepository->findAll();
        //dd($carriers);
        return $this->render('carrier/index.html.twig', [
            'carriers' => $carrierRepository->findAll(),
        ]);


    }

    #[Route('/new', name: '_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $carrier = new Carrier();
        $form = $this->createForm(CarrierType::class, $carrier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($carrier);
            $entityManager->flush();

            return $this->redirectToRoute('frontend_carriers_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('carrier/new.html.twig', [
            'carrier' => $carrier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: '_show', methods: ['GET'])]
    public function show(Carrier $carrier): Response
    {
        return $this->render('carrier/show.html.twig', [
            'carrier' => $carrier,
        ]);
    }

    #[Route('/{id}/edit', name: '_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Carrier $carrier, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CarrierType::class, $carrier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('frontend_carriers_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('carrier/edit.html.twig', [
            'carrier' => $carrier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: '_delete', methods: ['POST'])]
    public function delete(Request $request, Carrier $carrier, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$carrier->getId(), $request->request->get('_token'))) {
            $entityManager->remove($carrier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('frontend_carriers_index', [], Response::HTTP_SEE_OTHER);
    }
}
