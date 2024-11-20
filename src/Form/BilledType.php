<?php

namespace App\Form;

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
        ->add('person',EntityType::class, [
            'label' => "Locataire",
            'multiple' => false,
            'class' => Person::class,
            'query_builder' => function (EntityRepository $er): QueryBuilder {
                return $er->createQueryBuilder('p')
                    ->orderBy('p.firstName', 'ASC')
                    ->orderBy('p.lastName', 'ASC');
            },
            'choice_label' => 'name',
        ])
        ->add('amount', TextType::class, [
            'label' => 'Montant (€)',
            'attr' => ['placeholder' => '100'], 
        ])
        ->add('chargesAmount', TextType::class, [
            'label' => "Charges (€)",
            'attr' => ['placeholder' => '50'],
        ])
        ->add('total', TextType::class, [
            'label' => "Total (€)",
            'attr' => ['placeholder' => '150'],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
