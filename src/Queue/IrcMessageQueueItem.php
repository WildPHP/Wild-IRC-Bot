<?php
/**
 * Copyright 2019 The WildPHP Team
 *
 * You should have received a copy of the MIT license with the project.
 * See the LICENSE file for more information.
 */

declare(strict_types=1);

namespace WildPHP\Core\Queue;

use React\Promise\Deferred;
use React\Promise\PromiseInterface;
use WildPHP\Messages\Interfaces\OutgoingMessageInterface;

class IrcMessageQueueItem implements QueueItemInterface, CancellableQueueItemInterface
{
    /**
     * @var OutgoingMessageInterface
     */
    protected $outgoingMessage;

    /**
     * @var bool
     */
    protected $cancelled = false;

    /**
     * @var Deferred
     */
    private $deferred;

    /**
     * QueueItem constructor.
     *
     * @param OutgoingMessageInterface $outgoingMessage
     */
    public function __construct(OutgoingMessageInterface $outgoingMessage)
    {
        $this->outgoingMessage = $outgoingMessage;
    }

    /**
     * @return OutgoingMessageInterface
     */
    public function getOutgoingMessage(): OutgoingMessageInterface
    {
        return $this->outgoingMessage;
    }

    /**
     * @return bool
     */
    public function isCancelled(): bool
    {
        return $this->cancelled;
    }

    /**
     * @return void
     */
    public function cancel(): void
    {
        $this->cancelled = true;
    }

    /**
     * @param Deferred $deferred
     */
    public function setDeferred(Deferred $deferred): void
    {
        $this->deferred = $deferred;
    }

    /**
     * @return PromiseInterface
     */
    public function getPromise(): PromiseInterface
    {
        return $this->deferred->promise();
    }

    /**
     * @return Deferred
     */
    public function getDeferred(): Deferred
    {
        return $this->deferred;
    }
}
