<?php declare(strict_types=1);

namespace CodeCollabTest\Unit\Encryption\Defuse;

use CodeCollab\Encryption\Encryptor;
use CodeCollab\Encryption\Defuse\Encryptor as DefuseEncryptor;
use CodeCollab\Encryption\Defuse\Key;
use CodeCollab\Encryption\CryptoException;

class EncryptorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers CodeCollab\Encryption\Defuse\Encryptor::__construct
     */
    public function testImplementsCorrectInterface()
    {
        $encryptor = new DefuseEncryptor('key');

        $this->assertInstanceOf(Encryptor::class, $encryptor);
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
        $encryptor = new DefuseEncryptor($key);

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

        $encryptor = new DefuseEncryptor('bad key');

        $encryptor->encrypt('foobarbaz');
    }

    /**
     * @covers CodeCollab\Encryption\Defuse\Encryptor::__construct
     * @covers CodeCollab\Encryption\Defuse\Encryptor::encrypt
     */
    public function testEncryptThrowsOnOpensslGetCipherMethodsNotAvailableThrowsCryptoExceptionBecauseOfObsoleteEncryptionMethod()
    {
        if (!function_exists('uopz_backup')) {
            $this->markTestSkipped('uopz extension is not installed.');

            return;
        }

        uopz_backup('openssl_get_cipher_methods');
        uopz_delete('openssl_get_cipher_methods');

        $this->expectException(CryptoException::class);
        $this->expectExceptionMessage('New messages should not be encrypted using the v1 branch of defuse/crypto.');

        $key       = (new Key())->generate();
        $encryptor = new DefuseEncryptor($key);

        $encryptor->encrypt('foobarbaz');

        uopz_restore('openssl_get_cipher_methods');
    }

    /**
     * @covers CodeCollab\Encryption\Defuse\Encryptor::__construct
     * @covers CodeCollab\Encryption\Defuse\Encryptor::encrypt
     */
    public function testEncryptThrowsOnOpensslGetCipherMethodsCipherMethodNotAvailableThrowsCryptoExceptionBecauseOfObsoleteEncryptionMethod()
    {
        if (!function_exists('uopz_backup')) {
            $this->markTestSkipped('uopz extension is not installed.');

            return;
        }

        uopz_backup('openssl_get_cipher_methods');
        uopz_function('openssl_get_cipher_methods', function(bool $aliases = false): array {
            return [];
        });

        $this->expectException(CryptoException::class);
        $this->expectExceptionMessage('New messages should not be encrypted using the v1 branch of defuse/crypto.');

        $key       = (new Key())->generate();
        $encryptor = new DefuseEncryptor($key);

        $encryptor->encrypt('foobarbaz');

        uopz_restore('openssl_get_cipher_methods');
    }

    /**
     * @covers CodeCollab\Encryption\Defuse\Encryptor::__construct
     * @covers CodeCollab\Encryption\Defuse\Encryptor::encrypt
     */
    public function testEncryptThrowsOnOpensslCipherIvLengthMethodNotAvailableThrowsCryptoExceptionBecauseOfObsoleteEncryptionMethod()
    {
        if (!function_exists('uopz_backup')) {
            $this->markTestSkipped('uopz extension is not installed.');

            return;
        }

        uopz_backup('openssl_cipher_iv_length');
        uopz_delete('openssl_cipher_iv_length');

        $this->expectException(CryptoException::class);
        $this->expectExceptionMessage('New messages should not be encrypted using the v1 branch of defuse/crypto.');

        $key       = (new Key())->generate();
        $encryptor = new DefuseEncryptor($key);

        $encryptor->encrypt('foobarbaz');

        uopz_restore('openssl_cipher_iv_length');
    }

    /**
     * @covers CodeCollab\Encryption\Defuse\Encryptor::__construct
     * @covers CodeCollab\Encryption\Defuse\Encryptor::encrypt
     */
    public function testEncryptThrowsOnOpensslCipherIvLengthReturnsFalseThrowsCryptoExceptionBecauseOfObsoleteEncryptionMethod()
    {
        if (!function_exists('uopz_backup')) {
            $this->markTestSkipped('uopz extension is not installed.');

            return;
        }

        uopz_backup('openssl_cipher_iv_length');
        uopz_function('openssl_cipher_iv_length', function(string $method): int {
            return false;
        });

        $this->expectException(CryptoException::class);
        $this->expectExceptionMessage('New messages should not be encrypted using the v1 branch of defuse/crypto.');

        $key       = (new Key())->generate();
        $encryptor = new DefuseEncryptor($key);

        $encryptor->encrypt('foobarbaz');

        uopz_restore('openssl_cipher_iv_length');
    }

    /**
     * @covers CodeCollab\Encryption\Defuse\Encryptor::__construct
     * @covers CodeCollab\Encryption\Defuse\Encryptor::encrypt
     */
    public function testEncryptThrowsOnOpensslCipherIvLengthReturnsIvSizeSmallerThanZeroThrowsCryptoExceptionBecauseOfObsoleteEncryptionMethod()
    {
        if (!function_exists('uopz_backup')) {
            $this->markTestSkipped('uopz extension is not installed.');

            return;
        }

        uopz_backup('openssl_cipher_iv_length');
        uopz_function('openssl_cipher_iv_length', function(string $method): int {
            return -1;
        });

        $this->expectException(CryptoException::class);
        $this->expectExceptionMessage('New messages should not be encrypted using the v1 branch of defuse/crypto.');

        $key       = (new Key())->generate();
        $encryptor = new DefuseEncryptor($key);

        $encryptor->encrypt('foobarbaz');

        uopz_restore('openssl_cipher_iv_length');
    }
}
