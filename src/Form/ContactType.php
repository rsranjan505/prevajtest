<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                'attr'=>array(
                    'class' => 'form-control',
                    'placeholder' => 'Enter Name'
                ),
                'required' => true,
                'label' => false
            ])
            ->add('mobile',TextType::class,[
                'attr'=>array(
                    'class' => 'form-control',
                    'placeholder' => 'Enter Mobile Number'
                ),
                'required' => false,
                'label' => false
            ])
            ->add('email',EmailType::class,[
                'attr'=>array(
                    'class' => 'form-control',
                    'placeholder' => 'Enter Email Address'
                ),
                'required' => false,
                'label' => false
            ])
            ->add('city',TextType::class,[
                'attr'=>array(
                    'class' => 'form-control',
                    'placeholder' => 'Enter City'
                ),
                'required' => false,
                'label' => false
            ])
            ->add('is_active',ChoiceType::class, [
                'choices'  => [
                    'Yes' => true,
                    'No' => false,
                ],
                'attr'=>array(
                    'class' => 'form-control',
                    'placeholder' => 'Select City'
                ),])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
