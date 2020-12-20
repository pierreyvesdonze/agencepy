<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'username',
            TextType::class,
            [
                'label' => false,
                'attr'  => [
                    'placeholder' => 'Username'
                ]
            ]
        );

        $builder->add(
            'email',
            EmailType::class,
            [
                'label' => false,
                'attr'  => [
                    'placeholder' => 'Email'
                ]
            ]
        );

        $builder->add(
            'plain_password',
            PasswordType::class,
            [
                'label'  => false,
                'mapped' => false,
                'attr'   => [
                    'placeholder' => 'Password'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length(["min" => 6])
                ]
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}