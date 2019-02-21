<?php

namespace App\Service;

class Encoder {

    public static function encoderPassword(\Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface $passwordEncoder, \App\Entity\User $user) {
        return $password = $passwordEncoder->encodePassword($user, $user->getPassword());
    }

}
