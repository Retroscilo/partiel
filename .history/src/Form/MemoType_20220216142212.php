<?php

namespace App\Form;

use App\Entity\Memo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content')
            ->add('expirationDate', NumberType::class, [
                'input' => 'number',
                "constraints" =>  new Assert\Range([
                    'min' => 0,
                    'max' => 180,
                    'notInRangeMessage' => "L'expiration doit être comprise entre 0 et 180 min"
                ]),
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Memo::class,
        ]);
    }
}
