<?php 

namespace App\Controller;

use DateInterval;
use App\Entity\Pointage;
use App\Form\PointeuseType;
use App\Form\EditpointageType;
use App\Repository\PointageRepository;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BadgeuseController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(PointageRepository $pointageRepository): Response
    {
        $allpointage = $pointageRepository->findAll();
        
        return $this->render('home.html.twig', [
            'allpointage' => $allpointage 
        ]);
    }

     /**
     * @Route("/planning", name="app_planning")
     */
    public function planning(PointageRepository $pointageRepository): Response
    {
        return $this->render('planning.html.twig', []);
    }

    /**
     * @Route("/badgeuse", name="app_new_pointage")
     */
    public function new(Request $request, PointageRepository $pointageRepository): Response
    {

        // Surement un probleme avec le poste de de nuit !

        $pointage = new Pointage();
        $pointagedujour = $pointageRepository->findOneByJour(new \DateTime());

        $form = $this->createForm(PointeuseType::class, $pointage,[
            'pointagedujour' => $pointagedujour
        ]);
        $form->handleRequest($request);
        // Message fonctionne uniquement via des Sessions 
        // $this->addFlash(
        //     'notice',
        //     'Your changes were saved!'
        // );

        if ($form->isSubmitted() && $form->isValid()) {
            
            // Gestion des heure d'arrive pointé et depart pointé

            if($pointage->getPoste() === "Matin"){

                $pointage->setArrivepointage(new \DateTime());
                $pointage->setArrivepointage($pointage->getArrivepointage()->setTime(6,00));

                $pointage->setDepartpointage(new \DateTime());
                $pointage->setDepartpointage($pointage->getDepartpointage()->setTime(14,00));
                
            }
            elseif($pointage->getPoste() === "A-M")
            {

                $pointage->setArrivepointage(new \DateTime());
                $pointage->setArrivepointage($pointage->getArrivepointage()->setTime(14,00));

                $pointage->setDepartpointage(new \DateTime());
                $pointage->setDepartpointage($pointage->getDepartpointage()->setTime(22,00));

            }
            elseif($pointage->getPoste() === "Nuit")
            { 

                $currentDate = new \DateTime();
                $yesterdayTime = $currentDate->sub(new DateInterval('P1D'));
                $pointagedujour = $pointageRepository->findOneByJour($yesterdayTime);

                $pointage->setArrivepointage(new \DateTime());
                $pointage->setArrivepointage($pointage->getArrivepointage()->setTime(22,00));

                $pointage->setDepartpointage(new \DateTime());
                $pointage->setDepartpointage($pointage->getDepartpointage()->setTime(6,00));
            }

            

            if($pointagedujour !== null){
                $pointagedujour->setDepart($pointage->getDepart());
                $pointage = $pointagedujour;

            }

            // Gestion des heures de base et heure sup
            // Fonctionne mais a regler sur les bonnes heure 
           
            if($pointage->getDepart() !== null) {
                $heure = $pointage->getArrivepointage()->diff($pointage->getDepart());
                dd(floatval($heure->format('%h.%i')));

                // Regler les heure de depart et depart pointé en cas de depart 

                // Manque plus que la gestion des heures supp 

                


            }       
            
            // if($heure->h > 8){
            //     $pointage->setHeure(8); 
            //     $pointage->setHeuresup($heure->h - 8);
            // }
            // $pointage->setHeure($heure->h); 
            

            $pointageRepository->add($pointage, true);
            
            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }
        
        return $this->renderForm('pointage.html.twig', [
            'pointage' => $pointage,
            'form' => $form,
        ]);
    }
    
}
