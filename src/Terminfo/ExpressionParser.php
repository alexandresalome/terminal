<?php


namespace Terminal\Terminfo;

class ExpressionParser
{
    private ?string $expression = null;
    private ?int $offset = null;

    public function evaluate(string $expression, array $parameters): string
    {
        $this->expression = $expression;
        $this->offset = 0;

        $stack = [];
        $length = strlen($this->expression);
        $output = '';

        while ($this->offset < $length) {
            if ($this->expression[$this->offset] !== '%') {
                $subOffset = strpos($this->expression, '%', $this->offset);
                $output .= substr($this->expression, $this->offset, $subOffset === false ? null : $subOffset - $this->offset);
                if ($subOffset === false) {
                    break;
                }

                $this->offset = $subOffset;

                continue;
            }

            $type = $this->expression[$this->offset + 1];

            /* Can be used to debug
            dump(sprintf(
                "%-4d | %s | %s | %s%s | %s",
                $this->offset,
                $type,
                json_encode($this->stack),
                str_repeat('-', $this->offset),
                substr($this->expression, $this->offset),
                $this->output
            ));
            */

            if ($type === '?' || $type === ';') {
                $this->offset += 2;

                continue;
            }

            if ($type === 'i') {
                $parameters[0]++;
                $parameters[1]++;
                $this->offset += 2;

                continue;
            }

            if ($type === 't') {
                $value = array_pop($stack);
                if (!$value) {
                    $this->jumpTo('%e');
                }

                $this->offset += 2;

                continue;
            }

            if ($type === '<' || $type === '-' || $type === '+' || $type === '/' || $type === 'm') {
                $left = array_pop($stack);
                $right = array_pop($stack);
                $stack[] = match ($type) {
                    '<' => $left < $right,
                    '-' => $left - $right,
                    '+' => $left + $right,
                    '/' => $left / $right,
                    'm' => $left % $right,
                } ? 1 : 0;

                $this->offset += 2;

                continue;
            }

            if ($type === 'p') {
                $number = $this->expression[$this->offset + 2] - 1;
                $stack[] = $parameters[$number];
                $this->offset += 3;

                continue;
            }

            if ($type === '{') {
                $subOffset = strpos($this->expression, '}', $this->offset);
                $number = substr($this->expression, $this->offset + 2, $subOffset === false ? null : $subOffset - $this->offset - 2);
                $stack[] = (int) $number;
                $this->offset = $subOffset + 1;

                continue;
            }

            if ($type === 'd') {
                $output .= array_pop($stack);

                $this->offset += 2;

                continue;
            }

            if ($type === 'e') {
                $this->jumpAfter('%;');

                continue;
            }

            throw new \RuntimeException(sprintf('Unknown operation "%%%s".', $type));
        }

        return $output;
    }

    private function jumpAfter(string $string): void
    {
        $this->jumpTo($string);
        $this->offset += strlen($string);
    }

    private function jumpTo(string $string): void
    {
        $newOffset = strpos($this->expression, '%e', $this->offset);

        if (false === $newOffset) {
            throw new \RuntimeException(sprintf('The string "%s" was not found.', $string));
        }

        $this->offset = $newOffset;
    }
}
