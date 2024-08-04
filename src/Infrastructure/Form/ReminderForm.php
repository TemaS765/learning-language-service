<?php

declare(strict_types=1);

namespace App\Infrastructure\Form;

use App\Domain\Enum\ReminderChannelType;
use App\Infrastructure\Form\Model\UpdateReminderFormModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

class ReminderForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'id',
                HiddenType::class,
                [
                    'required' => false
                ]
            )
            ->add(
                'repeat_period',
                IntegerType::class,
                [
                    'label' => 'Период повтора (в минутах)',
                    'constraints' => [
                        new NotBlank(),
                        new Range(['min' => 0, 'max' => 10080])
                    ],
                    'attr' => [
                        'min' => 0,
                        'max' => 10080,
                    ]
                ]
            )
            ->add(
                'channel_type',
                EnumType::class,
                [
                    'label' => 'Канал оповещения',
                    'class' => ReminderChannelType::class,
                    'choice_label' => static fn ($choice) => match ($choice) {
                        ReminderChannelType::TELEGRAM => 'Телеграм',
                        ReminderChannelType::EMAIL => 'Электронная почта',
                    }
                ]
            )
            ->add(
                'channel_id',
                TextType::class,
                [
                    'label' => 'Идентификатор',
                    'constraints' => [
                        new Length(['max' => 255])
                    ],
                    'empty_data' => '',
                    'required' => false
                ]
            )
            ->add(
                'is_active',
                CheckboxType::class,
                [
                    'label' => 'Активен',
                    'required' => false
                ]
            )
            ->add('save', SubmitType::class, ['label' => 'Сохранить']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UpdateReminderFormModel::class,
        ]);
    }
}
