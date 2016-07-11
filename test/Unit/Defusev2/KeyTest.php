<?php declare(strict_types=1);

namespace CodeCollabTest\Unit\Encryption\Defusev2;

use CodeCollab\Encryption\Defusev2\Key;
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
        $this->assertInstanceOf(Key::class, $this->key);
    }

    /**
     * @covers CodeCollab\Encryption\Defuse\Key::generate
     */
    public function testGenerateCorrectLength()
    {
        $this->assertSame(136, strlen($this->key->generate()));
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

        uopz_backup('random_bytes');
        uopz_delete('random_bytes');

        $this->expectException(CryptoException::class);

        $this->key->generate();

        uopz_restore('random_bytes');
    }
}
