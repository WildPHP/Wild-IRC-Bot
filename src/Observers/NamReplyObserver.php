<?php
/**
 * Copyright 2019 The WildPHP Team
 *
 * You should have received a copy of the MIT license with the project.
 * See the LICENSE file for more information.
 */

declare(strict_types=1);

namespace WildPHP\Core\Observers;

use Evenement\EventEmitterInterface;
use Psr\Log\LoggerInterface;
use WildPHP\Core\Connection\UserModeParser;
use WildPHP\Core\Events\IncomingIrcMessageEvent;
use WildPHP\Core\Storage\IrcChannelStorageInterface;
use WildPHP\Core\Storage\IrcUserChannelRelationStorageInterface;
use WildPHP\Core\Storage\IrcUserStorageInterface;
use WildPHP\Messages\RPL\NamReply;

class NamReplyObserver
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var IrcChannelStorageInterface
     */
    private $channelStorage;

    /**
     * @var IrcUserStorageInterface
     */
    private $userStorage;
    /**
     * @var IrcUserChannelRelationStorageInterface
     */
    private $relationStorage;

    /**
     * BaseModule constructor.
     *
     * @param EventEmitterInterface $eventEmitter
     * @param LoggerInterface $logger
     * @param IrcChannelStorageInterface $channelStorage
     * @param IrcUserStorageInterface $userStorage
     * @param IrcUserChannelRelationStorageInterface $relationStorage
     */
    public function __construct(
        EventEmitterInterface $eventEmitter,
        LoggerInterface $logger,
        IrcChannelStorageInterface $channelStorage,
        IrcUserStorageInterface $userStorage,
        IrcUserChannelRelationStorageInterface $relationStorage
    ) {
        // 353: RPL_NAMREPLY
        $eventEmitter->on('irc.line.in.353', [$this, 'processNamesReply']);

        $this->logger = $logger;
        $this->channelStorage = $channelStorage;
        $this->userStorage = $userStorage;
        $this->relationStorage = $relationStorage;
    }

    /**
     * @param IncomingIrcMessageEvent $ircMessageEvent
     */
    public function processNamesReply(IncomingIrcMessageEvent $ircMessageEvent): void
    {
        /** @var NamReply $ircMessage */
        $ircMessage = $ircMessageEvent->getIncomingMessage();
        $nicknames = $ircMessage->getNicknames();

        $channel = $this->channelStorage->getOrCreateOneByName($ircMessage->getChannel());

        foreach ($nicknames as $nicknameWithMode) {
            $nickname = '';
            $modes = UserModeParser::extractFromNickname($nicknameWithMode, $nickname);
            $user = $this->userStorage->getOrCreateOneByNickname($nickname);

            $relation = $this->relationStorage->getOrCreateOne(
                $user->getUserId(),
                $channel->getChannelId(),
                $modes
            );

            $this->logger->debug('Creating user-channel relationship', [
                'reason' => 'rpl_namreply',
                'userID' => $relation->getIrcUserId(),
                'nickname' => $user->getNickname(),
                'channelID' => $relation->getIrcChannelId(),
                'channel' => $channel->getName()
            ]);
        }
    }
}