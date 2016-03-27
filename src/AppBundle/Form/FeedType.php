<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url', UrlType::class, [
                'label' => 'URL for the feed',
                'required' => true,
                'attr' => [
                    'class' => 'url'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-sm btn-default submit'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        return [
            'data_class' => 'AppBundle/Model/Feed'
        ];
    }
}
