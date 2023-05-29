<?php

namespace App\Form;

use App\Entity\Pointage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PointageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('jour', DateType::class)
            ->add('poste', ChoiceType::class, [
                'choices' => 
                [
                    'Matin' => 'Matin',
                    'Apres Midi' => 'A-M',
                    'Nuit' => 'Nuit',
                    'Journee' => 'Journee',
                    'Congé' => 'CP',
                    'Repos Conpensatoire' => 'RC',
                    'Repos' => 'Repos'
                ]
                ])
            ->add('arrive')
            ->add('arrivepointage')
            ->add('depart')
            ->add('departpointage')
            ->add('heure')
            ->add('heuresup')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pointage::class,
        ]);
    }
}
