<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 15/02/17
 * Time: 11:13.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NilPortugues\MessageBus\CommandBus\Resolver;

use Symfony\Component\DependencyInjection\ContainerInterface;
use InvalidArgumentException;
use NilPortugues\MessageBus\CommandBus\Contracts\CommandHandler;
use NilPortugues\MessageBus\CommandBus\Contracts\CommandHandlerResolver;

/**
 * Class SymfonyContainerResolver.
 */
class SymfonyContainerResolver implements CommandHandlerResolver
{
    /** @var ContainerInterface */
    protected $container;

    /**
     * SymfonyContainerResolver constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Given a string to identify the Command Handler, return the instance.
     *
     * @param string $handler
     *
     * @return CommandHandler
     */
    public function instantiate(string $handler) : CommandHandler
    {
        $handler = ltrim($handler, '\\');
        if (false === $this->container->has($handler)) {
            throw new InvalidArgumentException(
                sprintf('Handler %s could not be found. Did you register it?', $handler)
            );
        }

        return $this->container->get($handler);
    }
}
