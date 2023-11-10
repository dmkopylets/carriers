<?php

namespace App\Controller\Api;

use App\Controller\ApiController;
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

#[Route('/api/carriers', name: 'api_carriers')]
class ApiCarrierController extends ApiController
{
    public function __construct(public PaginationSerializer $paginationSerializer, public CarrierService $service, CarrierRepository $carrierRepository)
    {}

    #[Route('/', name: '_index', methods: ['GET'])]
    public function index(CarrierRepository $carrierRepository, Request $request): Response
    {
        //!!! for frontend
        // return $this->render('carrier/index.html.twig', [
        //     'carriers' => $carrierRepository->findAll(),
        // ]);

        $carriers = $this->service->getItems(new PaginationRequest($request->query->all()));
        return ApiResponse::successful('', [
            'pagination' => $this->paginationSerializer->toArray($carriers),
            'items' => $carriers->getItems(),
            'carriers' => $carrierRepository->findAll(),
            'columns' => $this->service->getTableColumns()
        ]);
    }

    #[Route('/new', name: 'app_carrier_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $carrier = new Carrier();
        $form = $this->createForm(CarrierType::class, $carrier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($carrier);
            $entityManager->flush();

            return $this->redirectToRoute('app_carrier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('carrier/new.html.twig', [
            'carrier' => $carrier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_carrier_show', methods: ['GET'])]
    public function show(Carrier $carrier): Response
    {
        return $this->render('carrier/show.html.twig', [
            'carrier' => $carrier,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_carrier_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Carrier $carrier, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CarrierType::class, $carrier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_carrier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('carrier/edit.html.twig', [
            'carrier' => $carrier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_carrier_delete', methods: ['POST'])]
    public function delete(Request $request, Carrier $carrier, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$carrier->getId(), $request->request->get('_token'))) {
            $entityManager->remove($carrier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_carrier_index', [], Response::HTTP_SEE_OTHER);
    }
}
