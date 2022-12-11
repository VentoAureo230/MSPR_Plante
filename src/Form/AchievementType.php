<?php

namespace App\Form;

use App\Entity\Achievement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class AchievementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('file',VichImageType::class)
            ->add('yes', SubmitType::class, array(
                'label' => 'Oui'))
            ->add('no', SubmitType::class, array(
                'label' => 'Non'))
            /*
            ->add('created_at')
            ->add('longitude')
            ->add('latitude')
            ->add('user')
            ->add('plant')*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Achievement::class,
        ]);
    }
}
