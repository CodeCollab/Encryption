# Encryption

Encryption package of the CodeCollab project

[![Build Status](https://travis-ci.org/CodeCollab/Encryption.svg?branch=master)](https://travis-ci.org/CodeCollab/Encryption) [![MIT License](https://img.shields.io/badge/license-MIT-blue.svg)](mit) [![Latest Stable Version](https://poser.pugx.org/codecollab/encryption/v/stable)](https://packagist.org/packages/codecollab/encryption) [![Total Downloads](https://poser.pugx.org/codecollab/encryption/downloads)](https://packagist.org/packages/codecollab/encryption) [![Latest Unstable Version](https://poser.pugx.org/codecollab/encryption/v/unstable)](https://packagist.org/packages/codecollab/encryption)

## Requirements

PHP7+

## Installation

Include the library in your project using composer:

    {
        "require-dev": {
            "codecollab/encryption": "1.0.*"
        }
    }

## Usage

This library provides a common interfaces and exceptions for handling crypto in your applications.

At the moment this library is just a wrapper around [defuse/php-encryption](https://github.com/defuse/php-encryption), but other crypto libraries will be included later.

### Generating key

Before being able to encrypt/decrypt data a key needs to be generated / added. To generate a new key use:

    $key = (new \CodeCollab\Encryption\Defuse\Key())->generate();
    
*Note: keys should always be stored in a secure location and should never be made public.*

*Note: all key share the common `CodeCollab\Encryption\Key` interface.*

### Encrypting

    $encryptedData = (new \CodeCollab\Encryption\Defuse\Encryptor($key))->encrypt('the data to encrypt');
    
*Note: all key share the common `CodeCollab\Encryption\Encryptor` interface.*

### Decrypting

    $decryptedData = (new \CodeCollab\Encryption\Defuse\Decryptor($key))->decrypt($encryptedData);
    
*Note: all key share the common `CodeCollab\Encryption\Decryptor` interface.*    

## Contributing

[How to contribute][contributing]

## License

[MIT][mit]

[contributing]: https://github.com/CodeCollab/Encryption/blob/master/CONTRIBUTING.md
[mit]: http://spdx.org/licenses/MIT
