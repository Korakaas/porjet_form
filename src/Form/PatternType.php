<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Pattern;
use App\Entity\Yarn;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PatternType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nom du patron'])
            ->add('description', TextareaType::class, ['label' => 'Description du patron'])
            ->add('yardage',TextType::class, ['label' => 'Métrage'] )
            ->add('image', TextType::class, ['label' => 'Image'])
            ->add('price', MoneyType::class, ['label' => 'Prix'])
            ->add('instructions', InstructionType::class)
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => 'Catégorie'
            ])
            ->add('yarns', EntityType::class, [
                'class' => Yarn::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'label' => 'Laines'
            ])
            ->add('Enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pattern::class,
        ]);
    }
}
