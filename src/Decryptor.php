<?php declare(strict_types=1);
/**
 * Interface for decryption classes
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
interface Decryptor
{
    /**
     * Decrypts data
     *
     * @param string $data The data to decrypt
     *
     * @return string The decrypted data
     */
    public function decrypt(string $data): string;
}
