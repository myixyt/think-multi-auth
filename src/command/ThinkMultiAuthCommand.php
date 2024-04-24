<?php

namespace app\command;

use Yll\ThinkMultiAuth\Facade\Str;
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\Output;
use think\facade\Cache;


class ThinkMultiAuthCommand extends Command
{
    protected static $defaultName = 'think-multi:auth';
    protected static $defaultDescription = 'think-multi auth';

    /**
     * @return void
     */
    protected function configure()
    {
        $this->addArgument('name', Argument::OPTIONAL, 'Name description');
    }


    protected function execute(Input $input, Output $output)
    {
        $output->writeln('生成jwtKey 开始');
        $key = Str::random(64);
        file_put_contents(base_path() . "/config/auth.php", str_replace(
            "'access_secret_key' => '" . config('auth.jwt.access_secret_key') . "'",
            "'access_secret_key' => '" . $key . "'",
            file_get_contents(base_path() . "/config/auth.php")
        ));
        file_put_contents(base_path() . "/config/auth.php", str_replace(
            "'refresh_secret_key' => '" . config('auth.app.jwt.refresh_secret_key') . "'",
            "'refresh_secret_key' => '" . $key . "'",
            file_get_contents(base_path() . "/config/auth.php")
        ));
        $output->writeln('生成jwtKey 结束' . $key);
    }

}
