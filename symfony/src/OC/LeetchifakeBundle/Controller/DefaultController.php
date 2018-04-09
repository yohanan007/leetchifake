<?php

namespace OC\LeetchifakeBundle\Controller;

// importation de l'entite cagnotte
use OC\LeetchifakeBundle\Entity\cagnotte;
use OC\LeetchifakeBundle\Entity\type;
// importation des éléments du formulaire

use OC\LeetchifakeBundle\Entity\Don;

use Symfony\Component\Form\Forms;


use OC\LeetchifakeBundle\Form\cagnotteType;
use OC\LeetchifakeBundle\Form\cagnotteEditLeetchiType;
use OC\LeetchifakeBundle\Form\ImageType;
use OC\LeetchifakeBundle\Form\typeType;
use OC\LeetchifakeBundle\Form\DonType;

use OC\UserBundle\Form\UserType;
use OC\UserBundle\Entity\User;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;


// importation controller
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
       

      // declaration entity cagnotte pour le formulaire
       $cagnotte = new cagnotte();
      
      //recherche de toutes les catégories, méthodes lourdes autre methodes possible à partir de js et entitytype
        $em = $this->getDoctrine()->getManager();
       $typeCagnotte = $em->getRepository('OCLeetchifakeBundle:type')->findAll();

        //declaration de formulaire
        $form = $this->get('form.factory')->create(cagnotteEditLeetchiType::class, $cagnotte);
        
        $form->handleRequest($request);
        
        if ($request->isMethod('POST'))
        {
            if($form->isValid())
            {
                $variableIndex = $form->getData();
               $em->persist($variableIndex);
               $em->flush();
              
             return $this->redirectToRoute('oc_leetchifake_formulaire',array('id'=>$variableIndex->getId()),307);
            }
        }
        return $this->render('@OCLeetchifake/Default/index.html.twig',array( 'type'=>$typeCagnotte , 'form' => $form->createview() 
        ));
    }
    
    public function addAction(Request $request)
    {
        
        $cagnotte = new cagnotte();
       
        $form = $this->get('form.factory')->create(cagnotteType::class, $cagnotte)
        ;
        $form->handleRequest($request);
        
       if ($request->isMethod('POST'))
        {
            if($form->isValid())
            {
                 
                if (null != $this->getUser())
                {
                  try{
                    $cagnotte = $form->getData();
          
            $em = $this->getDoctrine()->getManager();
           
         // ajout de l'utilisateur à partir de l'entité cagnotte crée auparavent 
            $cagnotte->setUser($this->getUser());
             
            $em->persist($cagnotte);
            
           $em->flush();
                  } catch(\Doctrine\DBAL\DBALException $e){
                      echo $e;
                      return $this->render('@OCLeetchifake/Default/index.html.twig'
       );
                  }
                }
            }
        }
       return $this->render('@OCLeetchifake/Default/add.html.twig', 
       array('form' => $form->createview(),
       ));
    }
    
    public function validationAction($request)
    {
        
    }
    
    public function donAction(Request $request,$id)
    {
        //cagnotte
        $em = $this->getDoctrine()->getManager();
         $cagnotte = $em->getRepository('OCLeetchifakeBundle:cagnotte')->find($id);
        //fin cagnotte 
        
        // début don
        $don = new Don();
        $form = $this->get('form.factory')->create(DonType::class, $don);
        $form -> handleRequest($request);
        if($request -> isMethod('POST'))
        {
            if ($form -> isValid())
            {
                try{

                
                $cagnotte -> addDon($don);
                $em->persist($cagnotte);
                $em->flush();
                
                return $this->render('@OCLeetchifake/Default/don.html.twig',array('ok'=>'1', 'id'=>$id, 'cagnotte'=>$cagnotte, 'form' => $form->createview()
                ));
                
                }
                catch(\Doctrine\DBAL\DBALException $e)
                {
                    return $this->render('@OCLeetchifake/Default/don.html.twig',array('ok'=>'0', 'cagnotte'=>$cagnotte, 'e'=>$e, 'id'=>$id, 'form' => $form->createview()
                    ));
                }
            }
        }
       
        return $this->render('@OCLeetchifake/Default/don.html.twig', 
        array('id'=>$id, 'cagnotte'=>$cagnotte, 'form' => $form->createview()
        ));
    }
    
    public function cagnotteNameAction($user)
    {
        $cagnotte = $this->getDoctrine()
        ->getRepository('OCLeetchifakeBundle:cagnotte');
        $listcagnottes = $cagnotte->findAllCagnotteByUser($user);
    
        return $this->render('@OCLeetchifake/Default/cagnotte.html.twig', array('cagnottePage' => $listcagnottes, 'utilisateur' => $user));
    }
    
    public function rechercheAction(Request $request)
    {
        $recherche = 'rien';
        if ($request -> isMethod('POST'))
        {
            if($request->request->get('recherches'))
            {
                $user = $request->request->get('recherches');
                //fonction à terminer verifier cas vide et ...
                $em = $this->getDoctrine()
                ->getRepository('OCLeetchifakeBundle:cagnotte');
                
                $truc = $em->findAllCagnotteByUser($user);
                $tab = 
               array(array("id"=>"...","nom"=>"...","sommetotal"=>"..."));
               
              foreach ($truc as $tableau)
              {
                  $id = $tableau->getId();
                  $nom = $tableau->getNom();
                  $somme = $tableau->getSommetotal();
                  $tab1 = array("id"=>$id, "nom"=>$nom, "sommetotal"=>$somme);
                 array_push($tab, $tab1);
              }
                if (empty($truc))
                {
                     $reponse = $tab;
                }
               else
               {
                   $reponse = $tab;
               }
               
                return new JsonResponse(json_encode($reponse));
            }
        }
        return $this->render('@OCLeetchifake/Default/recherche.html.twig', array('recherche'=>$recherche));
    }
    
    public function formulaireAction(Request $request, $id)
    {
        // declaration variable pour nouvelle utilisateur
        $user = new User();
        // declaration formulaire pour nouvelle utilisateur
        $formUtilisateur = $this->get('form.factory')->create(UserType::class,$user);
        
       // declaration de la variable pour la cagnotte 
        $cagnotte = new cagnotte();
       $em = $this->getDoctrine()->getRepository('OCLeetchifakeBundle:cagnotte');
       $cagnotte = $em->find($id);
       // declaration du formulaire de la cagnotte
        $form = $this->get('form.factory')->create(cagnotteType::class, $cagnotte);
        // reponse formulaire
        if ($request -> isMethod('POST'))
        {
            // reponse formulaire cagnotte
            if($request ->request->get('oc_leetchifakebundle_cagnotte'))
            {
               
            }
            // reponse formulaire enregistrement 
            if ($request->request->get('app_user_registration'))
            {
               return $this->redirectToRoute('oc_leetchifake_homepage');
            }
        }
        // accées au template
        return $this->render('@OCLeetchifake/Default/formulaire.html.twig',array('form' => $form->createview(),
        'formUtilisateur'=> $formUtilisateur->createview() 
        ));
    }
    
    public function testAction(Request $request)
    {
        $user =new User ();
        $form = $this->get('form.factory')->create(UserType::class, $user);
        
        $form->handleRequest($request);
        
        if ($request->isMethod('POST'))
        {
            if($form->isValid())
            {
                try{
                    $user = $form->getData();
          
            $em = $this->getDoctrine()->getManager();
           
        
             
            $em->persist($user);
            
           $em->flush();
            return $this->render('@OCLeetchifake/Default/test.html.twig', array('form' => $form->createview()
        ));
                  } catch(\Doctrine\DBAL\DBALException $e){
                      echo $e;
                      return $this->render('@OCLeetchifake/Default/test.html.twig', array('form' => $form->createview()
        ));
      
                  }
                
                
                
            }
        }
        
        return $this->render('@OCLeetchifake/Default/test.html.twig', array('form' => $form->createview()
        ));
        
    }
}
