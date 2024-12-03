<?php

declare(strict_types=1);

namespace App\Infrastructure\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ExamForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $answerFieldAttr = ['readonly' => true];
        if ('valid' === $options['validation_mode']) {
            $answerFieldAttr['class'] = 'form-control is-valid';
        } elseif ('invalid' === $options['validation_mode']) {
            $answerFieldAttr['class'] = 'form-control is-invalid';
        }

        $builder
            ->add(
                'question',
                TextType::class,
                [
                    'label' => 'Вопрос',
                    'constraints' => [
                        new NotBlank(),
                        new Regex('~^[\p{L}`]+$~u', 'Разрешены только буквы'),
                        new Length(['min' => 1, 'max' => 255]),
                    ],
                    'attr' => $answerFieldAttr,
                ]
            )
            ->add(
                'answer',
                TextType::class,
                [
                    'label' => 'Ответ',
                    'constraints' => [
                        new NotBlank(),
                        new Regex('~^[\p{L}`]+$~u', 'Разрешены только буквы'),
                        new Length(['min' => 1, 'max' => 255]),
                    ],
                    'attr' => ['readonly' => $options['readonly_form']],
                ]
            )
            ->add(
                'exercise_id',
                HiddenType::class
            )
            ->add('add', SubmitType::class, ['label' => $options['button_label'] ?? 'Добавить']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'button_label' => '',
            'readonly_form' => false,
            'validation_mode' => '',
        ]);
    }
}
