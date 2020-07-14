<?php
/**
 * Copyright 2020 The WildPHP Team
 *
 * You should have received a copy of the MIT license with the project.
 * See the LICENSE file for more information.
 */

declare(strict_types=1);

namespace WildPHP\Core\Events;

class EventEmitter extends \Evenement\EventEmitter
{
    /**
     * Puts a listener first in the listener array.
     *
     * @param string $event
     * @param callable $listener
     *
     * @return $this
     */
    public function first(string $event, callable $listener): self
    {
        if (!isset($this->listeners[$event])) {
            $this->listeners[$event] = [];
        }

        array_unshift($this->listeners[$event], $listener);

        return $this;
    }
}
