<?php declare(strict_types=1);
/**
 * Defuse key generator
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
namespace CodeCollab\Encryption\Defuse;

use CodeCollab\Encryption\Key as KeyInterface;
use CodeCollab\Encryption\CryptoException;

/**
 * Defuse key generator
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
     * @throws \CodeCollab\Encryption\CryptoException Telling users to upgrade to the v2 branch of defuse/crypto
     */
    public function generate(): string
    {
        throw new CryptoException('New messages should not be encrypted using the v1 branch of defuse/crypto.');
    }
}
