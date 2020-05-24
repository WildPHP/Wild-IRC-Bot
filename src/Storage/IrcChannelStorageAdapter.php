<?php
/**
 * Copyright 2019 The WildPHP Team
 *
 * You should have received a copy of the MIT license with the project.
 * See the LICENSE file for more information.
 */

declare(strict_types=1);

namespace WildPHP\Core\Storage;

use WildPHP\Core\Entities\IrcChannel;

class IrcChannelStorageAdapter
{
    /**
     * @param IrcChannel $channel
     * @return StoredEntity
     */
    public static function convertToStoredEntity(IrcChannel $channel): StoredEntity
    {
        return new StoredEntity($channel->toArray(), $channel->channelId);
    }

    /**
     * @param StoredEntityInterface $entity
     * @return IrcChannel
     */
    public static function convertToIrcChannel(StoredEntityInterface $entity): IrcChannel
    {
        return new IrcChannel($entity->getData());
    }
}
