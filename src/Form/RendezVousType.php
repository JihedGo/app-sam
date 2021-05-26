<?php

namespace App\Form;

use App\Entity\Patient;
use App\Entity\RendezVous;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RendezVousType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('medicin', EntityType::class,[
                'class' => User::class,
    'query_builder' => function (EntityRepository $er) {
        return $er->createQueryBuilder('u')
            ->where('u.role = :r')->setParameter('r','ROLE_MEDECIN');
    },
            ])
            ->add('patient', EntityType::class,[
                'class' => User::class,
    'query_builder' => function (EntityRepository $er) {
        return $er->createQueryBuilder('u')
            ->where('u.role = :r')->setParameter('r','ROLE_PATIENT');
    },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RendezVous::class,
        ]);
    }
}
