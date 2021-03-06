<?php
namespace CreeperLewis\Main;
use pocketmine\level\Position;
use pocketmine\scheduler\PluginTask;
use pocketmine\utils\TextFormat;
class GameTask extends PluginTask
{
    private $pl;
    public function __construct(BrawlPvP $Pl){
        parent::__construct($Pl);
        $this->pl = $Pl;
    }
    public function onRun($currentTick){
        $win = 0;
        if(count($this->pl->brawl) <= 0){
            $this->pl->getServer()->getScheduler()->cancelTask($this->getTaskId());
            $this->pl->running = false;
            unset($this->pl->brawl);
            unset($this->pl->cnt);
        }
        foreach($this->pl->cnt as $pl=>$count){
            if($win < $count){
                $win = $count;
            }
            if(isset($this->pl->brawl[$pl])){
                foreach($this->pl->brawl as $p){
                    $w = $this->pl->brawl[$pl];
                    $this->pl->getServer()->broadcastMessage(TextFormat::GREEN."[CL-BrawlArena] Game is open.");
                    $p->teleport(new Position($this->pl->lx,$this->pl->ly,$this->pl->lz,$this->pl->llvl),0,0);
                    $this->pl->pay($w,$this->pl->amt,$this->pl->money);
                    $this->pl->getServer()->getScheduler()->cancelTask($this->getTaskId());
                    $p->sendMessage(TextFormat::GREEN."[BrawlPvP] ".$w->getName()." won the game with ".$win." kills.");
                    break;
                }
            }
            $this->pl->running = false;
            unset($this->pl->brawl);
            unset($this->pl->cnt);
        }
