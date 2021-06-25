<?php

namespace Jascha030\Sequoia\Component;

/**
 * Class TwigComponent.
 */
interface TwigComponentInterface
{
    /**
     * Get the template context.
     *
     * @return array
     */
    public function getContext(): array;

    /**
     * Set the context to be used when rendering the twig component.
     */
    public function setContext(array $context = []): void;

    /**
     * Renders the component.
     *
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
     * filter: twig_template_context_twig-login-form.
     */
    public function getFilteredContext(): array;

    /**
     * Return the (twig) template file name (e.g. "component-name.twig").
     */
    public function getTemplate(): string;

    /**
     * Return true or false based on whether the component has default values.
     */
    public function hasDefaults(): bool;
}
