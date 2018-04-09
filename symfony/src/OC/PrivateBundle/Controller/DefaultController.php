<?php

namespace OC\PrivateBundle\Controller;

use Symfony\Component\Form\Forms;
use OC\PrivateBundle\Form\cagnotteEditType;

use OC\LeetchifakeBundle\Entity\cagnotte;
use Symfony\Component\HttpFoundation\Request;
use OC\LeetchifakeBundle\Form\cagnotteType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($user,$id)
    {
        return $this->render('@OCPrivate/Default/index.html.twig',array('user' => $user, 'id' => $id));
    }
    
    public function modificationAction(Request $request,$id,$nom)
    {
        
       $em = $this->getDoctrine()->getManager();
       $cagnotte = $em->getRepository('OCLeetchifakeBundle:cagnotte')->find($id);
       $cagnotteaffiche = $cagnotte;
       
       if (($cagnotte == null)||(!$cagnotte))
       {
           throw $this->createNotFoundException('pas de cagnotte pour id: ' .$id. ' et portant nom: ' .$nom);
       }
       $form = $this->get('form.factory')->create(cagnotteEditType::class, $cagnotte);
       $form->handleRequest($request);
       if ($request->isMethod('POST'))
       {
           if ($form->isValid())
           {
               try{
                   $em->persist($cagnotte);
                   $em->flush();
                   return $this->render('@OCPrivate/Default/don.html.twig',array('id'=>$id, 'nom'=>$nom, 'somme'=>$cagnotteaffiche, 'form' => $form->createview()
                ));
               
               }
               catch(\Doctrine\DBAL\DBALException $e)
               {
                   return $this->render('@OCPrivate/Default/don.html.twig',array('id'=>$id, 'nom'=>$nom, 'somme'=>$cagnotteaffiche, 'form' => $form->createview()
                ));
               }
           }
       }
       
       
       return $this->render('@OCPrivate/Default/don.html.twig',array('id'=>$id, 'nom'=>$nom, 'somme'=>$cagnotteaffiche, 'form' => $form->createview()
                ));
       
    }
}
