<?php

namespace App\Controller;

use App\Entity\Pointage;
use App\Form\PointageType;
use App\Repository\PointageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/pointage")
 */
class PointageController extends AbstractController
{
    /**
     * @Route("/", name="app_pointage_index", methods={"GET"})
     */
    public function index(PointageRepository $pointageRepository): Response
    {
        return $this->render('pointage/index.html.twig', [
            'pointages' => $pointageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_pointage_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PointageRepository $pointageRepository): Response
    {
        $pointage = new Pointage();
        $form = $this->createForm(PointageType::class, $pointage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pointageRepository->add($pointage, true);

            return $this->redirectToRoute('app_pointage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pointage/new.html.twig', [
            'pointage' => $pointage,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_pointage_show", methods={"GET"})
     */
    public function show(Pointage $pointage): Response
    {
        return $this->render('pointage/show.html.twig', [
            'pointage' => $pointage,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_pointage_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Pointage $pointage, PointageRepository $pointageRepository): Response
    {
        $form = $this->createForm(PointageType::class, $pointage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pointageRepository->add($pointage, true);

            return $this->redirectToRoute('app_pointage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pointage/edit.html.twig', [
            'pointage' => $pointage,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_pointage_delete", methods={"POST"})
     */
    public function delete(Request $request, Pointage $pointage, PointageRepository $pointageRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pointage->getId(), $request->request->get('_token'))) {
            $pointageRepository->remove($pointage, true);
        }

        return $this->redirectToRoute('app_pointage_index', [], Response::HTTP_SEE_OTHER);
    }
}
