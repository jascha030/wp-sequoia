<?php

namespace Jascha030\Sequoia\Traits;

/**
 * Trait HasDefaultContext.
 */
trait HasDefaultContextTrait
{
    /**
     * Final function defines that component has default values.
     */
    final public function hasDefaults(): bool
    {
        return true;
    }

    /**
     * Enforce setting default values.
     */
    abstract public function getDefaults(): array;
}
