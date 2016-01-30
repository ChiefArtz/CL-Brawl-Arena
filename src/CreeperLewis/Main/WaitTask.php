<?php
namespace CreeperLewis\Main;
use pocketmine\level\Position;
use pocketmine\scheduler\PluginTask;
use pocketmine\utils\TextFormat;
class WaitTask extends PluginTask{
    private $pl;
    public function __construct(BrawlPvP $Pl){
        parent::__construct($Pl);
        $this->pl = $Pl;
    }
    public function onRun($currentTick)
    {
        if(count($this->pl->brawl) <= 0){
            $this->pl->getServer()->getScheduler()->cancelTask($this->getTaskId());
            $this->pl->running = false;
            unset($this->pl->brawl);
            unset($this->pl->cnt);
        }
        foreach($this->pl->brawl as $pl){
            $this->pl->createGameTask();
            $this->pl->getServer()->getScheduler()->cancelTask($this->getTaskId());
            $pl->teleport(new Position($this->pl->gx,$this->pl->gy,$this->pl->gz,$this->pl->glvl),0,0);
            $pl->sendMessage(TextFormat::GREEN."------------------------------------------\n".TextFormat::GOLD."[CL-BrawlArena] Game started, get as much kills as possible.\n".TextFormat::GREEN."------------------------------------------");
            break;
        }
    }
}
