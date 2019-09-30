<?php
/**
 * Created by PhpStorm.
 * User: yhm
 * Date: 19-9-29
 * Time: 下午4:53
 */

include 'Crontab.php';

$cron_list = [
    ['cron' => '0 */1 * * * *', 'echo' => '第一个任务执行了'],
    ['cron' => '0 */2 * * * *', 'echo' => 'www.phpernote.com'],
    ['cron' => '20 */3 * * * *', 'echo' => '第三个任务执行了'],
    ['cron' => '5 */5 * * * *', 'echo' => '第四个任务执行了'],
    ['cron' => '0 41 16 29 * *', 'echo' => '第5个任务执行了']
];

echo date('Y-m-d H:i:s', time()) . "\r\n";
while (true) {
    $time = time();
    foreach ($cron_list as &$cron) {
        $result = Crontab::parse($cron['cron'], $time);
        if ($result) {
            echo date('Y-m-d H:i:s', $time) . ' ' . $cron['cron'] . ' ' . $cron['echo'] . "\r\n";
        }
    }
    //echo date('Y-m-d H:i:s', $time) . "\r\n";
    sleep(1);
}
