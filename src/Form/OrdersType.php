<?php

namespace App\Form;

use App\Entity\Orders;
use App\Entity\products;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Sequentially;

class OrdersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_order', null, [
                'widget' => 'single_text',
            ])
            ->add('supplier_name', TextType::class,[

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
            ->add('id_products', EntityType::class, [
                'class' => products::class,
                'choice_label' => 'name',
            ])
            ->add('quantity_order')
            ->add('delivered_at', null, [
                'widget' => 'single_text',
            ])

            ->add('Enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Orders::class,
        ]);
    }
}
