<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SigninController extends AbstractController {

    /**
     * @Route("/signin", name="signin")
     */
    public function signin(\Symfony\Component\HttpFoundation\Request $req, UserPasswordEncoderInterface $passwordEncoder) {
        $user = new \App\Entity\User();
        $form = $this->createForm(\App\Form\UserType::class, $user);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute("home");
        }
        return $this->render('signin/index.html.twig', [
                    'user' => $user,
                    'form' => $form->createView(),
        ]);
    }

}
