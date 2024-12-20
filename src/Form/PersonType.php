<?php

namespace App\Form;

use App\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('firstname', TextType::class, [
            'label' => 'Prénom',
            'required' => true,
        ])
        ->add('lastname', TextType::class, [
            'label' => 'Nom',
            'required' => true,
        ])
        ->add('birthday', TextType::class, [
            'label' => 'Date de Naissance',
            'required' => true,
        ])
        ->add('fromDate', TextType::class,[
            'label' => 'Date d\'entrée',
            'required' => false,
        ])
        ->add('occupant', CheckboxType::class, [
            'label' => 'Locataire ?',
            'required' => false,
        ])
        ;

        $builder
        ->get('fromDate')
        ->addModelTransformer(new DateTimeToStringTransformer(format: 'd-m-Y'));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'data_class' => Person::class,
        ]);
    }
}
