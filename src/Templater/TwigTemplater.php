<?php

namespace Jascha030\Sequoia\Templater;

use Twig\Environment;

/**
 * Class TwigTemplater.
 */
class TwigTemplater implements TwigTemplaterInterface
{
    private Environment $environment;

    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * {@inheritDoc}
     */
    public function getEnvironment(): Environment
    {
        return $this->environment;
    }

    /**
     * {@inheritDoc}
     */
    public function render(string $template, array $context = []): string
    {
        return $this->getEnvironment()->render($template, $context);
    }
}
