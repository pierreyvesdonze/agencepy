<?php

namespace App\Form\Type;

use App\Entity\WitchFormat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WitchFormatCollectionType extends AbstractType
{
    
    /**
     * {@inheritdoc}
     */
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
    
        $builder->add('witchFormats', CollectionType::class, [
            'entry_type' => WitchFormatType::class,
            'entry_options' => $options['data']
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null
        ]);
    }
}
