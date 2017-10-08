<?php

namespace EdipoReboucas\KohanaPhpDi\Cache;

use Doctrine\Common\Cache\CacheProvider;

class Wrapper extends CacheProvider
{
    /**
     * @var \Cache
     */
    private $cache;

    public function __construct(\Cache $cache)
    {
        $this->cache = $cache;
    }

    public function doFetch($id)
    {
        $unserializedData = unserialize($this->cache->get($id));
        return $unserializedData;
    }

    public function doContains($id)
    {
        /**
         * Kohana cache not has a contains implementations, but PHP-DI not use this
         */
        return (bool)$this->cache->get($id, null);
    }

    public function doSave($id, $data, $lifeTime = 0)
    {
        $serializedData = serialize($data);
        return $this->cache->set($id, $serializedData, $lifeTime);
    }

    public function doDelete($id)
    {
        return $this->cache->delete($id);
    }

    public function doFlush()
    {
        return $this->cache->delete_all();
    }

    public function doGetStats()
    {
        return null;
    }
}