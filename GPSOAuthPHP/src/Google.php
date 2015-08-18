<?php

namespace GPSOAuthPHP;

class Google
{
    const GOOGLE_DEFAULT_PUBLIC_KEY = 'AAAAgMom/1a/v0lblO2Ubrt60J2gcuXSljGFQXgcyZWveWLEwo6prwgi3iJIZdodyhKZQrNWp5nKJ3srRXcUW+F1BD3baEVGcmEgqaLZUNBjm057pKRI16kB0YppeGx5qIQ5QjKzsR8ETQbKLNWgRY0QRNVz34kMJR3P/LgHax/6rmf5AAAAAwEAAQ==';

    public function signature($email, $password)
    {
        $this->key_from_b64(self::GOOGLE_DEFAULT_PUBLIC_KEY);
    }

    private function key_from_b64($b64key)
    {
        $binaryKey = array();
        foreach (str_split(base64_decode($b64key)) as $char) {
            $binaryKey[] = ord($char);
        }
        var_dump($this->readInt($binaryKey, 0));
    }

    private function readInt(array $binaryKey, $i)
    {
        $a = gmp_shiftl($binaryKey[$i    ], 24);
        $b = gmp_shiftl($binaryKey[$i + 1], 16);
        $c = gmp_shiftl($binaryKey[$i + 2], 8);
        return gmp_or(gmp_or(gmp_or($a, $b), $c), $binaryKey[$i + 3]);
    }
}

function gmp_shiftl($number, $bits)
{
    return gmp_mul($number, gmp_pow(2, $bits));
}