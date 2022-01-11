<?php

namespace App\Console\Commands;

use App\Models\PluginAccount;
use App\Models\PluginBullionLog;
use App\Models\PluginEquipment;
use App\Models\PluginMeatLog;
use App\Models\PluginWoodLog;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DetectGameState extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game:detect';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Detect Game Status';

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
        $oneHourBefore = date('Y-m-d H:i:s', strtotime('-1 Hours') - 60);
        $fourHourBefore = date('Y-m-d H:i:s', strtotime('-4 Hours') - 60);
        $accounts = PluginAccount::whereState(1)
            ->whereScriptState(2)
            ->where('start_date', '<=', $oneHourBefore)
            ->get();
        foreach ($accounts as $account) {
            $hourBefore = PluginEquipment::whereAccountId($account->account_id)->whereMapIndex(0)->count() === 0 ? $fourHourBefore : $oneHourBefore;
            if ($this->detect($account, 'wood', $hourBefore)) continue;
            if ($this->detect($account, 'meat', $hourBefore)) continue;
            if ($this->detect($account, 'bullion', $hourBefore)) continue;
            $account->game_state = 1;
            $account->save();
        }
        var_dump($oneHourBefore . ':success,' . Carbon::now());
        return true;
    }

    protected function detect(PluginAccount $account, $table, $hourBefore): bool
    {
        switch ($table) {
            case 'bullion':
                $tableModel = new PluginBullionLog();
                break;
            case 'wood':
                $tableModel = new PluginWoodLog();
                break;
            case 'meat':
                $tableModel = new PluginMeatLog();
                break;
            default:
                return false;
        }
        if ($tableModel->whereAccountId($account->account_id)
                ->where('created_at', '>=', $hourBefore)
                ->count() === 0) return false;
        $account->game_state = 0;
        $account->save();
        return true;

    }
}
