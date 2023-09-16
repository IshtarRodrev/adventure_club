<?php

namespace App\Helper;

use App\Enum\Operation;

class Calculation
{
    public float|Calculation $arg1 = 0;
    public float $arg2 = 0;
    public Operation $operation;

    public function getArg1(): float|Calculation
    {
        return $this->arg1;
    }

    public function setArg1(float|Calculation $arg): self
    {
        $this->arg1 = $arg;
        return $this;
    }

    public function getArg2(): float
    {
        return $this->arg2;
    }

    public function setArg2(float $arg): self
    {
        $this->arg2 = $arg;
        return $this;
    }

    public function getOperation(): Operation
    {
        return $this->operation;
    }

    public function setOperation(Operation $op): self
    {
        $this->operation = $op;
        return $this;
    }

    public function getExpression(): string
    {
        return
            $this->arg1 . ' ' .
            $this->operation->value . ' ' .
            $this->arg2 . ' = ' .
            $this->getResult();
    }

    public function __toString(): string
    {
        return
            '(' . $this->arg1 . ' ' .
            $this->operation->value . ' ' .
            $this->arg2 . ')';
    }

    public function getResult(): float
    {
        $arg1 = $this->arg1;
        if ($arg1 instanceof Calculation) {
            $arg1 = $arg1->getResult();
        }

        return match ($this->operation->value) {
            '+' => ($arg1 + $this->arg2),
            '-' => ($arg1 - $this->arg2),
            '*' => ($arg1 * $this->arg2),
            '/' => ($arg1 / $this->arg2),
        };
    }
}
