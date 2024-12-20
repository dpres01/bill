<?php

namespace App\Form;

use App\Entity\BilledMaker;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BilledMakerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startAtPeriod', null, [
                'widget' => 'single_text',
                'label' => "debut du mois à payer", 
            ])
            ->add('endAtPeriod', null, [
                'widget' => 'single_text',
                'label' => "fin du mois à payer", 
            ])
            ->add('paymentAt', null, [
                'widget' => 'single_text',
                'label' => "date de payement", 
            ])
            ->add('billedRef', BilledType::class, [
                'label' => 'Référence de la facture à générer',
                'attr' => ['readonly'=>'readonly'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BilledMaker::class,
        ]);
    }
}
