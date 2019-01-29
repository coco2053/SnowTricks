<?php

namespace App\Form;

use App\Entity\Trick;
use App\Entity\TrickGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class TrickType extends AbstractType
{
    /**
     * [buildForm]
     * @param  FormBuilderInterface $builder
     * @param  array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('content')
            ->add('trickGroup', EntityType::class, [
                  'class' => TrickGroup::class,
                  'choice_label' => 'title'
            ])
          ->add('trickImages', CollectionType::class, array(
            'entry_type'   => TrickImageType::class,
            'entry_options' => ['label' => false],
            'allow_add'    => true,
            'allow_delete' => true,
            'by_reference' => false,
            'prototype'    => true,
            'required' => false
          ))
            ->add('videos', CollectionType::class, array(
                'entry_type' => VideoType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'prototype'    => true,
            ))
        ;
    }

    /**
     * [configureOptions]
     * @param  OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}
