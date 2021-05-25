<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',null,[
                'attr'=>[
                    'autofocus'=>'true',
                    'class'=>'titreevent'
                ],
                'label'=>'Titre',
                'label_attr'=>[
                    'class'=>'titrelabelevent'
                ]
            ])
            ->add('description',TextareaType::class,[
                'attr'=>[
                    'rows'=>'10',
                    'cols'=>'30',
                    'class'=>'descriptionevent'
                ],
                'label_attr'=>[
                    'class'=>'descriptionlabelevent'
                ]
            ])
            ->add('images',FileType::class,[
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false,
                'attr'=>[
                    'class'=>'imageevent'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
