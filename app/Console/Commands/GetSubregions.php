<?php

namespace App\Console\Commands;

use App\Subregion;
use Illuminate\Console\Command;

class GetSubregions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gd:parse-subregions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $s = [];
        $fh = fopen('address.log', 'r+');

        while ($line = fgets($fh)) {
            preg_match('/^([0-9.]+) /', $line, $match);
            $ip = @$match[1];
            preg_match('/subregion_id=([0-9]+)&/', $line, $match);
            $subregion_id = @$match[1];
            preg_match('/"?([^"]+)"$/', $line, $match);
            $user_agent = @$match[1];

            if (!isset($s[md5($ip . $subregion_id. $user_agent)])) {
                $subregion = Subregion::find($subregion_id);
                if ($subregion) {
                    $this->info("Subregion: {$subregion->subregion_id},\t Views: {$subregion->gd_views}");
                    $subregion->gd_views++;
                    $subregion->save();
                }
                $s[md5($ip . $subregion_id. $user_agent)] = 'true';
            }

        }
    }
}
