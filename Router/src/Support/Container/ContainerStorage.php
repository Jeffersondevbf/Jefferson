<?php

namespace Jefferson\Router\Support\Container;

use Exception;

/**
 * @author Jefferson Silva Santos
 */
abstract class ContainerStorage
{
    private array $storage;

    private array $openContainers;

    private array $closedContainers;

    public function __construct()
    {
        $this->openContainers = [];
        $this->closedContainers = [];
        $this->storage = [];
    }

    protected function createNewContainer(string $container, $closed = true): int
    {
        $container = str_replace(" ", "",$container);
        $status = 406;
        if (!key_exists($container, $this->storage)){
            $this->storage[$container] = ["close" => $closed];
            if ($closed){
                $this->closedContainers[$container]['content'] = [];
            }
            if (!$closed){
                $this->openContainers[$container]['content'] = [];
            }
            $status = 201;
        }
        return $status;
    }

    public function openContainer(string $container): int
    {
        $status = 204;
        if (key_exists($container,$this->storage)){
            if ($this->storage[$container]['close']){
                if (key_exists($container,$this->closedContainers)){
                    $this->openContainers[$container] = $this->closedContainers[$container];
                    unset($this->closedContainers[$container]);
                    $this->storage[$container]['close'] = false;
                }
            }
            $status = 200;
        }
        return  $status;
    }

    public function removeContainer(string $container): int
    {
        $status = 304;
        if (key_exists($container,$this->storage)){
            if ($this->storage[$container]['close']){
               unset($this->closedContainers[$container]);
            }
            if (!$this->storage[$container]['close']){
                unset($this->openContainers[$container]);
            }
            unset($this->storage[$container]);
            $status = 200;
        }
        return $status;
    }

    /**
     * @throws Exception
     */
    public function addContent(string $container, mixed $content, $overwrite = false): array
    {
        $array = [];
        if (!key_exists($container, $this->storage)) throw new Exception('container not exist');
        if ($this->storage[$container]['close']) throw new Exception('container is closed');
        if (!is_array($content)){
            $this->openContainers[$container]['content'][] = $content;
            $array['status'] =  200;
            $array['content'] = 'Ok';
        }
        if(is_array($content)){
            $intersect = array_intersect_key($this->openContainers[$container]['content'],$content);
            if (!empty($intersect) && $overwrite) {
                $this->openContainers[$container]['content'] += $content;
                $array['status'] = 200;
                $array['content'] = 'Ok';
            }
            if (!empty($intersect) && !$overwrite){
                $array['status'] =  406;
                $array['content'] = ["Not Acceptable" => array_keys($intersect)];
            }
            if (empty($intersect)){
                $this->openContainers[$container]['content'] += $content;
                $array['status'] = 200;
                $array['content'] = 'Ok';
            }
        }
        return $array;
    }

    public function catchContainers(): array
    {
        return $this->storage;
    }

    public function catchOpenContainers(): array
    {
        return $this->openContainers;
    }

    public function catchClosedContainers(): array
    {
        return $this->closedContainers;
    }
}