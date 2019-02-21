<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController {

    /**
     * @Route("/login", name="login")
     */
    public function index(\App\Repository\UserRepository $rep, \Symfony\Component\HttpFoundation\Request $req, \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface $paswwordEncoder) {
        $dto = new \App\Entity\User();
        $form = $this->createForm(\App\Form\LoginType::class, $dto);
        $form->handleRequest($req);
        $error = "";
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $rep->findOneByUsername($dto->getUsername());
            if ($user!= null) {
                if (\App\Service\Encoder::encoderPassword($paswwordEncoder, $user) == \App\Service\Encoder::encoderPassword($paswwordEncoder, $dto)) {
                    $req->getSession()->set("username", $user->getUsername());
                    return $this->redirectToRoute("home");
                } else {
                    $error = "Password invalid!";
                }
            } else {
                $error = "Username invalid!";
            }
        }
        return $this->render('login/index.html.twig', [
                    'user' => $dto,
                    'form' => $form->createView(),
                    'errorMessage' => $error,
        ]);
    }
    
    

}
