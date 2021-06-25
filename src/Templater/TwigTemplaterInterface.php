<?php

use Twig\Environment;

/**
 * Interface TwigTemplaterInterface.
 */
interface TwigTemplaterInterface
{
    /**
     * Ensure a twig environment is available for rendering.
     */
    public function getEnvironment(): Environment;

    /**
     * Should wrap the environments render() method.
     *
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function render(string $template, array $context = []): string;
}
