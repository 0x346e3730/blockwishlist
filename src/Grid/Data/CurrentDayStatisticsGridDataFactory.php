<?php

namespace PrestaShop\Module\BlockWishList\Grid\Data;

use PrestaShop\PrestaShop\Core\Grid\Data\Factory\GridDataFactoryInterface;
use PrestaShop\PrestaShop\Core\Grid\Data\GridData;
use PrestaShop\PrestaShop\Core\Grid\Record\RecordCollection;
use PrestaShop\PrestaShop\Core\Grid\Search\SearchCriteriaInterface;

class CurrentDayStatisticsGridDataFactory extends BaseGridDataFactory implements GridDataFactoryInterface
{
    // 1 day
    const CACHE_LIFETIME_SECONDS = 86400;

    public function getData(SearchCriteriaInterface $searchCriteria)
    {
        $shop_id = current($this->listShopId);
        if ($this->cache->contains(self::CACHE_KEY_STATS_CURRENT_DAY . $shop_id)) {
            $results = $this->cache->fetch(self::CACHE_KEY_STATS_CURRENT_DAY . $shop_id);
        } else {
            $results = $this->calculator->computeStatsFor('currentDay');
            $this->cache->save(self::CACHE_KEY_STATS_CURRENT_DAY . $shop_id, $results, self::CACHE_LIFETIME_SECONDS);
        }

        return new GridData(new RecordCollection($results), count($results));
    }
}
