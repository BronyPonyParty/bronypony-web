<?php

namespace App;

class Crypt {
    static public function hash($password, $salt = null) {
        if ($salt == null) $salt = md5(random_bytes(32));

        $hash = hash('sha512', $password.$salt);

        for ($i = 0; $i < pow(2, 16); $i++) {
            $hash = hash('sha512',$hash);
        }

        return [$hash, $salt];
    }

    static public function verify($password, $salt, $hash) {
        list($h) = self::hash($password, $salt);
        return $h == $hash;
    }
}
