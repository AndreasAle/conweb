<?php

namespace App\Support;

/**
 * Simulated domain availability checker (no registrar API connected yet).
 * Deterministic per name+tld so repeated searches stay consistent within a session.
 * Swap the body of isAvailable() for a real registrar API call when one is available.
 */
class DomainAvailability
{
    public static function isAvailable(string $name, string $tld): bool
    {
        $hash = crc32(strtolower(trim($name)).$tld);

        return ($hash % 100) < 70;
    }
}
