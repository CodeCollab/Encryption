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
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Exception\EnvironmentIsBrokenException;
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
     * @throw \CodeCollab\Encryption\CryptoException Telling users to upgrade to the v2 branch of defuse/crypto
     */
    public function encrypt(string $data): string
    {
        throw new CryptoException('New messages should not be encrypted using the v1 branch of defuse/crypto.');
    }
}
