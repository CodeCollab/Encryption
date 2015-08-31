<?php declare(strict_types=1);
/**
 * Defuse encryptor implementation
 *
 * PHP version 7.0
 *
 * @category   CodeCollab
 * @package    Encryption
 * @subpackage Defuse
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2015 Pieter Hordijk <https://github.com/PeeHaa>
 * @license    See the LICENSE file
 * @version    1.0.0
 */
namespace CodeCollab\Encryption\Defuse;

use CodeCollab\Encryption\Encryptor as EncryptorInterface;
use Crypto;
use CodeCollab\Encryption\CryptoException;

/**
 * Defuse encryptor implementation
 *
 * @category   CodeCollab
 * @package    Encryption
 * @subpackage Defuse
 * @author     Pieter Hordijk <info@pieterhordijk.com
 */
class Encryptor implements EncryptorInterface
{
    /**
     * @var string The encryption key
     */
    private $key;

    /**
     * Creates instance
     *
     * @param string $key The encryption key
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }

    /**
     * Encrypts data
     *
     * @param string $data The data to encrypt
     *
     * @return string The encrypted data
     *
     * @throw \CodeCollab\Encryption\CryptoException When not being able to (safely) encrypt the data
     */
    public function encrypt(string $data): string
    {
        try {
            return Crypto::encrypt($data, $this->key);
        } catch(\Exception $e) {
            throw new CryptoException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
