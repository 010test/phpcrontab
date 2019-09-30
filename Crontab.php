<?php
/**
 * Created by PhpStorm.
 * User: yhm
 * Date: 19-9-29
 * Time: 下午4:51
 */

/**
 * Class Crontab
 * description: 使用 php 实现类似 linux crontab 的定时任务功能，支持秒级定时
 * author: yhm.1234@163.com
 */
class Crontab {

    /**
     * 判断某个时间点是否在 cron 规则之内
     * @param string $cron 规则字符串,示例: "秒 分 时 日 月 周",规则类似 linux crontab 写法
     * @param int $time
     * @return bool
     */
    public static function parse($cron, $time) {
        $cronArray = self::getCronArray($cron);

        $now = explode(' ', date('s i G j n w', $time));

        foreach ($now as $key => $piece) {
            if (!in_array($piece, $cronArray[$key])) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param $cron
     * @return array
     */
    private static function getCronArray($cron) {
        $cronArray = explode(' ', $cron);
        $timeArray = [];

        $dimensions = [
            [0, 59], //seconds
            [0, 59], //Minutes
            [0, 23], //Hours
            [1, 31], //Days
            [1, 12], //Months
            [0, 6]  //Weekdays
        ];

        foreach ($cronArray as $key => $item) {
            list($repeat, $every) = explode('/', $item, 2) + [false, 1];
            if ($repeat === '*') {
                $timeArray[$key] = range($dimensions[$key][0], $dimensions[$key][1]);
            } else {
                // 处理逗号拼接的命令
                $tmpRaw = explode(',', $item);
                foreach ($tmpRaw as $tmp) {
                    // 处理10-20这样范围的命令
                    $tmp = explode('-', $tmp, 2);
                    if (count($tmp) == 2) {
                        $timeArray[$key] = array_merge($timeArray[$key], range($tmp[0], $tmp[1]));
                    } else {
                        $timeArray[$key][] = $tmp[0];
                    }
                }
            }
            // 判断*/10 这种类型的
            if ($every > 1) {
                foreach ($timeArray[$key] as $k => $v) {
                    if ($v % $every != 0) {
                        unset($timeArray[$key][$k]);
                    }
                }
            }
        }
        return $timeArray;
    }
}
