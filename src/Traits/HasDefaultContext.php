<?php

namespace Jascha030\Sequoia\Traits;

/**
 * Trait HasDefaultContext
 */
trait HasDefaultContext
{
    /**
     * Final function defines that component has default values.
     *
     * @return bool
     */
    final public function hasDefaults(): bool
    {
        return true;
    }

    /**
     * Enforce setting default values.
     *
     * @return array
     */
    abstract public function getDefaults(): array;
}
