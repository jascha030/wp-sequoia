<?php

namespace Jascha030\Tests\Sequoia\Fixtures\Component;

use Jascha030\Sequoia\Component\TwigComponentAbstract;

/**
 * Class HelloWorldComponent.
 */
final class HelloWorldComponent extends TwigComponentAbstract
{
    /**
     * {@inheritDoc}
     */
    public function getTemplate(): string
    {
        return 'test-hello-world.twig';
    }
}
