<?php

namespace Jascha030\Tests\Sequoia\Templater;

use Jascha030\Sequoia\Templater\TwigTemplaterInterface;
use Jascha030\Sequoia\Templater\TwigTemplater;
use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * Class TwigTemplaterTest
 * @package Jascha030\Tests\Sequoia\Templater
 */
final class TwigTemplaterTest extends TestCase
{
    /**
     * @return \Jascha030\Sequoia\Templater\TwigTemplaterInterface
     */
    public function testConstructor(): TwigTemplaterInterface
    {
        $loader      = new FilesystemLoader(dirname(__DIR__) . '/Fixtures/Templates');
        $environment = new Environment($loader);

        $templater = new TwigTemplater($environment);
        self::assertInstanceOf(TwigTemplaterInterface::class, $templater);

        return $templater;
    }

    /**
     * @noinspection UnnecessaryAssertionInspection
     * @depends      testConstructor
     *
     * @param \Jascha030\Sequoia\Templater\TwigTemplaterInterface $templater
     */
    public function testGetEnvironment(TwigTemplaterInterface $templater): void
    {
        self::assertInstanceOf(Environment::class, $templater->getEnvironment());
    }

    /**
     * @depends testConstructor
     *
     * @param \Jascha030\Sequoia\Templater\TwigTemplaterInterface $templater
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function testRender(TwigTemplaterInterface $templater): void
    {
        $output = $templater->render(
            'test-hello-world.twig',
            [
                'greeting' => 'hello',
                'location' => 'world'
            ]
        );

        self::assertEquals('<p>hello world!</p>' . PHP_EOL, $output);
    }
}
