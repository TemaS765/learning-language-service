<?php

declare(strict_types=1);

namespace App\Infrastructure\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class WordForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'text',
                TextType::class,
                [
                    'label' => 'Текст',
                    'constraints' => [
                        new NotBlank(),
                        new Regex('~^[\p{L}`]+$~u'),
                        new Length(['min' => 1, 'max' => 255])
                    ]
                ]
            )
            ->add(
                'translate',
                TextType::class,
                [
                    'label' => 'Перевод',
                    'constraints' => [
                        new NotBlank(),
                        new Regex('~^[\p{L}`]+$~u'),
                        new Length(['min' => 1, 'max' => 255])
                    ]
                ]
            )
            ->add('add', SubmitType::class, ['label' => $options['button_label'] ?? 'Добавить']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'button_label' => '',
        ]);
    }


}
