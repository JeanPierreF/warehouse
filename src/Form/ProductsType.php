<?php

namespace App\Form;

use App\Entity\packages;
use App\Entity\Products;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Sequentially;

class ProductsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => new Sequentially([
                    new Length(
                        min: 3,
                        max: 255,
                        minMessage: 'Pour le nom des produits il faut 3 carartéres minimun.',
                        maxMessage: 'Pour le nom des produits il faut 255 carartéres maximun.'
                    ),
                    new Regex(
                        '/^[a-zA-Z0-9. ]+(?:-[a-zA-Z0-9. ]+)*$/',
                        message:'Certains caractères ne sont pas acceptés'
                    ) 
                ])
            ])
            /*             ->add('created_at', null, [
                'widget' => 'single_text',
            ]) */
            ->add('id_packages', EntityType::class, [
                'class' => packages::class,
                'choice_label' => 'reference',
            ])
            ->add('Enregistrer', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Products::class,
        ]);
    }
}
