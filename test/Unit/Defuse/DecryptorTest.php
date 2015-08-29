<?php declare(strict_types=1);

namespace CodeCollabTest\Unit\Encryption\Defuse;

use CodeCollab\Encryption\Defuse\Encryptor;
use CodeCollab\Encryption\Defuse\Decryptor;
use CodeCollab\Encryption\Defuse\Key;

class DecryptorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers CodeCollab\Encryption\Defuse\Decryptor::__construct
     */
    public function testImplementsCorrectInterface()
    {
        $decryptor = new Decryptor((new Key())->generate());

        $this->assertInstanceOf('CodeCollab\Encryption\Decryptor', $decryptor);
    }

    /**
     * @covers CodeCollab\Encryption\Defuse\Decryptor::__construct
     * @covers CodeCollab\Encryption\Defuse\Decryptor::decrypt
     */
    public function testDecryptSuccess()
    {
        $key       = (new Key())->generate();
        $encryptor = new Encryptor($key);
        $decryptor = new Decryptor($key);

        $this->assertSame('foobarbaz', $decryptor->decrypt($encryptor->encrypt('foobarbaz')));
    }

    /**
     * @covers CodeCollab\Encryption\Defuse\Decryptor::__construct
     * @covers CodeCollab\Encryption\Defuse\Decryptor::decrypt
     */
    public function testDecryptThrowsOnBadKey()
    {
        $this->setExpectedException('CodeCollab\Encryption\FraudException');

        $key       = (new Key())->generate();
        $encryptor = new Encryptor($key);
        $decryptor = new Decryptor('bad key');

        $decryptor->decrypt($encryptor->encrypt('foobarbaz'));
    }
}
