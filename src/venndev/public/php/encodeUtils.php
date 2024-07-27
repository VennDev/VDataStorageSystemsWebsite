<?php

// You can use any hash function here
function encodeData(string $data, bool $hashData): string
{
    if ($hashData === true) {
        return base64_encode(gzcompress($data));
    }
    return $data;
}

// You can use any hash function here
function decodeData(string $data, bool $hashData): string
{
    if ($hashData === true) {
        return gzuncompress(base64_decode($data));
    }
    return $data;
}