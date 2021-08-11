<?php

namespace Jascha030\Tests\Sequoia\Component;

use Jascha030\Sequoia\Component\TwigComponentInterface;
use Jascha030\Sequoia\Templater\TwigTemplater;
use Jascha030\Sequoia\Templater\TwigTemplaterInterface;
use Jascha030\Tests\Sequoia\Fixtures\Component\HelloWorldComponent;
use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * Class TwigComponentAbstractTest.
 *
 * @internal
 */
class TwigComponentAbstractTest extends TestCase
{
    /**
     * @depends testCreate
     */
    public function testHasDefaults(TwigComponentInterface $component): void
    {
        self::assertFalse($component->hasDefaults());
    }

    /**
     * @depends testCreate
     */
    public function testGetFilteredContext(TwigComponentInterface $component): void
    {
        self::assertEquals($this->getTestContext(), $component->getFilteredContext());
    }

    /**
     * @depends testCreate
     */
    public function testGetTemplate(TwigComponentInterface $component): void
    {
        self::assertEquals('test-hello-world.twig', $component->getTemplate());
    }

    /**
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\LoaderError
     */
    public function testRender(): void
    {
        ob_start();

        HelloWorldComponent::render(
            $this->getTemplater(),
            $this->getTestContext()
        );

        self::assertEquals($this->getDesiredOutput(), ob_get_clean());
    }

    /**
     * @depends testCreate
     *
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\LoaderError
     */
    public function testRenderContent(TwigComponentInterface $component): void
    {
        ob_start();
        $component->renderContent();

        self::assertEquals($this->getDesiredOutput(), ob_get_clean());
    }

    /**
     * @noinspection UnnecessaryAssertionInspection
     */
    public function testCreate(): TwigComponentInterface
    {
        $component = HelloWorldComponent::create(
            $this->getTemplater(),
            $this->getTestContext()
        );

        self::assertInstanceOf(TwigComponentInterface::class, $component);

        return $component;
    }

    /**
     * @depends testCreate
     */
    public function testGetContext(TwigComponentInterface $component): void
    {
        self::assertEquals($this->getTestContext(), $component->getContext());
    }

    /**
     * @depends testCreate
     */
    public function testSetContext(TwigComponentInterface $component): void
    {
        $component->setContext($this->getTestContext());
        self::assertEquals($this->getTestContext(), $component->getContext());
    }

    /**
     * @depends testCreate
     */
    public function testGetSlug(TwigComponentInterface $component): void
    {
        self::assertEquals('test-hello-world', $component->getTemplateSlug());
    }

    private function getTemplater(): TwigTemplaterInterface
    {
        $loader      = new FilesystemLoader(\dirname(__DIR__).'/Fixtures/Templates');
        $environment = new Environment($loader);

        return new TwigTemplater($environment);
    }

    private function getTestContext(): array
    {
        return ['greeting' => 'hello', 'location' => 'world'];
    }

    private function getDesiredOutput(): string
    {
        return '<p>hello world!</p>'.\PHP_EOL;
    }
}
