<?php

namespace Utils;

class Utils
{
  static function randomString(
    string $length,
    string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
  ): string {
    if ($length < 1) {
      throw new \RangeException("Length must be a positive integer");
    }
    return substr(str_shuffle(str_repeat($keyspace, ceil($length / strlen($keyspace)))), 1, $length);
  }
}
