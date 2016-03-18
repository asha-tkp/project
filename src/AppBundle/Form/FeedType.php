<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('url', 'url',['label'=> 'URL for the feed'])
            ->add('submit', 'submit',[
                'attr'=> [
                    'class'=> 'btn btn-sm btn-default'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        return [
            'data_class' => 'AppBundle/Model/Feed'
        ];
    }

    public function getName()
    {
        return 'feed_type';
    }
}
