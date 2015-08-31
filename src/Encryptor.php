<?php declare(strict_types=1);
/**
 * Interface for encryption classes
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
 * Interface for encryption classes
 *
 * @category   CodeCollab
 * @package    Encryption
 * @author     Pieter Hordijk <info@pieterhordijk.com
 */
interface Encryptor
{
    /**
     * Encrypts data
     *
     * @param string $data The data to encrypt
     *
     * @return string The encrypted data
     *
     * @throw \CodeCollab\Encryption\CryptoException When not being able to (safely) encrypt the data
     */
    public function encrypt(string $data): string;
}
