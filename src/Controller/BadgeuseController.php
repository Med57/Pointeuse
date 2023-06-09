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
            
            // Gestion des heure d'arrive et d'arrivé pointé.

            if($pointage->getPoste() === "Matin"){

                $pointage->setArrivepointage(new \DateTime());
                $pointage->setArrivepointage($pointage->getArrivepointage()->setTime(6,00));
                // dd($pointage);

                if($pointage->getDepart() !== null) {
                    
                    $pointage->setDepartpointage(new \DateTime());
                    $pointage->setDepartpointage($pointage->getDepartpointage()->setTime(14,00));
                    
                }   
                
            }
            elseif($pointage->getPoste() === "A-M")
            {
 
                $pointage->setArrivepointage(new \DateTime());
                $pointage->setArrivepointage($pointage->getArrivepointage()->setTime(14,00));

                // if($pointage->getDepart() !== null){

                //     $pointage->setDepartpointage(new \DateTime());
                //     $pointage->setDepartpointage($pointage->getDepartpointage()->setTime(22,00));

                // }

            }
            elseif($pointage->getPoste() === "Nuit")
            { 

                $pointage->setArrivepointage(new \DateTime());
                $pointage->setArrivepointage($pointage->getArrivepointage()->setTime(22,00));

                if($pointage->getDepart() !== null) {

                    $currentDate = new \DateTime();
                    $yesterdayTime = $currentDate->sub(new DateInterval('P1D'));
                    $pointagedujour = $pointageRepository->findOneByJour($yesterdayTime);

                    // $pointage->setDepartpointage(new \DateTime());
                    // $pointage->setDepartpointage($pointage->getDepartpointage()->setTime(6,00));

                }
            }

            // Gestion du poste de nuit : Recuperation du jour precedent dans la base de donner pour update l'heure de depart.

            if($pointagedujour !== null){
                $pointagedujour->setDepart($pointage->getDepart());
                $pointage = $pointagedujour;

            }

            // Gestion des heures de base et heure sup
           
            if($pointage->getDepart() !== null) {
                $heureInterval = $pointage->getArrivepointage()->diff($pointage->getDepart());
                $heure = floatval($heureInterval->format('%h.%i'));

                if($heure > 8){
                    $pointage->setHeure(8);
                    $pointage->setHeuresup($heure - 8);
                }
                else{
                    $pointage->setHeure($heure);
                }  

            }       

            $pointageRepository->add($pointage, true);
            
            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }
        
        return $this->renderForm('pointage.html.twig', [
            'pointage' => $pointage,
            'form' => $form,
        ]);
    }
    
}
