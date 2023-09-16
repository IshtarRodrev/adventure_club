<?php

namespace App\Form;

use App\Helper\Calculation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use App\Enum\Operation;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class CalcArgumentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if (!$options['prevExpression']){
            $builder
                ->add('arg1', NumberType::class, [
                    'label' => 'Argument 1',
                ]);
        }
        $builder->add('operation',  EnumType::class, [
                'class' => Operation::class,
                'label' => 'Operator',
                'choice_label' => fn ($choice) => match ($choice) {
                    Operation::PLUS     => '+',
                    Operation::MINUS    => '-',
                    Operation::MULTIPLE => '×',
                    Operation::DIVIDE   => '÷',
                },
            ])
            ->add('arg2',  NumberType::class, [
                'label' => 'Argument 2',
                'constraints' => [
                    new Callback(array($this, 'divisionByZero')),
                ],
            ])
            ->add('next', SubmitType::class, [
                'attr' => [
                    'value' => 'next',
                ],
            ])
            ->add('calc', SubmitType::class, [
                'attr' => [
                    'value' => 'calc',
                ],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'prevExpression' => Calculation::class,
        ]);
    }

    public function divisionByZero($value, ExecutionContextInterface $context)
    {
        $form = $context->getRoot();
        $expr = $form->getData();

        if ($expr->getOperation() == Operation::DIVIDE && $expr->getArg2() == 0) {
            $context
                ->buildViolation('Деление на ноль!')
                ->atPath('arg2')
                ->addViolation();
        }
    }
}
