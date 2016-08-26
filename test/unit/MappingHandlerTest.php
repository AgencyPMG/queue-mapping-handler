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

use PMG\Queue\SimpleMessage;
use PMG\Queue\Handler\Mapping\HandlerResolver;

class MappingHandlerTest extends \PHPUnit_Framework_TestCase
{
    private $resolver, $handler, $message;

    public function testHandleLooksUpAndInvokesCallbackFromHandlerResolver()
    {
        $calledWith = null;
        $this->resolver->expects($this->once())
            ->method('handlerFor')
            ->with($this->message)
            ->willReturn(function ($msg) use (&$calledWith) {
                $calledWith = $msg;
                return true;
            });

        $result = $this->handler->handle($this->message);

        $this->assertTrue($result);
        $this->assertSame($this->message, $calledWith);
    }

    public function testHandlerInvokesCallbackFromResolveWithProvidedOptions()
    {
        $calledWith = null;
        $this->resolver->expects($this->once())
            ->method('handlerFor')
            ->with($this->message)
            ->willReturn(function ($msg, $options) use (&$calledWith) {
                $calledWith = $options;
                return true;
            });

        $result = $this->handler->handle($this->message, ['one' => true]);

        $this->assertTrue($result);
        $this->assertSame(['one' => true], $calledWith);
    }

    protected function setUp()
    {
        $this->resolver = $this->createMock(HandlerResolver::class);
        $this->handler = new MappingHandler($this->resolver);
        $this->message = new SimpleMessage('test');
    }
}
