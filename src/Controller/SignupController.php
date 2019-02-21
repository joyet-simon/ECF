<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SignupController extends AbstractController {

    /**
     * @Route("/signup", name="signup")
     */
    public function signup(\Symfony\Component\HttpFoundation\Request $req, \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface $paswwordEncoder) {
        $user = new \App\Entity\User();
        $form = $this->createForm(\App\Form\UserType::class, $user);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user->setPassword(\App\Service\Encoder::encoderPassword($paswwordEncoder, $user));
            $user->setRole("ROLE_USER");
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute("login");
        }
        return $this->render('signup/index.html.twig', [
                    'user' => $user,
                    'form' => $form->createView(),
        ]);
    }

}
