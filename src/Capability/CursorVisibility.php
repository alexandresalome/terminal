<?php

namespace Terminal\Capability;

/**
 * The text cursor.
 */
trait CursorVisibility
{
    public function hasCursorVisible(): bool
    {
        return $this->configuration->hasAll(['cursor_visible', 'cursor_invisible']);
    }

    /**
     * Switches the visibility of the text cursor.
     */
    public function cursorVisible(bool $visible = true): void
    {
        if (!$this->hasCursorVisible()) {
            return;
        }

        if ($visible) {
            $this->output->write($this->configuration->get('cursor_visible'));
        } else {
            $this->output->write($this->configuration->get('cursor_invisible'));
        }
    }
}
