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

    /**
     * @covers CodeCollab\Encryption\Defuse\Decryptor::__construct
     * @covers CodeCollab\Encryption\Defuse\Decryptor::decrypt
     */
    public function testDecryptThrowsOnOpensslGetCipherMethodsNotAvailable()
    {
        if (!function_exists('uopz_backup')) {
            $this->markTestSkipped('uopz extension is not installed.');

            return;
        }

        uopz_backup('openssl_get_cipher_methods');
        uopz_delete('openssl_get_cipher_methods');

        $this->setExpectedException('CodeCollabLib\Encryption\CryptoException');

        $key       = (new Key())->generate();
        $decryptor = new Decryptor($key);

        $decryptor->decrypt('ciphertext');

        uopz_restore('openssl_get_cipher_methods');
    }

    /**
     * @covers CodeCollab\Encryption\Defuse\Decryptor::__construct
     * @covers CodeCollab\Encryption\Defuse\Decryptor::decrypt
     */
    public function testDecryptThrowsOnOpensslGetCipherMethodsCipherMethodNotAvailable()
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
        $decryptor = new Decryptor($key);

        $decryptor->encrypt('ciphertext');

        uopz_restore('openssl_get_cipher_methods');
    }

    /**
     * @covers CodeCollab\Encryption\Defuse\Decryptor::__construct
     * @covers CodeCollab\Encryption\Defuse\Decryptor::decrypt
     */
    public function testDecryptThrowsOnNonValidCipherTextLength()
    {
        if (!function_exists('uopz_backup')) {
            $this->markTestSkipped('uopz extension is not installed.');

            return;
        }

        $this->setExpectedException('CodeCollabLib\Encryption\FraudException');

        $key       = (new Key())->generate();
        $decryptor = new Decryptor($key);

        $decryptor->encrypt('ciphertext');
    }
}
