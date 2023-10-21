<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('first_name',TextType::class,[
                'attr'=>array(
                    'class' => 'form-control form-control-user',
                    'placeholder' => 'Enter First Name'
                ),
                'required' => true,
                'label' => false
            ])
            ->add('last_name',TextType::class,[
                'attr'=>array(
                    'class' => 'form-control form-control-user',
                    'placeholder' => 'Enter Last Name'
                ),
                'required' => true,
                'label' => false
            ])
            ->add('email',EmailType::class,[
                'attr'=>array(
                    'class' => 'form-control form-control-user',
                    'placeholder' => 'Enter Email'
                ),
                'required' => true,
                'label' => false
            ])
            ->add('password', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,

                'attr' => ['autocomplete' => 'new-password','class' => 'form-control form-control-user','placeholder' => 'Enter Password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'label' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
