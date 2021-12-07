<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    private  $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function calculTotal()
    {

        $gestionnaireEntite = $this->getDoctrine()->getManager();
        //gestionnaire d'entités

        //le gestionnaire va chercher dans le repos
        $TableContact = $gestionnaireEntite->getRepository(Contact::class);

       // retour du nombre de valeurs
        return $TableContact->createQueryBuilder('contact')

            ->select('COUNT(contact)')

            ->getQuery()
            //utiliser pour obtenir le resultat de la requete

            ->getSingleScalarResult();
        //recupere uniquement une valeur scalaire
    }

    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'contacts' => $this->contactRepository->findAll(),
            'total' => $this->calculTotal()


        ]);
    }


}
