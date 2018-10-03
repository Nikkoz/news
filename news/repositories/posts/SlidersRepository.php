<?php
namespace news\repositories\posts;

use news\entities\posts\slider\Sliders;

class SlidersRepository
{
    public function get($id): Sliders
    {
        if(!$slider = Sliders::findOne($id)) {
            throw new \DomainException('Slider is not found.');
        }

        return $slider;
    }

    public function save(Sliders $slider): void
    {
        if(!$slider->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Sliders $slider): void
    {
        if(!$slider->delete()){
            throw new \RuntimeException('Removing error.');
        }
    }
}