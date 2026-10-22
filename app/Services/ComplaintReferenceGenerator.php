<?php

namespace App\Services;

use Illuminate\Database\QueryException;

class ComplaintReferenceGenerator
{
    private const ALPHABET = '23456789ABCDEFGHJKMNPQRSTUVWXYZ';

    public function generate()
    {
        $characters = '';
        $last = strlen(self::ALPHABET) - 1;
        for ($index = 0; $index < 12; $index++) {
            $characters .= self::ALPHABET[random_int(0, $last)];
        }

        return 'C-' . implode('-', str_split($characters, 4));
    }

    public function isSupported($reference)
    {
        return is_string($reference) && (bool) preg_match(
            '/\A(?:C-[A-F0-9]{40}|C-[23456789ABCDEFGHJKMNPQRSTUVWXYZ]{4}(?:-[23456789ABCDEFGHJKMNPQRSTUVWXYZ]{4}){2})\z/',
            $reference
        );
    }

    public function issue(callable $persist, $uniqueColumns)
    {
        $uniqueColumns = (array) $uniqueColumns;
        for ($attempt = 0; $attempt < 3; $attempt++) {
            $reference = $this->generate();
            try {
                return [$persist($reference), $reference];
            } catch (QueryException $exception) {
                $message = strtolower((string) ($exception->errorInfo[2] ?? ''));
                $code = (int) ($exception->errorInfo[1] ?? 0);
                $referenceCollision = false;
                foreach ($uniqueColumns as $column) {
                    if (strpos($message, $column) !== false) {
                        $referenceCollision = true;
                        break;
                    }
                }
                if (!in_array($code, [19, 1062], true) || !$referenceCollision) {
                    throw $exception;
                }
            }
        }

        throw new \RuntimeException('Could not issue a unique complaint reference.');
    }
}
