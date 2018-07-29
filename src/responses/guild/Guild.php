<?php

namespace Plancke\HypixelPHP\responses\guild;

use Plancke\HypixelPHP\cache\CacheTimes;
use Plancke\HypixelPHP\classes\HypixelObject;
use Plancke\HypixelPHP\color\ColorUtils;
use Plancke\HypixelPHP\HypixelPHP;

class Guild extends HypixelObject {

    protected $ranks;
    protected $members;

    /**
     * @param HypixelPHP $HypixelPHP
     * @param $guild
     */
    public function __construct(HypixelPHP $HypixelPHP, $guild) {
        parent::__construct($HypixelPHP, $guild);

        $this->ranks = new GuildRanks($HypixelPHP, $this->getArray("ranks"));
        $this->members = new GuildMemberList($this->getHypixelPHP(), $this);
    }

    /**
     * @param null $cached
     * @throws \Plancke\HypixelPHP\exceptions\HypixelPHPException
     */
    public function handleNew($cached = null) {
        parent::handleNew($cached);

        $extraSetter = [];
        $extraSetter['name_lower'] = strtolower($this->getName());

        $this->setExtra($extraSetter, false);
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->get('name');
    }

    /**
     * @return GuildRanks
     */
    public function getRanks() {
        return $this->ranks;
    }

    /**
     * @return string
     */
    public function getTag() {
        return $this->get('tag');
    }

    /**
     * @return string
     */
    public function getTagColor() {
        $color = $this->get('tagColor', 'GRAY');
        if (isset(ColorUtils::NAME_TO_CODE[$color])) {
            return ColorUtils::NAME_TO_CODE[$color];
        }
        return ColorUtils::GRAY;
    }

    /**
     * @return int
     */
    public function getMemberCount() {
        return $this->getMemberList()->getMemberCount();
    }

    /**
     * @return GuildMemberList
     */
    public function getMemberList() {
        return $this->members;
    }

    /**
     * @return string
     */
    function getCacheTimeKey() {
        return CacheTimes::GUILD;
    }

    /**
     * @return int
     */
    public function getLevel() {
        return GuildLevelUtil::getLevel($this->getExp());
    }

    /**
     * @return int
     */
    public function getExp() {
        return $this->getInt('exp');
    }

    /**
     * @return array
     */
    public function getAchievements() {
        return $this->getArray("achievements");
    }

    /**
     * @return bool
     */
    public function isJoinable() {
        return $this->get('joinable', false);
    }

    /**
     * @return bool
     */
    public function isPubliclyListed() {
        return $this->get('publiclyListed', false);
    }

    /**
     * @return int
     */
    public function getLegacyRank() {
        return $this->getInt('legacyRanking');
    }

    /**
     * @return string
     */
    public function getDiscord() {
        return $this->get("discord");
    }

    /**
     * @return string
     */
    public function getDescription() {
        return $this->get("description");
    }

    /**
     * @return array
     */
    public function getPreferredGames() {
        return $this->get("preferredGames");
    }

    /**
     * @return int
     */
    public function getChatThrottle() {
        return $this->getInt('chatThrottle');
    }

    /**
     * @return array
     */
    public function getBanner() {
        return $this->getArray("banner");
    }
}