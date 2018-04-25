<?php declare(strict_types = 1);

namespace SilbinaryWolf\SilverstripePHPStan;

use PhpParser\Node\Expr\StaticCall;

use PHPStan\Reflection\MethodReflection;
use PHPStan\Analyser\Scope;
use PHPStan\Type\Type;
use PHPStan\Type\ObjectType;

// Silverstripe
use DBField;

class DBFieldStaticReturnTypeExtension implements \PHPStan\Type\DynamicStaticMethodReturnTypeExtension
{
    public function getClass(): string
    {
        return DBField::class;
    }

    public function isStaticMethodSupported(MethodReflection $methodReflection): bool
    {
        $name = $methodReflection->getName();
        return $name === 'create_field';
    }

    public function getTypeFromStaticMethodCall(MethodReflection $methodReflection, StaticCall $methodCall, Scope $scope): Type
    {
        $name = $methodReflection->getName();
        switch ($name) {
            case 'create_field':
                if (count($methodCall->args) === 0) {
                    return $methodReflection->getReturnType();
                }
                // Handle DBField::create_field('HTMLText', '<p>Value</p>')
                $arg = $methodCall->args[0]->value;
                $type = Utility::getTypeFromVariable($arg, $methodReflection);
                return $type;
            break;
        }
        return $methodReflection->getReturnType();
    }
}
