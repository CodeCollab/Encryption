<?php declare(strict_types=1);
/**
 * Defuse V2 key generator
 *
 * PHP version 7.0
 *
 * @category   CodeCollab
 * @package    Encryption
 * @subpackage Defuse
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2015 Pieter Hordijk <https://github.com/PeeHaa>
 * @license    See the LICENSE file
 * @version    2.0.0
 */
namespace CodeCollab\Encryption\Defusev2;

use CodeCollab\Encryption\Key as KeyInterface;
use Defuse\Crypto\Key as DefuseKey;
use Defuse\Crypto\Exception\EnvironmentIsBrokenException;
use CodeCollab\Encryption\CryptoException;

/**
 * Defuse V2 key generator
 *
 * @category   CodeCollab
 * @package    Encryption
 * @subpackage Defuse
 * @author     Pieter Hordijk <info@pieterhordijk.com
 */
class Key implements KeyInterface
{
    /**
     * Generates a new key
     *
     * @return string The generated key
     *
     * @throws \CodeCollab\Encryption\CryptoException When not being able to create a sufficient strong key
     */
    public function generate(): string
    {
        try {
            return DefuseKey::createNewRandomKey()->saveToAsciiSafeString();
        } catch(EnvironmentIsBrokenException $e) {
            throw new CryptoException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
