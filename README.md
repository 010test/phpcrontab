# phpcrontab

###使用 php 实现类似 linux crontab 的定时任务功能，支持秒级定时

####程序示例代码：

```php
<?php

$cron_list = [
    //['cron' => '秒 分 时 日 月 周', 'echo' => 'hello world'],
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
        $result = Crontab::parseCron($cron['cron'], $time);
        if ($result) {
            echo date('Y-m-d H:i:s', $time) . ' ' . $cron['cron'] . ' ' . $cron['echo'] . "\r\n";
        }
    }
    //echo date('Y-m-d H:i:s', $time) . "\r\n";
    sleep(1);
}
```

####输出结果如下：
![avatar](http://image.phpernote.com/phpcrontab.png)