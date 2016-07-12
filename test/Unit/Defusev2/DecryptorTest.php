<?php declare(strict_types=1);

namespace CodeCollabTest\Unit\Encryption\Defusev2;

use CodeCollab\Encryption\Defusev2\Encryptor;
use CodeCollab\Encryption\Decryptor as DecryptorInterface;
use CodeCollab\Encryption\Defusev2\Decryptor;
use Defuse\Crypto\Key as DefuseKey;
use CodeCollab\Encryption\Defusev2\Key;
use CodeCollab\Encryption\FraudException;
use CodeCollab\Encryption\CryptoException;

class DecryptorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers CodeCollab\Encryption\Defusev2\Decryptor::__construct
     */
    public function testImplementsCorrectInterface()
    {
        $decryptor = new Decryptor(DefuseKey::createNewRandomKey()->saveToAsciiSafeString());

        $this->assertInstanceOf(DecryptorInterface::class, $decryptor);
    }

    /**
     * @covers CodeCollab\Encryption\Defusev2\Decryptor::__construct
     * @covers CodeCollab\Encryption\Defusev2\Decryptor::encrypt
     */
    public function testConstructorThrowsOnInvalidKey()
    {
        $this->expectException(CryptoException::class);
        $this->expectExceptionMessage('Encoding::hexToBin() input is not a hex string.');

        new Decryptor('invalid key');
    }

    /**
     * @covers CodeCollab\Encryption\Defusev2\Decryptor::__construct
     * @covers CodeCollab\Encryption\Defusev2\Decryptor::decrypt
     */
    public function testDecryptSuccessStatically()
    {
        $decryptor = new Decryptor('def00000accee3e4f7b6a702b4023cee58f7f858dd70daf426de8e192a862641d2578e9dd2df126634f6eff7aaf6c9d74c943b3391dcf6803d1e2fd56003746e38e550d5');

        $this->assertSame('my secret message', $decryptor->decrypt('def50200c0b5d18a246ecb14a13b1b14a5c34dad1237f8dad3800400cfeb67bfd4df2bb4318b1c8e524df679e751ea7baf5341c780e20e1feb0d0c3a2292989f0f9bc6c54d1ef586dce5c0b2de271250dfc882c2bcd90ead1f64e4a30b39087285c3865b2b'));
    }

    /**
     * @covers CodeCollab\Encryption\Defusev2\Decryptor::__construct
     * @covers CodeCollab\Encryption\Defusev2\Decryptor::decrypt
     */
    public function testDecryptSuccessIntegration()
    {
        $key = (new Key())->generate();

        $encryptor = new Encryptor($key);
        $decryptor = new Decryptor($key);

        $this->assertSame('foobarbaz', $decryptor->decrypt($encryptor->encrypt('foobarbaz')));
    }

    /**
     * @covers CodeCollab\Encryption\Defusev2\Decryptor::__construct
     * @covers CodeCollab\Encryption\Defusev2\Decryptor::decrypt
     */
    public function testDecryptThrowsOnBadKey()
    {
        $encryptor = new Encryptor((new Key())->generate());
        $decryptor = new Decryptor((new Key())->generate());

        $this->expectException(FraudException::class);

        $decryptor->decrypt($encryptor->encrypt('foobar'));
    }
}
