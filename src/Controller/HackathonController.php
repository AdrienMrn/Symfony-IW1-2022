<?php

namespace App\Controller;

use App\Entity\Hackathon;
use App\Form\HackathonType;
use App\Repository\HackathonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/hackathon', name: 'hackathon_')]
class HackathonController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(HackathonRepository $hackathonRepository): Response
    {
        return $this->render('hackathon/index.html.twig', [
            'hackathons' => $hackathonRepository->findBy([], ['name' => 'ASC']),
        ]);
    }

    #[Route('/create', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request, HackathonRepository $hackathonRepository)
    {
        $hackathon = new Hackathon();
        $form = $this->createForm(HackathonType::class, $hackathon);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $hackathonRepository->save($hackathon, true);

            return $this->redirectToRoute('hackathon_show', [
                'id' => $hackathon->getId()
            ]);
        }

        return $this->render('hackathon/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/{id}/update', name: 'update', requirements: ['id' => '\d'], methods: ['GET', 'POST'])]
    public function update(Hackathon $hackathon, Request $request, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(HackathonType::class, $hackathon);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('hackathon_show', [
                'id' => $hackathon->getId()
            ]);
        }

        return $this->render('hackathon/update.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d'], methods: ['GET'])]
    public function show(Hackathon $hackathon)
    {
        return $this->render('hackathon/show.html.twig', [
            'hackathon' => $hackathon
        ]);
    }

    #[Route('/{id}/remove/{token}', name: 'remove', requirements: ['id' => '\d'], methods: ['GET'])]
    public function remove(Hackathon $hackathon, string $token, HackathonRepository $hackathonRepository)
    {
        if (!$this->isCsrfTokenValid('remove' . $hackathon->getId(), $token)) {
            throw $this->createAccessDeniedException();
        }

        $hackathonRepository->remove($hackathon, true);

        return $this->redirectToRoute('hackathon_index');
    }
}
