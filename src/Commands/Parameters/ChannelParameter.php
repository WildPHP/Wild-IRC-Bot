<?php
/**
 * Copyright 2020 The WildPHP Team
 *
 * You should have received a copy of the MIT license with the project.
 * See the LICENSE file for more information.
 */

declare(strict_types=1);

namespace WildPHP\Core\Commands\Parameters;

use WildPHP\Commands\Parameters\ConvertibleParameterInterface;
use WildPHP\Commands\Parameters\Parameter;
use WildPHP\Core\Storage\IrcChannelStorageInterface;

/**
 * Class ChannelParameter
 *
 * @package WildPHP\Core\Commands\Parameters
 */
class ChannelParameter extends Parameter implements ConvertibleParameterInterface
{
    /**
     * @var IrcChannelStorageInterface
     */
    private $channelStorage;

    /**
     * ChannelParameter constructor.
     * @param IrcChannelStorageInterface $channelStorage
     */
    public function __construct(IrcChannelStorageInterface $channelStorage)
    {
        parent::__construct(static function (string $value) use ($channelStorage) {
            return $channelStorage->getOneByName($value) !== null;
        });

        $this->channelStorage = $channelStorage;
    }

    public function convert(string $input)
    {
        $channel = $this->channelStorage->getOneByName($input);

        if ($channel === null) {
            return false;
        }

        return $channel;
    }
}
