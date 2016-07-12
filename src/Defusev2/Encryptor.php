<?php declare(strict_types=1);
/**
 * Defuse V2 encryptor implementation
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
namespace CodeCollab\Encryption\Defusev2;

use CodeCollab\Encryption\Encryptor as EncryptorInterface;
use Defuse\Crypto\Key as DefuseKey;
use Defuse\Crypto\Exception\BadFormatException;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Exception\EnvironmentIsBrokenException;
use CodeCollab\Encryption\CryptoException;

/**
 * Defuse V2 encryptor implementation
 *
 * @category   CodeCollab
 * @package    Encryption
 * @subpackage Defuse
 * @author     Pieter Hordijk <info@pieterhordijk.com
 */
class Encryptor implements EncryptorInterface
{
    /**
     * @var \Defuse\Crypto\Key The encryption key
     */
    private $key;

    /**
     * Creates instance
     *
     * @param string $key The encryption key
     *
     * @throws \CodeCollab\Encryption\CryptoException When the key is not in a valid format
     */
    public function __construct(string $key)
    {
        try {
            $this->key = DefuseKey::loadFromAsciiSafeString($key);
        } catch (BadFormatException $e) {
            throw new CryptoException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Encrypts data
     *
     * @param string $data The data to encrypt
     *
     * @return string The encrypted data
     *
     * @throws \CodeCollab\Encryption\CryptoException When not being able to (safely) encrypt the data
     */
    public function encrypt(string $data): string
    {
        try {
            return Crypto::encrypt($data, $this->key);
        } catch(EnvironmentIsBrokenException $e) {
            throw new CryptoException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
