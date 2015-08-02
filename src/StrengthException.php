<?php declare(strict_types=1);
/**
 * Exception which gets thrown when an insufficient strong key is being generated
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
namespace CodeCollab\Security\Encryption;

/**
 * Exception which gets thrown when an insufficient strong key is being generated
 *
 * @category   CodeCollab
 * @package    Encryption
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class StrengthException extends \Exception
{
}
