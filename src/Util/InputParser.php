<?php


namespace Nagoya\Util;

use Nagoya\Data\Staff;

class InputParser
{
    /**
     * @param string $inputs
     * @return Staff[]
     */
    public function convertToStaffs($inputs)
    {
        $staffs = [];
        foreach (explode('|', $inputs) as $input) {
            list($id, $requests) = explode('_', $input);
            $staff = new Staff($id);
            $staff->setClassDayRequests($this->convertRequests($requests));

            $staffs[] = $staff;
        }

        return $staffs;
    }

    /**
     * @param string $requests
     * @return array
     */
    private function convertRequests($requests)
    {
        $days = [];
        for ($i = 0; $i < strlen($requests); $i++) {
            $days[] = $requests[$i];
        }

        return $days;
    }
}
