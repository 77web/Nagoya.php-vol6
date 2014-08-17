<?php


namespace Nagoya\Util;

use Nagoya\Data\Entry;

class InputParser
{
    /**
     * @param string $inputs
     * @return Entry[]
     */
    public function convertToEntries($inputs)
    {
        $entries = [];
        foreach (explode('|', $inputs) as $order => $input) {
            list($entryId, $requests) = explode('_', $input);
            $entry = new Entry($entryId, $order);
            $entry->setClassDayRequests($this->convertRequests($requests));

            $entries[] = $entry;
        }

        return $entries;
    }

    /**
     * @param string $requests
     * @return array
     */
    private function convertRequests($requests)
    {
        $days = [];
        for ($i = 0; $i < strlen($requests); $i++) {
            $days[] = intval($requests[$i]);
        }

        return $days;
    }
}
