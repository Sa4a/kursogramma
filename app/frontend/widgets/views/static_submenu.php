<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 08.04.2020
 * Time: 12:07
 */

 if(is_array($menuItems) && count($menuItems)):?>

     <div class="content_block catalog_menu">
         <div class="content_block_header">
             <span class="content_block_title"><?=Yii::$app->domain->getPageParamByCode('header01')?></span>
         </div>
         <div class="content_block_content">
             <ul class="editor-sort level_1" data-template-path="pages.iditem._parameter.sort">
                 <?php foreach($menuItems as $item):?>
                 <?php if($item['label'] && $item['url']):?>
                 <li>
                        <a href="<?=$item['url']?>"><?=$item['label']?></a>
                 </li>
                 <?php endif; ?>
                 <?php endforeach; ?>
             </ul>
         </div>
     </div>

 <?php endif; ?>
