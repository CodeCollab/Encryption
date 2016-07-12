<?php declare(strict_types=1);

namespace CodeCollabTest\Unit\Encryption\Defuse;

use CodeCollab\Encryption\Encryptor as EncryptorInterface;
use CodeCollab\Encryption\Defuse\Encryptor;
use CodeCollab\Encryption\Defuse\Key;
use CodeCollab\Encryption\CryptoException;

class EncryptorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers CodeCollab\Encryption\Defuse\Encryptor::__construct
     */
    public function testImplementsCorrectInterface()
    {
        $encryptor = new Encryptor('key');

        $this->assertInstanceOf(EncryptorInterface::class, $encryptor);
    }

    /**
     * @covers CodeCollab\Encryption\Defuse\Encryptor::__construct
     * @covers CodeCollab\Encryption\Defuse\Encryptor::encrypt
     */
    public function testEncryptSuccessThrowsCryptoExceptionBecauseOfObsoleteEncryptionMethod()
    {
        $this->expectException(CryptoException::class);
        $this->expectExceptionMessage('New messages should not be encrypted using the v1 branch of defuse/crypto.');

        $key       = (new Key())->generate();
        $encryptor = new Encryptor($key);

        $encryptor->encrypt('foobarbaz');
    }

    /**
     * @covers CodeCollab\Encryption\Defuse\Encryptor::__construct
     * @covers CodeCollab\Encryption\Defuse\Encryptor::encrypt
     */
    public function testEncryptThrowsOnBadKeyThrowsCryptoExceptionBecauseOfObsoleteEncryptionMethod()
    {
        $this->expectException(CryptoException::class);
        $this->expectExceptionMessage('New messages should not be encrypted using the v1 branch of defuse/crypto.');

        $encryptor = new Encryptor('bad key');

        $encryptor->encrypt('foobarbaz');
    }
}
