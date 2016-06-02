<?php
/**
 * This file is part of PMG\Queue
 *
 * Copyright (c) PMG <https://www.pmg.com>
 *
 * For full copyright information see the LICENSE file distributed
 * with this source code.
 *
 * @license     http://opensource.org/licenses/Apache-2.0 Apache-2.0
 */

namespace PMG\Queue\Handler\Mapping;

use PMG\Queue\Message;
use PMG\Queue\Exception\InvalidArgumentException;

/**
 * A simple resolver that maps messages => handlers via an array or ArrayAccess.
 *
 * @since   2.0
 */
final class MappingResolver implements HandlerResolver
{
    /**
     * @var array|ArrayAccess
     */
    private $handlers;

    public function __construct($handlers)
    {
        if (!is_array($handlers) && !$handlers instanceof \ArrayAccess) {
            throw new InvalidArgumentException(sprintf(
                '%s expects $handers to be an array or ArrayAccess implementation, got "%s"',
                __METHOD__,
                is_object($handlers) ? get_class($handlers) : gettype($handlers)
            ));
        }

        $this->handlers = $handlers;
    }

    /**
     * {@inheritdoc}
     */
    public function handlerFor(Message $message)
    {
        $name = $message->getName();

        if (!isset($this->handlers[$name])) {
            throw new HandlerNotFound(sprintf('No handler available for %s', $name));
        }
                
        $handler = $this->handlers[$name];
        if (!is_callable($handler)) {
            throw new InvalidHandler(sprintf(
                'Handlers should be callables, got %s for %s',
                is_object($handler) ? get_class($handler) : gettype($handler),
                $name
            ));
        }

        return $handler;
    }
}
