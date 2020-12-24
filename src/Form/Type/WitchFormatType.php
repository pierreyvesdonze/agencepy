<?php

namespace App\Form\Type;

use App\Entity\WitchFormat;
use App\Form\DataTransformer\WitchFormatTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WitchFormatType extends AbstractType
{

    private $transformer;

    public function __construct(WitchFormatTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        // $builder->add('size', EntityType::class, [
        //     'class' => WitchFormat::class,
        //     'choices' => $options['data']->getWitchFormats(),
            
        // ]);

        $builder->get('witchFormats')
            ->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => WitchFormat::class
        ]);
    }
}
