<?php
/**
 * Copyright 2020 The WildPHP Team
 *
 * You should have received a copy of the MIT license with the project.
 * See the LICENSE file for more information.
 */

declare(strict_types=1);

namespace WildPHP\Core\Events;

use WildPHP\Messages\Generics\IrcMessage;

class UnsupportedIncomingIrcMessageEvent implements EventInterface
{
    /**
     * @var IrcMessage
     */
    private $ircMessage;

    /**
     * UnsupportedIncomingIrcMessageEvent constructor.
     * @param IrcMessage $ircMessage
     */
    public function __construct(IrcMessage $ircMessage)
    {
        $this->ircMessage = $ircMessage;
    }

    /**
     * @return IrcMessage
     */
    public function getMessage(): IrcMessage
    {
        return $this->ircMessage;
    }
}
