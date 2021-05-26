<?php

namespace App\Form;

use App\Entity\User;
use Faker\Provider\ar_JO\Text;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, ['attr'=>['class'=>'form-control']])
            ->add('password', PasswordType::class, ['attr'=>['class'=>'form-control']])
            ->add('firstName', TextType::class, ['attr'=>['class'=>'form-control']])
            ->add('lastName', TextType::class, ['attr'=>['class'=>'form-control']])
            ->add('tel', TextType::class, ['attr'=>['class'=>'form-control']])
            ->add('address', TextareaType::class, ['attr'=>['class'=>'form-control']])
            ->add('ville', TextType::class, ['attr'=>['class'=>'form-control']])
            ->add('dateNaissance', DateType::class, [ 'widget' => 'single_text', 'attr'=>['class'=>'form-control']])
            ->add('gender', ChoiceType::class,['attr'=>['class'=>'form-control'],
                'choices'  => [
                    'Homme' => 'homme',
                    'Femme' => 'femme',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
