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

use PMG\Queue\SimpleMessage;

class MappingResolverTest extends \PHPUnit_Framework_TestCase
{
    const NAME = 'TestMessage';

    private $message;

    public function testHandlerForErrorsWhenTheHandlerIsNotCallable()
    {
        $this->expectException(InvalidHandler::class);
        $resolver = new MappingResolver([
            self::NAME => 'notACallable',
        ]);

        $resolver->handlerFor($this->message);
    }

    public function testHandlerForErrorsWhenAHandlerIsNotFound()
    {
        $this->expectException(HandlerNotFound::class);
        $resolver = new MappingResolver([]);

        $resolver->handlerFor($this->message);
    }

    public function validMaps()
    {
        $handler = function () { };
        return [
            [[self::NAME => $handler]],
            [new \ArrayObject([self::NAME => $handler])],
        ];
    }

    /**
     * @dataProvider validMaps
     */
    public function testHandlerForReturnACallableWhenAHandlerIsFound($map)
    {
        $resolver = new MappingResolver($map);

        $this->assertInternalType('callable', $resolver->handlerFor($this->message));
    }

    public function invalidMaps()
    {
        return [
            [1],
            [1.0],
            [false],
            [null],
            [new \stdClass],
        ];
    }

    /**
     * @expectedException PMG\Queue\Exception\InvalidArgumentException
     * @dataProvider invalidMaps
     */
    public function testMappingResolverCannotBeCreatedWithInvalidMapping($map)
    {
        new MappingResolver($map);
    }

    protected function setUp()
    {
        $this->message = new SimpleMessage(self::NAME);
    }
}
