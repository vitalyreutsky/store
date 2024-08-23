<?php

namespace App\Acf\Blocks\General;

use App\Acf\Blocks\Helpers\Block;
use App\Acf\Blocks\RegisterBlock;

final class Hero implements \App\Acf\Blocks\Helpers\BlockItem
{

    public static function setBlockParams(): void
    {
        RegisterBlock::addBlock(
            new Block(
                'hero',
                'Hero',
                'Hero block',
                'templates/blocks/hero.php',
                '',
                '',
                array(
                    'align' => false,
                    'mode'  => false,
                    'jsx'   => true,
                    'anchor' => true,
                ),
                array(
                    'title'       => "Hero block",
                    'description' => "Hero block"
                ),
                'block-default',
                'mytheme'
            )
        );
    }
}
