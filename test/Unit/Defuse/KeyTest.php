<?php declare(strict_types=1);

namespace CodeCollabTest\Unit\Encryption\Defuse;

use CodeCollab\Encryption\Key as KeyInterface;
use CodeCollab\Encryption\Defuse\Key;
use CodeCollab\Encryption\CryptoException;

class KeyTest extends \PHPUnit_Framework_TestCase
{
    protected $key;

    public function setUp()
    {
        $this->key = new Key();
    }

    /**
     * @covers CodeCollab\Encryption\Defuse\Key::__construct
     */
    public function testImplementsCorrectInterface()
    {
        $this->assertInstanceOf(KeyInterface::class, $this->key);
    }

    /**
     * @covers CodeCollab\Encryption\Defuse\Key::generate
     */
    public function testGenerateCorrectLengthThrowsCryptoExceptionBecauseOfObsoleteEncryptionMethod()
    {
        $this->expectException(CryptoException::class);
        $this->expectExceptionMessage('New messages should not be encrypted using the v1 branch of defuse/crypto.');

        $this->key->generate();
    }

    /**
     * @covers CodeCollab\Encryption\Defuse\Key::generate
     */
    public function testGenerateNotTheSameThrowsCryptoExceptionBecauseOfObsoleteEncryptionMethod()
    {
        $this->expectException(CryptoException::class);
        $this->expectExceptionMessage('New messages should not be encrypted using the v1 branch of defuse/crypto.');

        $keys = [];

        for ($i = 0; $i < 5000; $i++) {
            $key = $this->key->generate();

            $this->assertFalse(in_array($key, $keys, true));

            $keys[] = $key;
        }
    }

    /**
     * @covers CodeCollab\Encryption\Defuse\Key::generate
     */
    public function testGenerateThrowsOnCryptoErrorThrowsCryptoExceptionBecauseOfObsoleteEncryptionMethod()
    {
        if (!function_exists('uopz_backup')) {
            $this->markTestSkipped('uopz extension is not installed.');

            return;
        }

        uopz_backup('mcrypt_create_iv');
        uopz_delete('mcrypt_create_iv');

        $this->expectException(CryptoException::class);
        $this->expectExceptionMessage('New messages should not be encrypted using the v1 branch of defuse/crypto.');

        $this->key->generate();

        uopz_restore('mcrypt_create_iv');
    }
}
