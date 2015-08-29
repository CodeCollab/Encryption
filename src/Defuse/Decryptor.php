<?php declare(strict_types=1);
/**
 * Defuse decryptor implementation
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

use CodeCollab\Encryption\Decryptor as DecryptorInterface;
use Crypto;
use CodeCollab\Encryption\FraudException;
use CodeCollab\Encryption\CryptoException;

/**
 * Defuse decryptor implementation
 *
 * @category   CodeCollab
 * @package    Encryption
 * @subpackage Defuse
 * @author     Pieter Hordijk <info@pieterhordijk.com
 */
class Decryptor implements DecryptorInterface
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
     * Decrypts data
     *
     * @param string $data The data to encrypt
     *
     * @return string The encrypted data
     */
    public function decrypt(string $data): string
    {
        try {
            return Crypto::decrypt($data, $this->key);
        } catch(\InvalidCiphertextException $e) {
            throw new FraudException($e->getMessage(), $e->getCode(), $e);
        } catch(\Exception $e) {
            throw new CryptoException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
