<?php

namespace Terminal\Capability;

trait Color
{
    private static array $color8 = ['black' => 0, 'red' => 1, 'green' => 2, 'yellow' => 3, 'blue' => 4, 'magenta' => 5, 'cyan' => 6, 'white' => 7];

    public function hasColor(): bool
    {
        return $this->configuration->hasAll(['set_a_foreground', 'set_a_background']);
    }

    public function setColor(?string $foreground, ?string $background = null): void
    {
        if ($foreground !== null) {
            $this->setForegroundColor($foreground);
        }

        if ($background !== null) {
            $this->setBackgroundColor($background);
        }
    }

    public function setForegroundColor(string $color): void
    {
        if (!$this->configuration->has('set_a_foreground')) {
            throw new \RuntimeException('Foreground color is unavailable.');
        }

        if (!isset(self::$color8[$color])) {
            throw new \RuntimeException(sprintf(
                'No color named "%s" was found. Available are: "%s".',
                $color,
                implode('", "', array_keys(self::$color8))
            ));
        }

        $this->output->write(
            $this->configuration->getParameterized(
                'set_a_foreground',
                [self::$color8[$color]]
            )
        );
    }

    public function setBackgroundColor(string $color): void
    {
        if (!$this->configuration->has('set_a_background')) {
            throw new \RuntimeException('Background color is unavailable.');
        }

        if (!isset(self::$color8[$color])) {
            throw new \RuntimeException(sprintf(
                'No color named "%s" was found. Available are: "%s".',
                $color,
                implode('", "', array_keys(self::$color8))
            ));
        }

        $this->output->write(
            $this->configuration->getParameterized(
                'set_a_background',
                [self::$color8[$color]]
            )
        );
    }

    public function resetColor(): void
    {
        $this->output->write($this->configuration->get('orig_pair'));
    }
}
