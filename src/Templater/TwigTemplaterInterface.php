<?php

interface TwigTemplaterInterface
{
    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function render(string $template, array $context = []): string;
}
