<?php

namespace Jascha030\Sequoia\Component;

use Jascha030\Sequoia\Templater\TwigTemplaterInterface;

/**
 * Class TwigComponent.
 */
abstract class TwigComponentAbstract implements TwigComponentInterface
{
    private TwigTemplaterInterface $templater;

    private array $context;

    /**
     * Private constructor, enforces usage of static::create() method.
     */
    private function __construct(TwigTemplaterInterface $twigTemplater)
    {
        $this->templater = $twigTemplater;
    }

    /**
     * Create an instance.
     *
     * @return \Jascha030\Sequoia\Component\TwigComponentInterface
     */
    final public static function create(TwigTemplaterInterface $templater, array $context = []): TwigComponentInterface
    {
        $template = new static($templater);
        $template->setContext($context);

        return $template;
    }

    /**
     * Static method to render the component.
     * Creates an instance and calls it's $component->render($context) method.
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    final public static function render(TwigTemplaterInterface $templater, array $context = []): void
    {
        static::create($templater, $context)->renderContent();
    }

    /**
     * {@inheritDoc}
     */
    final public function getContext(): array
    {
        return array_merge($this->getDefaults(), $this->context);
    }

    /**
     * {@inheritDoc}
     */
    final public function setContext(array $context = []): void
    {
        $this->context = $context ?? $this->getFilteredContext();
    }

    /**
     * {@inheritDoc}
     */
    final public function renderContent(bool $applyFilters = false): void
    {
        echo $this->templater->render(
            $this->getTemplate(),
            $applyFilters
                    ? $this->getFilteredContext()
                    : $this->getContext()
        );
    }

    /**
     * {@inheritDoc}
     */
    final public function getFilteredContext(): array
    {
        if (!\function_exists('apply_filters')) {
            return $this->getContext();
        }

        return apply_filters("twig_template_context_{$this->getTemplateSlug()}", $this->getContext());
    }

    /**
     * {@inheritDoc}
     */
    public function hasDefaults(): bool
    {
        return false;
    }

    /**
     * {@inheritDoc}
     */
    abstract public function getTemplate(): string;

    /**
     * {@inheritDoc}
     */
    public function getTemplateSlug(): string
    {
        return str_replace('.twig', '', $this->getTemplate());
    }

    protected function getDefaults(): array
    {
        return [];
    }
}
