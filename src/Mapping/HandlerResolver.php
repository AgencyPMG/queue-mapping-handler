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

/**
 * Handler Resolver implementations look the handlers for messages. Handlers
 * are simply callables.
 *
 * @since   1.0
 */
interface HandlerResolver
{
    /**
     * Get the handler for a single message.
     *
     * @param   $message The message to locate the handler for
     * @throws  Exception\InvalidHandler If a handler is not callable
     * @throws  Exception\HandlerNotFound if the handler cannot be located
     * @return  callable
     */
    public function handlerFor(Message $message);
}
