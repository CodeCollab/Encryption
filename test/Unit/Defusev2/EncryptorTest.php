<?php declare(strict_types=1);

namespace CodeCollabTest\Unit\Encryption\Defusev2;

use CodeCollab\Encryption\Encryptor as EncryptorInterface;
use CodeCollab\Encryption\Defusev2\Encryptor;
use Defuse\Crypto\Key as DefuseKey;
use CodeCollab\Encryption\CryptoException;

class EncryptorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers CodeCollab\Encryption\Defusev2\Encryptor::__construct
     */
    public function testImplementsCorrectInterface()
    {
        $encryptor = new Encryptor(DefuseKey::createNewRandomKey()->saveToAsciiSafeString());

        $this->assertInstanceOf(EncryptorInterface::class, $encryptor);
    }

    /**
     * @covers CodeCollab\Encryption\Defusev2\Encryptor::__construct
     * @covers CodeCollab\Encryption\Defusev2\Encryptor::encrypt
     */
    public function testConstructorThrowsOnInvalidKey()
    {
        $this->expectException(CryptoException::class);
        $this->expectExceptionMessage('Encoding::hexToBin() input is not a hex string.');

        new Encryptor('invalid key');
    }

    /**
     * @covers CodeCollab\Encryption\Defusev2\Encryptor::__construct
     * @covers CodeCollab\Encryption\Defusev2\Encryptor::encrypt
     */
    public function testEncryptSuccess()
    {
        $encryptor = new Encryptor(DefuseKey::createNewRandomKey()->saveToAsciiSafeString());

        $this->assertSame(186, strlen($encryptor->encrypt('foobarbaz')));
    }
}
