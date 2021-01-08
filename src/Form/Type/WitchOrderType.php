<?php

namespace App\Form\Type;

use App\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WitchOrderType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fakeCardNumber', TextType::class, [
                'required' => true,
                'label' => 'Votre numéro de carte bleue',
                'attr' => [
                    'class' => 'u-full-width fakeCardNumber',
                    'placeholder' => 'xxxx xxxx xxxx xxxx ',
                    'html5' => true,
                ]
            ])
            ->add('fakeDateExpiration', DateType::class, [
                'required' => true,
                'label' => "Choisissez une date d'expiration"
            ])
            ->add('fakeSecurityCode', NumberType::class, [
                'required' => true,
                'label' => 'Code de sécurité au dos de la carte',
                'attr' => [
                    'class' => 'u-full-width',
                    'html5' => true,
                    'placeholder' => 'xxx'
                ]
            ])
            ->add(
                'save',
                SubmitType::class,
                [
                    'label' => 'Enregistrer',
                    'attr' => [
                        'class' => 'button black-button',
                    ],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
            'error_mapping' => [
                'fakeCardNumber' => 'Number',
            ],
        ]);
    }
}
