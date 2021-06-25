<?php

namespace Jascha030\Sequoia\Component;

/**
 * Class TwigComponent
 * @package Jascha030\Sequoia\Templating\Component
 */
interface TwigComponentInterface
{
    public function getContext(): array;

    /**
     * Set the context to be used when rendering the twig component.
     * @param array $context
     */
    public function setContext(array $context = []): void;

    /**
     * Renders the component.
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function renderContent(): void;

    /**
     * Applies filter which name is composed of twig_template_context_{template-slug}, these filters can be used to
     * mutate it's default values and set context trough the wp hook system.
     * Example:
     * class: LoginFormComponent,
     * template: 'twig-login-form.twig',
     * filter: twig_template_context_twig-login-form
     * @return array
     */
    public function getFilteredContext(): array;

    /**
     * Return the (twig) template file name (e.g. "component-name.twig")
     * @return string
     */
    public function getTemplate(): string;

    /**
     * Return true or false based on whether the component has default values.
     * @return bool
     */
    public function hasDefaults(): bool;
}
