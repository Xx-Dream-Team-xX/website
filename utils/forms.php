<?php

    /**
     * Validates input format against parameter.
     *
     * @param $d Input data
     * @param array $t Exepected format
     */
    function validateEntry($d, ?array $t = null) {
        $result = false;
        switch ($t['type'] ?? null) {

            case 'preselection':
                if (in_array($d, $t['options'])) {
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
            case 'phone':
                if (preg_match('/^[+][0-9]/', $d)) {
                    $count = 1;
                    $d = str_replace(array('+'), '', $d, $count);
                }
                $result = str_replace(array(' ', '.', '-', '(', ')'), '', $d);

                if (!preg_match('/^[0-9]{9,14}\z/', $d)) {
                    $result = false;
                }

                break;
            case 'email':
                $result = User::checkEmail($d);

                // no break
            case 'zipcode':
                if (preg_match('/(?:0[1-9]|[13-8][0-9]|2[ab1-9]|9[0-5])(?:[0-9]{3})?|9[78][1-9](?:[0-9]{2})?/', $d)) {
                    $result = $d;
                }

                break;
            default:
                $result = htmlspecialchars($d);

                break;
        }

        return $result;
    }

    /**
     * Validates whole form / input with expected format.
     *
     * @param array $d Input
     * @param array $t Format data
     *
     * @return array|bool Parsed data or false
     */
    function validateObject($d, $t) {
        $r = array();

        foreach ($t as $i => $v) {
            if (isset($d[$i])) {
                $v = validateEntry($d[$i], $v);
                if (false !== $v) {
                    $r = array_merge($r, array($i => $v));
                }
            } elseif (!isset($v['optional']) || !$v['optional']) {
                return false;
            }
        }

        return $r;
    }
?>
