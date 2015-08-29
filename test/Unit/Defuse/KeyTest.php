<?php declare(strict_types=1);

namespace CodeCollabTest\Unit\Encryption\Defuse;

use CodeCollab\Encryption\Defuse\Key;

class KeyTest extends \PHPUnit_Framework_TestCase
{
    protected $key;

    public function setUp()
    {
        $this->key = new Key();
    }

    /**
     * @covers CodeCollab\Encryption\Defuse\Key::generate
     */
    public function testGenerateCorrectLength()
    {
        $this->assertSame(16, strlen($this->key->generate()));
    }

    /**
     * @covers CodeCollab\Encryption\Defuse\Key::generate
     */
    public function testGenerateNotTheSame()
    {
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
    public function testGenerateThrowsOnCryptoError()
    {
        if (!function_exists('uopz_backup')) {
            $this->markTestSkipped('uopz extension is not installed.');

            return;
        }

        uopz_backup('mcrypt_create_iv');
        uopz_delete('mcrypt_create_iv');

        $this->setExpectedException('CodeCollabLib\Encryption\CryptoException');

        $this->key->generate();

        uopz_restore('mcrypt_create_iv');
    }
}
