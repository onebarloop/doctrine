<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Notes;

class NotesController extends AbstractController
{
    #[Route('/notes', name: 'notes')]
    public function defaultAction(EntityManagerInterface $entityManager, Request $request): Response
    {
        $error = $request->query->get('failed') == 1 ? true : false;

        $repository = $entityManager->getRepository(Notes::class);

        $notes = $repository->findAll();

        return $this->render('/notes/index.html.twig', [
            'notes' => $notes,
            'error' => $error
        ]);
    }

    #[Route('/notes/show/{id}')]
    public function detailAction(EntityManagerInterface $entityManager, int $id): Response
    {
        $note = $entityManager->getRepository(Notes::class)->find($id);

        return $this->render('/notes/detail.html.twig', [
            'note' => $note
        ]);
    }

    #[Route('/notes/create')]
    public function createNote(EntityManagerInterface $entityManager, Request $request): Response
    {
        $name = $request->query->get('name');
        $description = $request->query->get('description');

        $note = new Notes();
        $note->setTitle($name);
        $note->setText($description);

        if (empty($note->getTitle()) || empty($note->getText())) {
            return $this->redirectToRoute('notes', [
                'failed' => true
            ]);
        }

        $note->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('Europe/Berlin')));

        $entityManager->persist($note);
        $entityManager->flush();

        return $this->redirectToRoute('notes');
    }


    #[Route('notes/delete/{id}')]
    public function deleteNote(EntityManagerInterface $entityManager, int $id): Response
    {
        $note = $entityManager->getRepository(Notes::class)->find($id);

        $entityManager->remove($note);
        $entityManager->flush();

        return $this->redirectToRoute('notes');
    }
}
