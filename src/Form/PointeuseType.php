<?php

namespace App\Form;

use DateTime;
use App\Entity\Pointage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\WeekType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PointeuseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $date = new \DateTime();
        $pointagedujour = $options['pointagedujour'];

        $builder
        ->add('jour', DateType::class, [
            'widget' => 'single_text',
            'data' => $date,
            'required' => false

        ]);
        if ($options['pointagedujour'] === null)
        {
        $builder
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
            ]);
        }
           
        if (isset($options['pointagedujour']))
        {
           
            $builder->add('depart', TimeType::class,[
                'data' => $date
            ]); 

        }
        else
        {
        $builder->add('arrive', TimeType::class,[
            'data' => $date
        ]);

        }

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pointage::class,
            'pointagedujour' => null,
        ]);
    }
}
