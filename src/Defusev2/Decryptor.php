<?php declare(strict_types=1);
/**
 * Defuse V2 decryptor implementation
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

use CodeCollab\Encryption\Decryptor as DecryptorInterface;
use Defuse\Crypto\Key;
use Defuse\Crypto\Exception\BadFormatException;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Exception\EnvironmentIsBrokenException;
use Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException;
use CodeCollab\Encryption\FraudException;
use CodeCollab\Encryption\CryptoException;

/**
 * Defuse V2 decryptor implementation
 *
 * @category   CodeCollab
 * @package    Encryption
 * @subpackage Defuse
 * @author     Pieter Hordijk <info@pieterhordijk.com
 */
class Decryptor implements DecryptorInterface
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
     * @throws CryptoException
     */
    public function __construct(string $key)
    {
        try {
            $this->key = Key::loadFromAsciiSafeString($key);
        } catch (BadFormatException $e) {
            throw new CryptoException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Decrypts data
     *
     * @param string $data The data to encrypt
     *
     * @return string The encrypted data
     *
     * @throws \CodeCollab\Encryption\CryptoException When the message could not be decrypted
     * @throws \CodeCollab\Encryption\FraudException  When the message is potentially tampered with
     */
    public function decrypt(string $data): string
    {
        try {
            return Crypto::decrypt($data, $this->key);
        } catch(WrongKeyOrModifiedCiphertextException $e) {
            throw new FraudException($e->getMessage(), $e->getCode(), $e);
        } catch(EnvironmentIsBrokenException $e) {
            throw new CryptoException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
