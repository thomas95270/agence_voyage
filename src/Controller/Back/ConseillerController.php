<?php

namespace App\Controller\Back;

use App\Entity\Conseiller;
use App\Form\ConseillerType;
use App\Repository\ConseillerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/admin/conseiller')]
class ConseillerController extends AbstractController
{
    #[Route('/', name: 'app_conseiller_index', methods: ['GET'])]
    public function index(ConseillerRepository $conseillerRepository): Response
    {
        $conseillers = $conseillerRepository->findAll();
        return $this->render('back/conseiller/index.html.twig', [
            'conseillers' => $conseillers,
        ]);
    }

    #[Route('/new', name: 'app_conseiller_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ConseillerRepository $conseillerRepository, UserPasswordHasherInterface $encoder): Response
    {
        $conseiller = new Conseiller();
        $form = $this->createForm(ConseillerType::class, $conseiller);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $date=new \DateTime();
            $conseiller->setMaj($date);

            $password = $encoder->hashPassword($conseiller, $conseiller->getPassword()) ;
            $conseiller->setPassword($password);

            $conseillerRepository->add($conseiller);
            return $this->redirectToRoute('app_conseiller_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/conseiller/new.html.twig', [
            'conseiller' => $conseiller,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/show', name: 'app_conseiller_show', methods: ['GET'])]
    public function show(Conseiller $conseiller): Response
    {
        return $this->render('back/conseiller/show.html.twig', [
            'conseiller' => $conseiller,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_conseiller_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Conseiller $conseiller, ConseillerRepository $conseillerRepository, UserPasswordHasherInterface $encoder): Response
    {
        $form = $this->createForm(ConseillerType::class, $conseiller);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $date=new \DateTime();
            $conseiller->setMaj($date);

            $password = $encoder->hashPassword($conseiller, $conseiller->getPassword()) ;
            $conseiller->setPassword($password);

            $conseillerRepository->add($conseiller);

            return $this->redirectToRoute('app_conseiller_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/conseiller/edit.html.twig', [
            'conseiller' => $conseiller,
            'form' => $form,
            'edit' =>true
        ]);
    }

    #[Route('/{id}', name: 'app_conseiller_delete', methods: ['POST'])]
    public function delete(Request $request, Conseiller $conseiller, ConseillerRepository $conseillerRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$conseiller->getId(), $request->request->get('_token'))) {
            $conseillerRepository->remove($conseiller);
        }

        return $this->redirectToRoute('app_conseiller_index', [], Response::HTTP_SEE_OTHER);
    }
}
