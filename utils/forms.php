<?php

use function PHPSTORM_META\type;

    /**
     * Validates input format against parameter.
     *
     * @param $d Input data
     * @param array $t Exepected format
     *
     * @return mixed Parsed and formated data
     */
    function validateEntry($d, ?array $t = null) {
        $result = false;
        switch ($t['type'] ?? null) {

            case 'preselection':
                $result = $d;
                if (!in_array($d, $t['options'])) {
                    throw new Exception('not in selection', 1);
                }

                break;
            case 'date':
                $result = strtotime($d);
                if (!$result || ('int' == type($result))) {
                    $result = $d;
                } else {
                    throw new Exception('invalid date', 1);
                }

                break;
            case 'bool':
                $result = boolval($d);

                break;
            case 'integer':
                $result = intval($d);
                if (in_array('positive', $t['options']) && ($result < 0)) {
                    throw new Exception('invalid integer', 1);
                }

                break;
            case 'float':
                $result = floatval($d);
                if (in_array('positive', $t['options']) && ($result < 0)) {
                    throw new Exception('invalid float', 1);
                }

                break;
            case 'phone':
                if (preg_match('/^[+][0-9]/', $d)) {
                    $count = 1;
                    $d = str_replace(array('+'), '', $d, $count);
                }
                $result = str_replace(array(' ', '.', '-', '(', ')'), '', $d);

                if (!preg_match('/^[0-9]{9,14}\z/', $d)) {
                    throw new Exception('invalid phone', 1);
                }

                break;
            case 'email':
                $result = $d;
                if (!User::checkEmail($d)) {
                    throw new Exception('invalid email', 1);
                }

                break;
            case 'zipcode':
                $result = $d;
                if (!preg_match('/(?:0[1-9]|[13-8][0-9]|2[ab1-9]|9[0-5])(?:[0-9]{3})?|9[78][1-9](?:[0-9]{2})?/', $d)) {
                    throw new Exception('invalid zipcode', 1);
                }

                break;
            case 'array':
                $result = $d;
                if (empty($d)) {
                    throw new Exception('invalid array', 1);
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
            try {
                if (isset($d[$i])) {
                    $v = validateEntry($d[$i], $v);
                    $r = array_merge($r, array($i => $v));
                } elseif (!isset($v['optional']) || !$v['optional']) {
                    throw new Exception("Missing entry {$i}", 1);
                }
            } catch (Exception $e) {
                throw new Exception("Error while parsing : {$e->getMessage()}", 1);
            }
        }

        return $r;
    }
?>
