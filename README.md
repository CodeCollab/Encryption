# Encryption

Encryption package of the CodeCollab project

[![Build Status](https://travis-ci.org/CodeCollab/Encryption.svg?branch=master)](https://travis-ci.org/CodeCollab/Encryption) [![MIT License](https://img.shields.io/badge/license-MIT-blue.svg)](mit) [![Latest Stable Version](https://poser.pugx.org/codecollab/encryption/v/stable)](https://packagist.org/packages/codecollab/encryption) [![Total Downloads](https://poser.pugx.org/codecollab/encryption/downloads)](https://packagist.org/packages/codecollab/encryption) [![Latest Unstable Version](https://poser.pugx.org/codecollab/encryption/v/unstable)](https://packagist.org/packages/codecollab/encryption)

## Requirements

PHP7+

## Installation

Include the library in your project using composer:

    {
        "require-dev": {
            "codecollab/encryption": "^2"
        }
    }

## Usage

This library provides a common interfaces and exceptions for handling crypto in your applications..

### Generating key

Before being able to encrypt/decrypt data a key needs to be generated / added. To generate a new key use:

    $key = (new \CodeCollab\Encryption\Defusev2\Key())->generate();
    
*Note: keys should always be stored in a secure location and should never be made public.*

*Note: all key share the common `CodeCollab\Encryption\Key` interface.*

### Encrypting

    $encryptedData = (new \CodeCollab\Encryption\Defusev2\Encryptor($key))->encrypt('the data to encrypt');
    
*Note: all encryptors share the common `CodeCollab\Encryption\Encryptor` interface.*

### Decrypting

    $decryptedData = (new \CodeCollab\Encryption\Defusev2\Decryptor($key))->decrypt($encryptedData);
    
*Note: all decryptors share the common `CodeCollab\Encryption\Decryptor` interface.*

To decrypt old data encrypted with v1* of this library use the deprecated:

    $decryptedData = (new \CodeCollab\Encryption\Defuse\Decryptor($key))->decrypt($encryptedData);

Using your current key. For newly encrypted data create a new and separate key.

### Exceptions

This library may emit two different exceptions:

- `\CodeCollab\Encryption\CryptoException`
- `\CodeCollab\Encryption\FraudException`
 
It is important to properly handle these exceptions in your applications.

#### `CryptoException`

This exception gets thrown when a key could not be generated or when a message could not be en- / decrypted because of system errors.

#### `FraudException`

This exception gets thrown when there has been suspected tampering with messages. This exception should be handled like the message has been tampered with and precautions should be taken.

## Upgrading

When upgrading from from v1* to v2* of this library there are breaking changes.

It's not possible anymore to generate a new key or encrypt data using the obsolete `CodeCollab\Encryption\Defuse\Key` and `CodeCollab\Encryption\Defuse\Encrypt` classes.

The `CodeCollab\Encryption\Defuse` package has been superseded by the ``CodeCollab\Encryption\Defusev2` package.

Decrypting of data is still possible using the deprecated `CodeCollab\Encryption\Defuse\Decrypt::decrypt()` method and will be for the foreseeable future.

It is however *strongly* advised to re-encrypt old data using the new `CodeCollab\Encryption\Defusev2` package.

The workflow for this will be:

- Generate a new key using the new `CodeCollab\Encryption\Defusev2\Key::generate()` method (**But don't overwrite the current key yet!**)
- Decrypt the data using the current key and the `CodeCollab\Encryption\Defuse\Decrypt::decrypt()` method
- Encrypt the data using the new `CodeCollab\Encryption\Defusev2\Encrypt::encrypt()` method with the newly generate key
- Newly encrypted data can now be decrypted using the new `CodeCollab\Encryption\Defusev2\Decrypt::decrypt()` method

## Contributing

[How to contribute][contributing]

## License

[MIT][mit]

[contributing]: https://github.com/CodeCollab/Encryption/blob/master/CONTRIBUTING.md
[mit]: http://spdx.org/licenses/MIT

## Security issues

If you found a security issue please contact directly by mail instead of using the issue tracker at codecollab-security@pieterhordijk.com
