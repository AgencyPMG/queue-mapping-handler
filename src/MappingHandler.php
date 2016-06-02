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

namespace PMG\Queue\Handler;

use PMG\Queue\Message;
use PMG\Queue\MessageHandler;
use PMG\Queue\Handler\Mapping\HandlerResolver;
use PMG\Queue\Handler\Mapping\MappingResolver;

/**
 * A `MessageHandler` implementation that looks up callbacks for messages via a
 * `HandlerResolver`.
 *
 * @since 1.0
 */
final class MappingHandler implements MessageHandler
{
    /**
     * @var Mapping\HandlerResolver
     */
    private $resolver;

    public function __construct(HandlerResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    public static function fromArray($arrayOrArrayAccess)
    {
        return new self(new MappingResolver($arrayOrArrayAccess));
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Message $message)
    {
        return call_user_func($this->resolver->handlerFor($message), $message);
    }
}
