<?php
    /**
     * Validates input format against parameter.
     *
     * @param $d Input data
     * @param array $t Exepected format
     */
    function validateEntry($d,?array $t=null) {
        $result = false;
        switch ($t['type'] ?? null) {

            case 'preselection':
                if (in_array($d, $d['options'])) {
                    $result = $d;
                }

                break;
            case 'date':
                if (strtotime($d)) {
                    $result = $d;
                }

                break;
            case 'integer':
                $result = intval($d);
                if (in_array('positive', $t['options']) && ($result < 0)) {
                    $result = false;
                }

                break;
            case 'float':
                $result = floatval($d);
                if (in_array('positive', $t['options']) && ($result < 0)) {
                    $result = false;
                }

                break;
            default:
                $result = htmlspecialchars($d);
                break;
        }

        return $result;
    }

    /**
     * Validates whole form / input with expected format
     *
     * @param array $d Input
     * @param array $t Format data
     * @return array|bool Parsed data or false
     */
    function validateObject($d, $t) {
        $r = array();

        foreach ($t as $i => $v) {

            if (isset($d[$i])) {
                $v = validateEntry($d[$i], $v);
                if (false !== $v) {
                    $r = array_merge($r, [$i => $v]);
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        return $r;
    }
?>