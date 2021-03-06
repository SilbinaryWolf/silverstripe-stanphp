<?php declare(strict_types = 1);

namespace Symbiote\SilverstripePHPStan\Reflection;

use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\ClassMemberReflection;
use PHPStan\Reflection\FunctionVariant;
use PHPStan\Type\Type;
use PHPStan\Type\ObjectType;

class ComponentHasOneMethod implements MethodReflection
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var \PHPStan\Reflection\ClassReflection
     */
    private $declaringClass;

    /**
     * @var ObjectType
     */
    private $returnType;

    /**
     * @var FunctionVariant[]|null
     */
    private $variants;

    public function __construct(string $name, ClassReflection $declaringClass, ObjectType $type)
    {
        $this->name = $name;
        $this->declaringClass = $declaringClass;
        $this->returnType = $type;
    }

    public function getDeclaringClass(): ClassReflection
    {
        return $this->declaringClass;
    }

    public function getPrototype(): ClassMemberReflection
    {
        return $this;
    }

    public function isStatic(): bool
    {
        return false;
    }

    public function getParameters(): array
    {
        return [];
    }

    public function isVariadic(): bool
    {
        return false;
    }

    public function isPrivate(): bool
    {
        return false;
    }

    public function isPublic(): bool
    {
        return true;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getReturnType(): Type
    {
        return $this->returnType;
    }

    public function getVariants(): array
    {
        if ($this->variants === null) {
            $this->variants = [
                new FunctionVariant(
                    $this->getParameters(),
                    $this->isVariadic(),
                    $this->getReturnType()
                ),
            ];
        }
        return $this->variants;
    }
}
