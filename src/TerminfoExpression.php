<?php


namespace Terminal;


class TerminfoExpression
{
    private ?string $expression = null;
    private ?array $parameters = null;
    private ?array $stack = null;
    private ?int $offset = null;
    private ?int $length = null;
    private ?string $output = null;

    public function evaluate(string $expression, array $parameters): string
    {
        $this->expression = $expression;
        $this->parameters = $parameters;
        $this->stack = [];
        $this->offset = 0;
        $this->length = strlen($this->expression);
        $this->output = '';

        while ($this->offset < $this->length) {
            if ($this->expression[$this->offset] !== '%') {
                $subOffset = strpos($this->expression, '%', $this->offset);
                $this->output .= substr($this->expression, $this->offset, $subOffset === false ? null : $subOffset - $this->offset);
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
                $this->parameters[0]++;
                $this->parameters[1]++;
                $this->offset += 2;

                continue;
            }

            if ($type === 't') {
                $value = array_pop($this->stack);
                if (!$value) {
                    $this->jumpTo('%e');
                }

                $this->offset += 2;

                continue;
            }

            if ($type === '<' || $type === '-') {
                $left = array_pop($this->stack);
                $right = array_pop($this->stack);
                $this->stack[] = match ($type) {
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
                $this->stack[] = $this->parameters[$number];
                $this->offset += 3;

                continue;
            }

            if ($type === '{') {
                $subOffset = strpos($this->expression, '}', $this->offset);
                $number = substr($this->expression, $this->offset + 2, $subOffset === false ? null : $subOffset - $this->offset - 2);
                $this->stack[] = (int) $number;
                $this->offset = $subOffset + 1;

                continue;
            }

            if ($type === 'd') {
                $this->output .= array_pop($this->stack);

                $this->offset += 2;

                continue;
            }

            if ($type === 'e') {
                $this->jumpAfter('%;');

                continue;
            }

            throw new \RuntimeException(sprintf('Unknown operation "%%%s".', $type));
        }

        return $this->output;
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
