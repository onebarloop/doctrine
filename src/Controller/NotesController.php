<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Notes;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Service\Randicon;

class NotesController extends AbstractController
{
    #[Route('/notes')]
    public function index(): RedirectResponse
    {
        return $this->redirectToRoute('notes');
    }


    #[Route('/notes/list/{state}', name: 'notes')]
    public function defaultAction(EntityManagerInterface $entityManager, Randicon $randicon, string $state = null): Response
    {

        $icon = null;

        if ($state === 'success') {
            $icon = $randicon->getRandIcon();
        }

        $repository = $entityManager->getRepository(Notes::class);

        $notes = $repository->findAll();

        return $this->render('/notes/index.html.twig', [
            'notes' => $notes,
            'state' => $state,
            'icon' => $icon
        ]);
    }

    #[Route('notes/show/{id}/{update}', name: 'show')]
    public function detailAction(EntityManagerInterface $entityManager, Randicon $randicon, int $id, string $update = null): Response
    {
        $icon = null;
        if ($update) {
            $icon = $randicon->getRandIcon();
        }

        $note = $entityManager->getRepository(Notes::class)->find($id);

        return $this->render('/notes/detail.html.twig', [
            'note' => $note,
            'update' => $update,
            'icon' => $icon
        ]);
    }

    #[Route('/notes/create')]
    public function createNote(EntityManagerInterface $entityManager, Request $request): RedirectResponse
    {
        $name = $request->query->get('name');
        $description = $request->query->get('description');

        if (empty($name) || empty($description)) {
            return $this->redirectToRoute('notes', [
                'state' => 'failed'
            ]);
        }

        $note = new Notes();
        $note->setTitle($name);
        $note->setText($description);
        $note->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('Europe/Berlin')));

        $entityManager->persist($note);
        $entityManager->flush();

        return $this->redirectToRoute('notes', [
            'state' => 'success'
        ]);
    }


    #[Route('notes/delete/{id}')]
    public function deleteNote(EntityManagerInterface $entityManager, int $id): RedirectResponse
    {
        $note = $entityManager->getRepository(Notes::class)->find($id);

        $entityManager->remove($note);
        $entityManager->flush();

        return $this->redirectToRoute('notes');
    }

    #[Route('notes/update/{id}')]
    public function updateNote(EntityManagerInterface $entityManager, Request $request, int $id)
    {
        $note = $entityManager->getRepository(Notes::class)->find($id);
        $text = $request->query->get('text');

        $note->setText($text);
        $entityManager->flush();

        return $this->redirectToRoute('show', [
            'id' => $id,
            'update' => 'update'
        ]);
    }
}
