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

use PMG\Queue\QueueException;

/**
 * Thrown when a handler for a job is invalid (not a callable).
 *
 * @since   1.0
 */
final class InvalidHandler extends \UnexpectedValueException implements QueueException
{

}
