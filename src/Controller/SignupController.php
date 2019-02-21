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
        $error = "";
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $qb = $em->createQueryBuilder();
            $qb->select("u")->from("App:User", "u")->where("u.username = :name")->setParameter("name", $user->getUsername());
            $userExist = $qb->getQuery()->getOneOrNullResult();
            if ($userExist) {
                $error = "Username already exist!";
            } else {
                $qb2 = $em->createQueryBuilder();
                $qb2->select("u2")->from("App:User", "u2")->where("u2.email = :email")->setParameter("email", $user->getEmail());
                $userExist = $qb2->getQuery()->getOneOrNullResult();
                if ($userExist) {
                    $error = "Email already exist!";
                } else {
                    $userExist = $qb->getQuery()->getOneOrNullResult();
                    $user->setPassword(\App\Service\Encoder::encoderPassword($paswwordEncoder, $user));
                    $user->setRole("ROLE_USER");
                    $em->persist($user);
                    $em->flush();
                    return $this->redirectToRoute("login");
                }
            }
        }
        return $this->render('signup/index.html.twig', [
                    'user' => $user,
                    'form' => $form->createView(),
                    'errorMessage' => $error,
        ]);
    }

}
