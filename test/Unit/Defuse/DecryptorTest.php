<?php declare(strict_types=1);

namespace CodeCollabTest\Unit\Encryption\Defuse;

use CodeCollab\Encryption\Defuse\Decryptor as DecryptorInterface;
use CodeCollab\Encryption\Defuse\Decryptor;
use CodeCollab\Encryption\FraudException;
use CodeCollab\Encryption\CryptoException;

class DecryptorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers CodeCollab\Encryption\Defuse\Decryptor::__construct
     */
    public function testImplementsCorrectInterface()
    {
        $decryptor = new Decryptor('fakekey');

        $this->assertInstanceOf(DecryptorInterface::class, $decryptor);
    }

    /**
     * @covers CodeCollab\Encryption\Defuse\Decryptor::__construct
     * @covers CodeCollab\Encryption\Defuse\Decryptor::decrypt
     */
    public function testDecryptSuccess()
    {
        $decryptor = new Decryptor(base64_decode('iikuhrV0bgDuN8496EbSFA=='));

        $this->assertSame('foobarbaz', $decryptor->decrypt(base64_decode('nJo+MKc8G5/6n8bmNFINLJWBZJ/ppYvpoGXBWYe8tuT/ElZ2KydVfPCR5nlGDUu3RTHGLsScib2mmrk5WIf0hA==')));
    }

    /**
     * @covers CodeCollab\Encryption\Defuse\Decryptor::__construct
     * @covers CodeCollab\Encryption\Defuse\Decryptor::decrypt
     */
    public function testDecryptThrowsOnBadKey()
    {
        $this->expectException(FraudException::class);

        $decryptor = new Decryptor('bad key');

        $decryptor->decrypt(base64_decode('nJo+MKc8G5/6n8bmNFINLJWBZJ/ppYvpoGXBWYe8tuT/ElZ2KydVfPCR5nlGDUu3RTHGLsScib2mmrk5WIf0hA=='));
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

        $this->expectException(CryptoException::class);

        $decryptor = new Decryptor(base64_decode('iikuhrV0bgDuN8496EbSFA=='));

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

        $this->expectException(CryptoException::class);

        $decryptor = new Decryptor(base64_decode('iikuhrV0bgDuN8496EbSFA=='));

        $decryptor->decrypt('ciphertext');

        uopz_restore('openssl_get_cipher_methods');
    }

    /**
     * @covers CodeCollab\Encryption\Defuse\Decryptor::__construct
     * @covers CodeCollab\Encryption\Defuse\Decryptor::decrypt
     */
    public function testDecryptThrowsOnNonValidCipherTextLength()
    {
        $this->expectException(FraudException::class);

        $decryptor = new Decryptor(base64_decode('iikuhrV0bgDuN8496EbSFA=='));

        $decryptor->decrypt('ciphertext');
    }
}
