<?php

namespace Jascha030\Tests\Sequoia\Templater;

use Jascha030\Sequoia\Templater\TwigTemplater;
use Jascha030\Sequoia\Templater\TwigTemplaterInterface;
use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * Class TwigTemplaterTest.
 *
 * @internal
 */
final class TwigTemplaterTest extends TestCase
{
    public function testConstructor(): TwigTemplaterInterface
    {
        $loader      = new FilesystemLoader(\dirname(__DIR__).'/Fixtures/Templates');
        $environment = new Environment($loader);

        $templater = new TwigTemplater($environment);
        self::assertInstanceOf(TwigTemplaterInterface::class, $templater);

        return $templater;
    }

    /**
     * @noinspection UnnecessaryAssertionInspection
     * @depends      testConstructor
     */
    public function testGetEnvironment(TwigTemplaterInterface $templater): void
    {
        self::assertInstanceOf(Environment::class, $templater->getEnvironment());
    }

    /**
     * @depends testConstructor
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
                'location' => 'world',
            ]
        );

        self::assertEquals('<p>hello world!</p>'.\PHP_EOL, $output);
    }
}
