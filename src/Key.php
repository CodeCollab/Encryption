<?php declare(strict_types=1);
/**
 * Encryption key generator interface
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
 * Encryption key generator interface
 *
 * @category   CodeCollab
 * @package    Encryption
 * @author     Pieter Hordijk <info@pieterhordijk.com
 */
interface Key
{
    /**
     * Generates a new key
     *
     * @return string The generated key
     *
     * @throw \CodeCollab\Encryption\CryptoException When not being able to create a sufficient strong key
     */
    public function generate(): string;
}
