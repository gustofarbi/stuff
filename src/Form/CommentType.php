<?php

namespace App\Form;

use App\Document\BlogPost;
use App\Document\User;
use App\Entity\Comment;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Valid;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'content',
                TextType::class,
                [
                    'constraints' => [
                        new NotBlank(),
                    ],
                ]
            )
            ->add(
                'user',
                EntityType::class,
                [
                    'class'       => User::class,
                    'constraints' => [
                        new NotBlank(),
                    ],
                ]
            )
            ->add(
                'blogpost',
                EntityType::class,
                [
                    'class'       => BlogPost::class,
                    'constraints' => [
                        new NotBlank(),
                    ],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Comment::class,
            ]
        );
    }
}
