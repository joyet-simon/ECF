<?php

namespace App\Service;

class Encoder {

    public static function encoderPassword(\Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface $passwordEncoder, \App\Entity\User $user) {
        return $passwordEncoder->encodePassword($user, $user->getPassword());
    }

    public static function verifPassword(\Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface $passwordEncoder, \App\Entity\User $user, \App\Entity\User $user2) {
        return $passwordEncoder->isPasswordValid($user, $user2->getPassword());
    }

}
