<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname', TextType::class, [
                'label' => '* Nom de famille',
                'attr' => [
                    'placeholder' => 'Dupont',
                    'class' => 'u-full-width'
                ],
                'required' => true
            ])
            ->add('firstname', TextType::class, [
                'label' => '* Prénom',
                'attr' => [
                    'placeholder' => 'Jean',
                    'class' => 'u-full-width'
                ],
                'required' => true
            ])
            ->add('email', EmailType::class, [
                'label' => '* Email',
                'attr' => [
                    'placeholder' => 'email@mailbox.com',
                    'class' => 'u-full-width'
                ],
                'required' => true
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Vous êtes : ',
                'attr' => [
                    'class' => 'u-full-width'
                ],
                'choices'  => [
                    'Un particulier' => "particular",
                    'Un professionel' => "professional",
                ]
            ])
            ->add('message', TextareaType::class, [
                'label' => '* Votre message',
                'attr' => [
                    'class' => 'u-full-width'
                ],
                'required' => true
            ])
            ->add('Envoyer', SubmitType::class, [
                'attr' => [
                    'placeholder' => 'Envoyer'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
