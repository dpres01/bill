<?php

namespace App\Form;

use App\Entity\Billed;
use App\Entity\Person;
use App\Repository\PersonRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BilledType extends AbstractType
{
    public function __construct(private PersonRepository $persoRepo)
    {
        
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('owner', EntityType::class,[
            'label' => "Bailleur",
            'placeholder' => 'Veuillez selectionnez',
            'multiple' => false,
            'class' => Person::class,
            'query_builder' => function (EntityRepository $er): QueryBuilder {
                return $er->createQueryBuilder('p')
                    ->where('p.occupant = 0')
                    ->orderBy('p.firstName', 'ASC')
                    ->orderBy('p.lastName', 'ASC');
            },
            'choice_label' => function (Person $person): string{
                return $person;
            },
        ])
        ->add('renter',EntityType::class, [
            'label' => "Locataire",
            'placeholder' => 'Veuillez selectionnez',
            'multiple' => false,
            'class' => Person::class,
            'query_builder' => function (EntityRepository $er): QueryBuilder {
                return $er->createQueryBuilder('p')
                    ->where('p.occupant = 1')
                    ->orderBy('p.firstName', 'ASC')
                    ->orderBy('p.lastName', 'ASC');
            },
            'choice_label' => function (Person $person): string{
                return $person;
            },
        ])
        ->add('amount', TextType::class, [
            'label' => 'Montant (€)',
            'attr' => ['placeholder' => '100'], 
        ])
        ->add('chargesAmount', TextType::class, [
            'label' => "Charges (€)",
            'attr' => ['placeholder' => '50', 'onkeyup' =>'sumMount()'],
        ])
        ->add('total', TextType::class, [
            'label' => "Total (€)",
            'attr' => ['placeholder' => '150', 'readonly'=>'readonly'],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'=>Billed::class,
        ]);
    }
}
