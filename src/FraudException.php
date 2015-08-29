<?php declare(strict_types=1);
/**
 * Exception which gets thrown when something has gone bad with the supplied data
 *
 * The data may have been tampered with and we should bail out hard
 *
 * PHP version 7.0
 *
 * @category   CodeCollab
 * @package    Encryption
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2015 Pieter Hordijk <https://github.com/PeeHaa>
 * @license    See the LICENSE file
 * @version    1.0.0
 */
namespace CodeCollab\Encryption;

/**
 * Exception which gets thrown when something has gone bad with the supplied data
 *
 * @category   CodeCollab
 * @package    Encryption
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class FraudException extends \Exception
{
}
