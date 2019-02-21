<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('username', \Symfony\Component\Form\Extension\Core\Type\TextType::class)
                ->add('password', \Symfony\Component\Form\Extension\Core\Type\PasswordType::class)
                ->add('login', \Symfony\Component\Form\Extension\Core\Type\SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

}
