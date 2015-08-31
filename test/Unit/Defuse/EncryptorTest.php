<?php declare(strict_types=1);

namespace CodeCollabTest\Unit\Encryption\Defuse;

use CodeCollab\Encryption\Defuse\Encryptor;
use CodeCollab\Encryption\Defuse\Key;

class EncryptorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers CodeCollab\Encryption\Defuse\Encryptor::__construct
     */
    public function testImplementsCorrectInterface()
    {
        $encryptor = new Encryptor('key');

        $this->assertInstanceOf('CodeCollab\Encryption\Encryptor', $encryptor);
    }

    /**
     * @covers CodeCollab\Encryption\Defuse\Encryptor::__construct
     * @covers CodeCollab\Encryption\Defuse\Encryptor::encrypt
     */
    public function testEncryptSuccess()
    {
        $key       = (new Key())->generate();
        $encryptor = new Encryptor($key);

        $this->assertSame(64, strlen($encryptor->encrypt('foobarbaz')));
    }

    /**
     * @covers CodeCollab\Encryption\Defuse\Encryptor::__construct
     * @covers CodeCollab\Encryption\Defuse\Encryptor::encrypt
     */
    public function testEncryptThrowsOnBadKey()
    {
        $this->setExpectedException('CodeCollab\Encryption\CryptoException');

        $encryptor = new Encryptor('bad key');

        $encryptor->encrypt('foobarbaz');
    }

    /**
     * @covers CodeCollab\Encryption\Defuse\Encryptor::__construct
     * @covers CodeCollab\Encryption\Defuse\Encryptor::encrypt
     */
    public function testEncryptThrowsOnOpensslGetCipherMethodsNotAvailable()
    {
        if (!function_exists('uopz_backup')) {
            $this->markTestSkipped('uopz extension is not installed.');

            return;
        }

        uopz_backup('openssl_get_cipher_methods');
        uopz_delete('openssl_get_cipher_methods');

        $this->setExpectedException('CodeCollabLib\Encryption\CryptoException');

        $key       = (new Key())->generate();
        $encryptor = new Encryptor($key);

        $encryptor->encrypt('foobarbaz');

        uopz_restore('openssl_get_cipher_methods');
    }

    /**
     * @covers CodeCollab\Encryption\Defuse\Encryptor::__construct
     * @covers CodeCollab\Encryption\Defuse\Encryptor::encrypt
     */
    public function testEncryptThrowsOnOpensslGetCipherMethodsCipherMethodNotAvailable()
    {
        if (!function_exists('uopz_backup')) {
            $this->markTestSkipped('uopz extension is not installed.');

            return;
        }

        uopz_backup('openssl_get_cipher_methods');
        uopz_function('openssl_get_cipher_methods', function(bool $aliases = false): array {
            return [];
        });

        $this->setExpectedException('CodeCollabLib\Encryption\CryptoException');

        $key       = (new Key())->generate();
        $encryptor = new Encryptor($key);

        $encryptor->encrypt('foobarbaz');

        uopz_restore('openssl_get_cipher_methods');
    }

    /**
     * @covers CodeCollab\Encryption\Defuse\Encryptor::__construct
     * @covers CodeCollab\Encryption\Defuse\Encryptor::encrypt
     */
    public function testEncryptThrowsOnOpensslCipherIvLengthMethodNotAvailable()
    {
        if (!function_exists('uopz_backup')) {
            $this->markTestSkipped('uopz extension is not installed.');

            return;
        }

        uopz_backup('openssl_cipher_iv_length');
        uopz_delete('openssl_cipher_iv_length');

        $this->setExpectedException('CodeCollabLib\Encryption\CryptoException');

        $key       = (new Key())->generate();
        $encryptor = new Encryptor($key);

        $encryptor->encrypt('foobarbaz');

        uopz_restore('openssl_cipher_iv_length');
    }

    /**
     * @covers CodeCollab\Encryption\Defuse\Encryptor::__construct
     * @covers CodeCollab\Encryption\Defuse\Encryptor::encrypt
     */
    public function testEncryptThrowsOnOpensslCipherIvLengthReturnsFalse()
    {
        if (!function_exists('uopz_backup')) {
            $this->markTestSkipped('uopz extension is not installed.');

            return;
        }

        uopz_backup('openssl_cipher_iv_length');
        uopz_function('openssl_cipher_iv_length', function(string $method): int {
            return false;
        });

        $this->setExpectedException('CodeCollabLib\Encryption\CryptoException');

        $key       = (new Key())->generate();
        $encryptor = new Encryptor($key);

        $encryptor->encrypt('foobarbaz');

        uopz_restore('openssl_cipher_iv_length');
    }

    /**
     * @covers CodeCollab\Encryption\Defuse\Encryptor::__construct
     * @covers CodeCollab\Encryption\Defuse\Encryptor::encrypt
     */
    public function testEncryptThrowsOnOpensslCipherIvLengthReturnsIvSizeSmallerThanZero()
    {
        if (!function_exists('uopz_backup')) {
            $this->markTestSkipped('uopz extension is not installed.');

            return;
        }

        uopz_backup('openssl_cipher_iv_length');
        uopz_function('openssl_cipher_iv_length', function(string $method): int {
            return -1;
        });

        $this->setExpectedException('CodeCollabLib\Encryption\CryptoException');

        $key       = (new Key())->generate();
        $encryptor = new Encryptor($key);

        $encryptor->encrypt('foobarbaz');

        uopz_restore('openssl_cipher_iv_length');
    }
}
