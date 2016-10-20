<?php

namespace PeacefulBit\LispMachine\VM\Core\Math;

use function PeacefulBit\LispMachine\VM\evaluateExpression;
use PeacefulBit\LispMachine\VM\VMException;

function export()
{
    return [
        '+' => function ($env, array $arguments) {
            return array_reduce($arguments, function ($result, $argument) use ($env) {
                return $result + evaluateExpression($env, $argument);
            }, 0);
        },
        '*' => function ($env, array $arguments) {
            return array_reduce($arguments, function ($result, $argument) use ($env) {
                return $result * evaluateExpression($env, $argument);
            }, 1);
        },
        '-' => function ($env, array $arguments) {
            if (sizeof($arguments) == 0) {
                throw new VMException("Too few arguments");
            }
            $first = $arguments[0];
            $rest = array_slice($arguments, 1);
            if (sizeof($arguments) == 1) {
                return -evaluateExpression($env, $first);
            }
            return array_reduce($rest, function ($result, $argument) use ($env) {
                return $result - evaluateExpression($env, $argument);
            }, evaluateExpression($env, $first));
        },
        '/' => function ($env, array $args) {
            if (sizeof($args) == 0) {
                throw new VMException("Too few arguments");
            }
            $first = $args[0];
            $rest = array_slice($args, 1);
            if (sizeof($args) == 1) {
                return 1 / evaluateExpression($env, $first);
            }
            return array_reduce($rest, function ($result, $argument) use ($env) {
                return $result / evaluateExpression($env, $argument);
            }, evaluateExpression($env, $first));
        }
    ];
}