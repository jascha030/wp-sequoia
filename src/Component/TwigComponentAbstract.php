<?php

namespace Jascha030\Sequoia\Component;

/**
 * Class TwigComponent.
 */
abstract class TwigComponentAbstract implements TwigComponentInterface
{
    private TwigTemplater $templater;

    private array $context;

    /**
     * Private constructor, enforces usage of static::create() method.
     */
    private function __construct(TwigTemplater $twigTemplater)
    {
        $this->templater = $twigTemplater;
    }

    /**
     * Create an instance.
     *
     * @return \Jascha030\Sequoia\Component\TwigComponentInterface
     */
    final public static function create(array $context = []): TwigComponentInterface
    {
        $template = new static(Container::getInstance()->get(TwigTemplater::class));
        $template->setContext($context);

        return $template;
    }

    /**
     * Static method to render the component.
     * Creates an instance and calls it's $component->render($context) method.
     */
    final public static function render(array $context = []): void
    {
        static::create($context)->renderContent();
    }

    final public function getContext(): array
    {
        return array_merge($this->getDefaults(), $this->context);
    }

    final public function setContext(array $context = []): void
    {
        $this->context = $context ?? $this->getFilteredContext();
    }

    /**
     * Renders the component.
     */
    final public function renderContent(): void
    {
        echo $this->templater->render($this->getTemplate(), $this->context);
    }

    /**
     * Applies filter which name is composed of twig_template_context_{template-slug}, these filters can be used to
     * mutate it's default values and set context trough the wp hook system.
     * Example:
     * class: LoginFormComponent,
     * template: 'twig-login-form.twig',
     * filter: twig_template_context_twig-login-form.
     */
    final public function getFilteredContext(): array
    {
        return apply_filters("twig_template_context_{$this->getTemplateSlug()}", $this->getContext());
    }

    /**
     * Return the (twig) template file name (e.g. "component-name.twig").
     */
    abstract public function getTemplate(): string;

    /**
     * Return true or false based on whether the component has default values.
     */
    abstract public function hasDefaults(): bool;

    /**
     * Defaults to the template name without ".twig" appendix.
     */
    protected function getTemplateSlug(): string
    {
        return str_replace('.twig', '', $this->getTemplate());
    }

    /**
     * Overwrite this if component has default values.
     */
    protected function getDefaults(): array
    {
        return [];
    }
}
